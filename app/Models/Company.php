<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    static function getAll(){
        return self::get();
    }

    static function getName($name){
        return self::where('name', '=', $name)->first();
    }
}
