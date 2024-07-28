<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGeojson extends Model
{
    use HasFactory;

    protected $table = 'data_geojsons';

    protected $guarded = ['id'];

}
