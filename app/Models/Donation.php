<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function user()
    {
        # code...
        return $this-> belongsTo(User::class);
    }

    public function agency()
    {
        # code...
        return $this->belongsTo(Agency::class);
    }
}
