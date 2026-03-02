<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    public $timestamps = false; // Tienes 'fecha', no created_at/updated_at

    protected $fillable = ['usuario_id', 'total', 'estado', 'fecha'];

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detallesOrden() {
        return $this->hasOne(DetallesOrden::class, 'venta_id');
    }

    public function detallesVenta() {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}