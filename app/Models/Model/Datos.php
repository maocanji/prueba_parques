<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datos extends Model
{
    use HasFactory;

    protected $table      = "datos";
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'id','email', 'municipios','departamentos',
    ];


}
