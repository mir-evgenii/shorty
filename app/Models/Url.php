<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    public function add($short, $long, $custom)
    {
        $this->short = $short;
        $this->long = $long;
        $this->custom = $custom;
        $this->save();
    }

    public static function findLong($short)
    {
        $long = Url::where('short', $short)->first();

        return $long;
    }

    public static function findShort($long)
    {
        $short = Url::where('long', $long)
            ->where('custom', 0)
            ->first();

        return $short;
    }
}