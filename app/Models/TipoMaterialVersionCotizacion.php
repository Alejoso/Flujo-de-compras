<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipoMaterialVersionCotizacion extends Model
{
    protected $table = 'tipo_material_version_cotizaciones';
    /**
     * TIPO MATERIAL VERSION COTIZACION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['cantidad'] - float - contains the quantity of the material in this version
     * $this->attributes['versionCotizacionId'] - int - contains the foreign key of the quotation version
     * $this->attributes['tipoMaterialId'] - int - contains the foreign key of the type material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->versionCotizacion - VersionCotizacion - contains the quotation version associated
     * $this->tipoMaterial - TipoMaterial - contains the type material associated
     */
    protected $fillable = [
        'cantidad',
        'versionCotizacionId',
        'tipoMaterialId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // cantidad
    public function getCantidad(): float
    {
        return $this->attributes['cantidad'];
    }

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

    public function tipoMaterial(): BelongsTo
    {
        return $this->belongsTo(TipoMaterial::class, 'tipoMaterialId');
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

    public function getTipoMaterial(): TipoMaterial
    {
        return $this->tipoMaterial;
    }

    public function setTipoMaterial(TipoMaterial $tipoMaterial): void
    {
        $this->tipoMaterial = $tipoMaterial;
    }
}
