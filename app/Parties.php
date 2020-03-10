<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parties extends Model
{
    protected $table = 'parties';
    protected $fillable = ['name', 'url', 'description'];
}
