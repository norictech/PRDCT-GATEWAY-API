<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['option_key', 'option_value'];
}
