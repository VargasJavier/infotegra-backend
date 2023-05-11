<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';

    protected function origin():Attribute {
        return Attribute::make(
            set: fn ($value) => json_encode($value),
         );
    }
}
