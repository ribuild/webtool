<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'ext_plaster' => 'bool',
        'int_plaster' => 'bool',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'city');
    }
}
