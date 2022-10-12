<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $guarded = []; //dozvoljava upis u bazu, nista ne branimo


    public function category()
    {
        return $this->belongsTo("\App\Models\Category"); //vraćamo kategoriju kojoj pripada oglas
    }

    public function user()
    {
        return $this->belongsTo("\App\Models\User"); //želimo da znamo vlasnika oglasa
    }
}
