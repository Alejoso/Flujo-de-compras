<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentacionTipoMaterialVersionCotizacion extends Model
{
    protected $table = 'presentacion_tipo_material_version_cotizaciones';

    /**
     * PRESENTACION TIPO MATERIAL VERSION COTIZACION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['cantidad'] - double - contains the quantity requested in this version
     * $this->attributes['versionCotizacionId'] - int - contains the foreign key of the quotation version
     * $this->attributes['presentacionTipoMaterialId'] - int - contains the foreign key of the presentacion tipo material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->versionCotizacion - VersionCotizacion - contains the quotation version associated
     * $this->presentacionTipoMaterial - PresentacionTipoMaterial - contains the presentation type material associated
     */
    protected $fillable = [
        'cantidad',
        'versionCotizacionId',
        'presentacionTipoMaterialId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // cantidad - double en BD, PHP no soporta double, se usa float
    public function getCantidad(): float
    {
        return $this->attributes['cantidad'];
    }

    // double en BD, PHP no soporta double, se usa float
    public function setCantidad(float $cantidad): void
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
    public function versionCotizacion(): BelongsTo
    {
        return $this->belongsTo(VersionCotizacion::class, 'versionCotizacionId');
    }

    public function presentacionTipoMaterial(): BelongsTo
    {
        return $this->belongsTo(PresentacionTipoMaterial::class, 'presentacionTipoMaterialId');
    }

    // Relations setters and getters
    public function getVersionCotizacion(): VersionCotizacion
    {
        return $this->versionCotizacion;
    }

    public function setVersionCotizacion(VersionCotizacion $versionCotizacion): void
    {
        $this->versionCotizacion = $versionCotizacion;
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
