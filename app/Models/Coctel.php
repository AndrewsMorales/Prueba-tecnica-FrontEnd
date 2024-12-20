<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coctel extends Model
{
    use HasFactory;
    protected $table = 'cocteles';
    protected $fillable = [
        'nombre',
        'instrucciones',
        'url_imagen',
        'ingredientes',
        'idCloud',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'ingredientes' => 'array',
    ];
}
