<?php

namespace App\Http\Livewire;

use App\Simulation;
use Livewire\Component;

class SearchResult extends Component
{
    public $count;
    public $medians = [];
    public $mins = [];
    public $maxs = [];
    public $types = [
        'u_value' => 'Sim. U-Value (W/m2K)',
        'mould' => 'Mould (Index)',
        'algae' => 'Algae (Index)',
        'heat_loss' => 'Heat loss (W/m2/year)',
        'surface_temp' => 'Min. surface temperature (°C)',
//        'environment_impact' => 'Env. Impact (kg CO2 eq/m2)',
    ];
    public $thickness;
    public $system;
    public $lambda;
    public $material;
    public $ext;
    public $int;
    public $stations;

    public $reference = [];

    public $simulations = null;
    public $showSimulations = false;

    public $helps = [
        'u_value' => [
            'header' => 'U-value (W/(m2K))',
            'content' => 'Requirement for the simulated thermal resistance (W/(m2K)) or simulated U-value of the wall is usually specified in building regulations and based on climatic zones. A low U-value corresponds to a low heat loss. Note, the U-values is simulated parallel with the hygrothermal simulations.'
        ],
        'mould' => [
            'header' => 'Mould (index)',
            'content' => 'A number on a scale from 0 (no mould) to 6 (extensive mould growth) indicating the risk for mould growth between the existing wall and the internal insulation. This is based on a complex interaction between environmental factors (relative humidity and temperature) and duration, material properties and the characteristics of mould fungi present, using the VTT model Colour coding using green (low index), yellow (medium) and red (high) classifies the different solutions presented. The number given is the maximum value within a five-year simulation period.'
        ],
        'heat_loss' => [
            'header' => 'Heat loss (W/m2/year)',
            'content' => 'Heat loss through the external wall per m2 per year after being insulated. The lower the number, the higher the reduction compared to the situation before applying internal insulation. Heat loss is expressed for a homogenous part of the wall with no thermal bridges etc. Heat loss depends on the outdoor climate, i.e. a location in a cold climate corresponds to a high heat loss compared to a location in a warmer climate.'
        ],
        'algae' => [
            'header' => 'Algae (index)',
            'content' => 'A number on a scale from 0 (no algae) to 1 (full coverage) indicating the share of the exterior surface covered by algae. This is based on a complex interaction between environmental factors (relative humidity and temperature) and duration, and surface properties (porosity, roughness), based on Avrami’s law improved into a modified model. Colour coding using green (low index), yellow (medium) and red (high) classifies the different solutions presented. The number given is the maximum value within a five-year simulation period.'
        ],
        'surface_temp' => [
            'header' => 'Min. surface temperature (°C)',
            'content' => 'Minimum temperature (°C) of the interior surface of the walls achieved within a five-year simulation period. The lower the temperature, the higher the risk of mould growth or condensation. The critical surface temperature depends on the location of the building and the indoor climate. The simulations are based on indoor climate EN 15026 class A and B. In both cases indoor temperature goes from 20 C at 10 C outdoor to 25 C at 20 C outdoor. No change below 10 C outdoor or above 20 C outdoor. Class A: Relative humidity goes from 35 % at -10 C outdoor to 65 % at 20 C outdoor. Class B: From 40 % to 70 %. No change below -10 C and above 20 C.
            '
        ],
        'environment_impact' => [
            'header' => 'Environmental impact',
            'content' => 'dropped'
        ]
    ];

    public function mount($result, $reference)
    {
        $this->count = $result->count;
        $this->thickness = $result->insulation_thickness;
        $this->system = $result->insulation_system;
        $this->lambda = $result->lambda_value;
        $this->material = $result->wall_material;
        $this->ext = $result->ext_plaster;
        $this->int = $result->int_plaster;
        $this->stations = $result->stations;

        $oneDecimal = ['mould', 'surface_temp', 'algae'];

        foreach ($this->types as $type => $label) {
            $round = in_array($type, $oneDecimal)
                ? fn($x) => round($x, 1)
                : fn($x) => $x;
            $this->medians[$type] = $round($result->$type);
            $min = $type . '_min';
            $max = $type . '_max';
            $this->mins[$type] = $round($result->$min);
            $this->maxs[$type] = $round($result->$max);
            if ($reference && $this->system !== 'None') {
                $this->reference[$type] = $reference->$type;
            }
        }
    }

    public function toggleExpand()
    {
        $distance = request('stations', 50);
        $this->simulations = Simulation::query()
            ->where('insulation_system', $this->system)
            ->where('lambda_value', $this->lambda)
            ->where('insulation_thickness', $this->thickness)
            ->where('wall_material', $this->material)
            ->where('ext_plaster', $this->ext)
            ->where('int_plaster', $this->int)
            ->when(request('thickness'), fn($query) => $query->whereBetween('wall_width', explode(',', request('thickness'))))
            ->when(request('orientation'), fn($query) => $query->whereBetween('orientation', explode(',', request('orientation'))))
            ->when(
                ($lat = request('lat')) && ($lng = request('lng')),
                fn($q) => $q->whereRaw(
                    "st_distance_sphere(POINT({$lng}, {$lat}), loc) < {$distance}000"
                )
            )
            ->get();
    }

    public function render()
    {
        return view('livewire.search-result', [
            'simulations' => $this->simulations,
            'color' => $this->makeColor(),
        ]);
    }

    public function makeColor()
    {
        return function ($type, $value) {
            if (in_array($type, ['u_value', 'heat_loss', 'surface_temp'])) {
                return '#000';
            }

            $rgbColor1 = [
                'red' => 19, 'green' => 233, 'blue' => 19,
            ];
            $rgbColor2 = [
                'red' => 243, 'green' => 114, 'blue' => 32,
            ];
            $rgbColor3 = [
                'red' => 255, 'green' => 0, 'blue' => 0,
            ];

            $faceMap = [
                'u_value' => [0, 3],
                'mould' => [1, 4],
                'algae' => [0.1, 0.5],
                'heat_loss' => [500, 5000],
                'surface_temp' => [0, 30],
                'environment_impact' => [0, 100],
            ];
            $fadeFraction = $value / (
                    $faceMap[$type][1] - $faceMap[$type][0]
                );

            // https://stackoverflow.com/a/61396704
            $color1 = $rgbColor1;
            $color2 = $rgbColor2;
            $fade = $fadeFraction;

            // Do we have 3 colors for the gradient? Need to adjust the params.
            if ($rgbColor3) {
                $fade = $fade * 2;

                // Find which interval to use and adjust the fade percentage
                if ($fade >= 1) {
                    $fade -= 1;
                    $color1 = $rgbColor2;
                    $color2 = $rgbColor3;
                }
            }

            $diffRed = $color2['red'] - $color1['red'];
            $diffGreen = $color2['green'] - $color1['green'];
            $diffBlue = $color2['blue'] - $color1['blue'];

            $gradient = [
                'red' => (int)(floor($color1['red'] + ($diffRed * $fade))),
                'green' => (int)(floor($color1['green'] + ($diffGreen * $fade))),
                'blue' => (int)(floor($color1['blue'] + ($diffBlue * $fade))),
            ];

            return 'rgb(' . $gradient['red'] . ',' . $gradient['green'] . ',' . $gradient['blue'] . ')';
        };
    }
}
