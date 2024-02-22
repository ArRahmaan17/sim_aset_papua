<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    use HasFactory;
    protected $table = 'bap';

    static function getAllOrganizationBaps()
    {
        $copied = clone (session('organisasi'));
        unset($copied->organisasi, $copied->wajibsusut);
        return self::where((array)$copied)->get();
    }
}
