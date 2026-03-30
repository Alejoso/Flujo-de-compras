<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialFactura extends Model
{
    /**
     * MATERIAL FACTURA ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['precio_unitario'] - float - contains the unit price of the material
     * $this->attributes['cantidad'] - int - contains the quantity of the material
     * $this->attributes['factura_id'] - int - contains the foreign key of the invoice
     * $this->attributes['tipo_material_id'] - int - contains the foreign key of the type material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->factura - Factura - contains the invoice associated
     * $this->tipoMaterial - TipoMaterial - contains the type material associated
     */
    protected $fillable = [
        'precio_unitario',
        'cantidad',
        'factura_id',
        'tipo_material_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // precio_unitario
    public function getPrecioUnitario(): float
    {
        return $this->attributes['precio_unitario'];
    }

    public function setPrecioUnitario(float $precioUnitario): void
    {
        $this->attributes['precio_unitario'] = $precioUnitario;
    }

    // cantidad
    public function getCantidad(): int
    {
        return $this->attributes['cantidad'];
    }

    public function setCantidad(int $cantidad): void
    {
        $this->attributes['cantidad'] = $cantidad;
    }

    // timestamps
    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    // Relations
    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    public function tipoMaterial(): BelongsTo
    {
        return $this->belongsTo(TipoMaterial::class);
    }

    // Relations setters and getters
    public function getFactura(): Factura
    {
        return $this->factura;
    }

    public function setFactura(Factura $factura): void
    {
        $this->factura = $factura;
    }

    public function getTipoMaterial(): TipoMaterial
    {
        return $this->tipoMaterial;
    }

    public function setTipoMaterial(TipoMaterial $tipoMaterial): void
    {
        $this->tipoMaterial = $tipoMaterial;
    }
}
