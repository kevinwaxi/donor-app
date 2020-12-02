<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function donation()
    {
        # code...
        return $this->hasMany(Donation::class);
    }
}
