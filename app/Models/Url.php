<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    function add($short, $long, $custom)
    {
        $this->short = $short;
        $this->long = $long;
        $this->custom = $custom;
        $this->save();
    }
}