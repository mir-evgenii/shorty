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

    public static function findShort($short)
    {
        $url = Url::where('short', $short)->first();

        return $url;
    }

    public static function findLong($long)
    {
        $url = Url::where('long', $long)
            ->where('custom', 0)
            ->first();

        return $url;
    }
}
