<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;
}
