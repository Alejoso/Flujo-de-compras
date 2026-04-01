<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMaterial extends Model
{
    protected $table = 'tipo_materiales';

    /**
     * TIPO MATERIAL ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['materialId'] - int - contains the foreign key of the material
     * $this->attributes['tipoId'] - int - contains the foreign key of the type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->material - Material - contains the material associated
     * $this->tipo - Tipo - contains the type associated
     * $this->materialFacturas - MaterialFactura[] - contains the invoice materials associated
     * $this->tipoMaterialVersionCotizaciones - TipoMaterialVersionCotizacion[] - contains the quotation version materials associated
     */
    protected $fillable = [
        'materialId',
        'tipoId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
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
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'materialId');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipoId');
    }

    public function materialFacturas(): HasMany
    {
        return $this->hasMany(MaterialFactura::class, 'tipoMaterialId');
    }

    public function tipoMaterialVersionCotizaciones(): HasMany
    {
        return $this->hasMany(TipoMaterialVersionCotizacion::class, 'tipoMaterialId');
    }

    // Relations setters and getters
    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function setMaterial(Material $material): void
    {
        $this->material = $material;
    }

    public function getTipo(): Tipo
    {
        return $this->tipo;
    }

    public function setTipo(Tipo $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getMaterialFacturas(): Collection
    {
        return $this->materialFacturas;
    }

    public function setMaterialFacturas(Collection $materialFacturas): void
    {
        $this->materialFacturas = $materialFacturas;
    }

    public function getTipoMaterialVersionCotizaciones(): Collection
    {
        return $this->tipoMaterialVersionCotizaciones;
    }

    public function setTipoMaterialVersionCotizaciones(Collection $tipoMaterialVersionCotizaciones): void
    {
        $this->tipoMaterialVersionCotizaciones = $tipoMaterialVersionCotizaciones;
    }
}
