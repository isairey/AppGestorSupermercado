<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = [
        'user_id',
        'fecha_creacion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carritoDetalles()
    {
        return $this->hasMany(CarritoDetalle::class);
    }
}