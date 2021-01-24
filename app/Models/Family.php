<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'timestamp'];

    public function targetsite()
    {
        # code...
        return $this->belongsTo(Targetsite::class);
    }
}
