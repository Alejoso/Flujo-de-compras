<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentacionTipoMaterialFactura extends Model
{
    protected $table = 'presentacion_tipo_material_facturas';

    /**
     * PRESENTACION TIPO MATERIAL FACTURA ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['precioUnitario'] - double(15,2) - contains the unit price paid
     * $this->attributes['cantidad'] - int - contains the quantity purchased
     * $this->attributes['facturaId'] - int - contains the foreign key of the invoice
     * $this->attributes['presentacionTipoMaterialId'] - int - contains the foreign key of the presentacion tipo material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->factura - Factura - contains the invoice associated
     * $this->presentacionTipoMaterial - PresentacionTipoMaterial - contains the presentation type material associated
     */
    protected $fillable = [
        'precioUnitario',
        'cantidad',
        'facturaId',
        'presentacionTipoMaterialId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // precioUnitario - double en BD, PHP no soporta double, se usa float
    public function getPrecioUnitario(): float
    {
        return $this->attributes['precioUnitario'];
    }

    // double en BD, PHP no soporta double, se usa float
    public function setPrecioUnitario(float $precioUnitario): void
    {
        $this->attributes['precioUnitario'] = $precioUnitario;
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
        return $this->belongsTo(Factura::class, 'facturaId');
    }

    public function presentacionTipoMaterial(): BelongsTo
    {
        return $this->belongsTo(PresentacionTipoMaterial::class, 'presentacionTipoMaterialId');
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

    public function getPresentacionTipoMaterial(): PresentacionTipoMaterial
    {
        return $this->presentacionTipoMaterial;
    }

    public function setPresentacionTipoMaterial(PresentacionTipoMaterial $presentacionTipoMaterial): void
    {
        $this->presentacionTipoMaterial = $presentacionTipoMaterial;
    }
}
