<?php

namespace App;

use App\Supports\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use DataViewer;

    protected $table = 'options';
    protected $fillable = ['name', 'key', 'value'];
}
