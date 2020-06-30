<?php

namespace App\Http\Livewire;

use App\Location;
use App\Simulation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class App extends Component
{
    public $material = 'brick';
    public $internal = true;
    public $external = true;
    public $thickness;
    public $orientation = '0,360';

    public $address;
    public $insulation = [];
    public $insulationThickness = '10,150';

    // priorities
    public $u_value = 50;
    public $mould = 50;
    public $algae = 50;
    public $heat_loss = 50;
    public $surface_temp = 50;
    public $environment_impact = 50;

    public $lat;
    public $lng;
    public $stations = 50;

    protected $updatesQueryString = [
        'material',
        'internal',
        'external',
        'lat', 'lng',
        'stations',
        'insulation',
        'insulationThickness',

        'thickness',
        'orientation',

        'u_value',
        'mould',
        'algae',
        'heat_loss',
        'surface_temp',
//        'environment_impact',
    ];
    protected $listeners = ['setLocation'];

    public function setLocation($data)
    {
        $json = json_decode($data);
        $this->lat = $json->lat;
        $this->lng = $json->lng;
    }

    /**
     * Nasty fix.
     */
    protected $fix = [];
    protected $fixers = [
        'insulationThickness',
        'thickness',
        'orientation',
    ];

    public function updating($name, $value)
    {
        if (in_array($name, $this->fixers) && !Str::contains($value, ',')) {
            $this->fix[$name] = $this->{$name};
        }
    }

    public function updated($name, $value)
    {
        if (in_array($name, $this->fixers) && isset($this->fix[$name])) {
//            if (Str::contains($this->fix[$name], ',')) {
//                $this->{$name} = implode(',',
//                    [
//                        $this->{$name},
//                        explode(',', $this->fix[$name])[1]
//                    ]
//                );
//            } else {
            $this->{$name} = $this->fix[$name];
//            }
            $this->fix[$name] = null;
        }
    }

    /**
     * Nasty fix end.
     */
    public function updatedAddress($value)
    {
        $this->emit('addressChanged', $value);
    }

    protected function getGroupedQuery($withKey = false)
    {
        $groups = [
            'insulation_thickness',
            'insulation_system',
            'lambda_value',
            'wall_material',
            'ext_plaster',
            'int_plaster',
        ];
        $query = Simulation::query();
        foreach ($groups as $group) {
            $query->groupBy($group);
        }

        if ($withKey) {
            $query->selectRaw('CONCAT(' . implode(',', $groups) . ') as _key');
            $query->addSelect($groups);
        }

        return $query;
    }

    public function searchResults()
    {
//        start_measure('searchResults');
        $query = $this->getGroupedQuery(true);
        $query
            ->when($this->material, fn($query) => $query->where('wall_material', $this->material))
            ->where('int_plaster', $this->internal == 'true')
            ->where('ext_plaster', $this->external == 'true');

        $query->where(function ($query) {
            $query->where(function (Builder $query) {
                $query->whereIn(DB::raw("CONCAT(insulation_system,'$',lambda_value)"), collect($this->insulation)->reject(fn($v) => $v === 'None')->all());
                $query->whereBetween('insulation_thickness', explode(',', $this->insulationThickness));
            });
            $query->when(
                in_array('None', $this->insulation),
                fn($query) => $query->orWhere(function ($query) {
                    $query->where('insulation_system', 'None');
                })
            );
        });
        $query->where(function ($query) {
            $query->whereBetween('wall_width', explode(',', $this->thickness));
            $query->whereBetween('orientation', explode(',', $this->orientation));
        });

        $sorts = [
            'u_value',
            'mould',
            'algae',
            'heat_loss',
            'surface_temp',
//            'environment_impact',
        ];

        foreach ($sorts as $sort) {
            $query->selectRaw("ROUND(AVG({$sort}), 2) as {$sort}")
                ->selectRaw("ROUND(MIN({$sort}), 2) as {$sort}_min")
                ->selectRaw("ROUND(MAX({$sort}), 2) as {$sort}_max");
        }

        if ($this->lat && $this->lng) {
            // st_distance_sphere(POINT(-73.9949,40.7501), POINT( -73.9961,40.7542))
            $cities = Location::query()
                ->select('id')
                ->whereRaw("st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc) < {$this->stations}000")
                ->get('id')
                ->pluck('id');

            $query->whereIn('city', $cities);

//            $query->whereHas('location', function ($query) {
//                $query->whereRaw(
//                    "st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc) < {$this->stations}000"
//                );
//            });

//            $query->where(function ($query) {
//                $query->whereRaw(
//                    "st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc) < {$this->stations}000"
//                )
//                    ->orWhereRaw("
//                    st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc) <= (
//                        select st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc)
//                        from simulations
//                        group by loc
//                        order by st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc) asc
//                        limit 1 offset {$offset}
//                    )
//                ")
            ;
//            });
        }

        $query->addSelect([
            \DB::raw('COUNT(id) as count'),
            \DB::raw('COUNT(DISTINCT city) as stations')
        ]);

        $paginator = $query->paginate(33);
        $sortSum = collect($sorts)->map(fn($sort) => $this->{$sort})->sum();
        $result = [];

//        start_measure('paginator');

        if ($paginator->total()) {
            $result = collect($paginator->items());
            $sums = collect($sorts)->mapWithKeys(function ($sort) use ($result) {
                return [$sort => $result->sum($sort)];
            });
            $result = $result
                ->map(function ($card) use ($sums, $sorts, $sortSum) {
                    $card->weight = 0;
                    foreach ($sorts as $sort) {
                        $weight = ((float)$this->{$sort}) / $sortSum;
                        if ($sums[$sort] > 0) {
                            $card->weight += $weight * $card[$sort] / $sums[$sort];
                        }
                    }

                    $card->heat_loss = (int)$card->heat_loss;

                    return $card;
                })
                ->sortBy(function ($card) {
                    return $card->insulation_thickness === 0
                        ? - 1
                        : $card->weight;
                });
        }

        $reference = null;
        if ($result && $result->first()->insulation_system === 'None') {
            $reference = $result->first();
        }

//        stop_measure('paginator');
//        stop_measure('searchResults');

        return [
            'stations' => $this->stations,
            'resultCount' => $paginator->total(),
            'results' => $result,
            'reference' => $reference
        ];
    }

    public function mount()
    {
        foreach ($this->getUpdatesQueryString() as $field) {
            $this->{$field} = request($field) ?? $this->{$field};
        }
    }

    public function getDataRanges()
    {
//        start_measure('getDataRanges');
        $res = Cache::remember('dataRanges', now()->addHour(), function () {
            return [
                'wallThickness' => Simulation::query()
                    ->selectRaw('MIN(wall_width) as min, MAX(wall_width) as max')
                    ->get('min', 'max')->first()->toArray(),
                'wallOrientation' => Simulation::query()
                    ->selectRaw('MIN(orientation) as min, MAX(orientation) as max')
                    ->get('min', 'max')->first()->toArray(),

                'insulationSystems' => $this->insulationSystems(),
            ];
        });

//        start_measure('closestDistance');
        $res['minDistance'] = $this->lng && $this->lat
            ? Location::query()
                ->selectRaw("min(st_distance_sphere(POINT({$this->lng}, {$this->lat}), loc)) as dist")
                ->toBase()->first()->dist
            : null;

//        stop_measure('closestDistance');
//        stop_measure('getDataRanges');
        return $res;
    }

    public function render()
    {
        $dataRanges = $this->getDataRanges();
        // set thickness
        if (!$this->thickness) {
            $this->thickness = implode(',', $dataRanges['wallThickness']);
        }
        // set insulation system
        if (!$this->insulation || empty($this->insulation)) {
            $this->insulation = array_keys($dataRanges['insulationSystems']);
        }

        return view('livewire.app', [
                'totalCount' => Cache::remember('result-count', now()->addHour(), fn() => $this->getGroupedQuery()->count()),
                'types' => [
                    'u_value' => 'U-Value',
                    'mould' => 'Mould',
                    'algae' => 'Algae',
                    'heat_loss' => 'Heat loss',
                    'surface_temp' => 'Surface temperature',
//                    'environment_impact' => 'Environment impact',
                ],
            ] + $this->searchResults() + $dataRanges);
    }

    private function insulationSystems()
    {
        return Cache::remember('insulation-systems', now()->addHour(), function () {
            return Simulation::query()
                ->groupBy('insulation_system', 'lambda_value')
                ->toBase()
                ->get(['insulation_system', 'lambda_value'])
                ->mapWithKeys(function ($sim) {
                    $k = $sim->insulation_system === 'None' ? 'None' : $sim->insulation_system . '$' . $sim->lambda_value;
                    return [
                        $k => $sim->insulation_system === 'None'
                            ? 'Reference - no insulation'
                            : $sim->insulation_system . ' λ=' . $sim->lambda_value . ' W/(mK)',
                    ];
                })
                ->sortBy(function ($v, $k) {
                    return $k === 'None' ? 0 : 1 . $v;
                })
                ->all();
        });
    }
}
