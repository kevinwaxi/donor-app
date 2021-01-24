<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Targetsite extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function family()
    {
        # code...
        return $this->hasMany(Family::class);
    }

}
