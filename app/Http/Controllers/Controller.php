<?php

namespace App\Http\Controllers;

use App\Simulation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function stations()
    {
        return Simulation::query()
            ->selectRaw('ST_AsText(loc) as loc')
            ->distinct()
            ->get('loc')
            ->map(function ($loc) {
                return explode(
                    " ",
                    Str::between($loc, "(", ")")
                );
            })
            ->toArray();
    }
}
