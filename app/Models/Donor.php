<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;
    protected $guarded =[
        'id'
    ];

    public function users()
    {
        # code...
        return $this->belongsTo(User::class);
    }
}
