<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresentacionTipoMaterial extends Model
{
    protected $table = 'presentacion_tipo_materiales';

    /**
     * PRESENTACION TIPO MATERIAL ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['cantidadPresentacion'] - int - contains the number of base units per presentation
     * $this->attributes['presentacionId'] - int - contains the foreign key of the presentation
     * $this->attributes['tipoMaterialId'] - int - contains the foreign key of the type material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->presentacion - Presentacion - contains the presentation associated
     * $this->tipoMaterial - TipoMaterial - contains the type material associated
     * $this->presentacionTipoMaterialVersionCotizaciones - PresentacionTipoMaterialVersionCotizacion[]
     * $this->presentacionTipoMaterialFacturas - PresentacionTipoMaterialFactura[]
     */
    protected $fillable = [
        'cantidadPresentacion',
        'presentacionId',
        'tipoMaterialId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // cantidadPresentacion
    public function getCantidadPresentacion(): string
    {
        return $this->attributes['cantidadPresentacion'];
    }

    public function setCantidadPresentacion(string $cantidadPresentacion): void
    {
        $this->attributes['cantidadPresentacion'] = $cantidadPresentacion;
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
    public function presentacion(): BelongsTo
    {
        return $this->belongsTo(Presentacion::class, 'presentacionId');
    }

    public function tipoMaterial(): BelongsTo
    {
        return $this->belongsTo(TipoMaterial::class, 'tipoMaterialId');
    }

    public function presentacionTipoMaterialVersionCotizaciones(): HasMany
    {
        return $this->hasMany(PresentacionTipoMaterialVersionCotizacion::class, 'presentacionTipoMaterialId');
    }

    public function presentacionTipoMaterialFacturas(): HasMany
    {
        return $this->hasMany(PresentacionTipoMaterialFactura::class, 'presentacionTipoMaterialId');
    }

    // Relations setters and getters
    public function getPresentacion(): Presentacion
    {
        return $this->presentacion;
    }

    public function setPresentacion(Presentacion $presentacion): void
    {
        $this->presentacion = $presentacion;
    }

    public function getTipoMaterial(): TipoMaterial
    {
        return $this->tipoMaterial;
    }

    public function setTipoMaterial(TipoMaterial $tipoMaterial): void
    {
        $this->tipoMaterial = $tipoMaterial;
    }

    public function getPresentacionTipoMaterialVersionCotizaciones(): Collection
    {
        return $this->presentacionTipoMaterialVersionCotizaciones;
    }

    public function getPresentacionTipoMaterialFacturas(): Collection
    {
        return $this->presentacionTipoMaterialFacturas;
    }
}
