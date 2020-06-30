<?php

namespace App\Console\Commands;

use App\Simulation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportSimulations extends Command
{
    protected $signature = 'import:simulations {file}';

    protected $description = 'Imports a CSV export from MongoDB to MySQL';

    public function handle()
    {
        if (!file_exists($this->argument('file'))) {
            $this->error('The file could not be found!');

            return;
        }
        $this->info('Importing..');

        $systemMap = [
            'NoInsulation' => 'None',
            'MineralFoamMulltipor' => 'Calcium Silicate',
            'ClimateBoard' => 'Calcium Silicate',
            'CalciumSilicateBoard' => 'Calcium Silicate',
            'PolyurethaneFoam' => 'Polyurethane Foam',
            'MineralWool32' => 'Mineral Wool',
            'PhenolicFoam' => 'Phenolic Foam',
            'CasiPlus' => 'Calcium Silicate',
            'iQ-Therm' => 'PUR foam with CaSi channels',
        ];

        DB::beginTransaction();
        (new FastExcel)
            ->configureCsv("\t", '"', '\n')
            ->import($this->argument('file'), function ($line) use ($systemMap) {
                $line['id'] = $line['_id'];
                $line['surface_temp'] = $line['min_surface_temp'];
                unset($line['delphin'], $line['_id'], $line['avg_surface_temp'], $line['min_surface_temp']);
                $line['ext_plaster'] = $line['ext_plaster'] == 'true';
                $line['int_plaster'] = $line['int_plaster'] == 'true';

                $line['wall_width'] = ceil((float)$line['wall_width'] * 1000);
                $line['insulation_thickness'] = $line['insulation_thickness'] == '' ? 0 : $line['insulation_thickness'];
                $line['insulation_system'] = $line['insulation_system'] == '' ? 'NoInsulation' : $line['insulation_system'];
                $line['insulation_system'] = $systemMap[$line['insulation_system']] ?? $line['insulation_system'];

                if ($line['lambda_value'] === '') {
                    $line['lambda_value'] = null;
                }
                if ($line['heat_loss'] === 'NaN') {
                    $line['heat_loss'] = null;
                }

                $p = explode(',', preg_replace('#\{"type.+? \[(.+)\]\}#', '$1', $line['loc']));
                // POINT(lng, lat)
                $value = 'POINT(' . implode(' ', array_reverse($p)) . ')';
                $loc = \DB::raw("(ST_GeomFromText('{$value}'))");
                $line['loc'] = $loc;

                foreach (['algae', 'surface_temp'] as $k) {
                    if ($line[$k] === '' || $line[$k] === - 1 || $line[$k] == '-1' || $line == - 1.0) {
                        $line[$k] = null;
                    }
                }
                if ($line['surface_temp'] < 0) {
                    $line['surface_temp'] = abs($line['surface_temp']);
                }
                $line['environment_impact'] = 99;

                Simulation::updateOrCreate(['id' => $line['id']], $line);
            });
        DB::commit();

        \DB::statement('INSERT IGNORE INTO locations (id, loc) SELECT DISTINCT city, loc FROM simulations;');

        $this->info('Done.');
    }
}
