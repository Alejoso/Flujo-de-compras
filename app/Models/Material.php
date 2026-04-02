<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $table = 'materiales';

    /**
     * MATERIAL ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['descripcion'] - string - contains the description of the material
     * $this->attributes['presentacionId'] - int|null - contains the optional foreign key of the presentation
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->tipoMateriales - TipoMaterial[] - contains the type materials associated with this material
     * $this->presentacion - Presentacion|null - contains the optional presentation associated
     */
    protected $fillable = [
        'descripcion',
        'presentacionId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // descripcion
    public function getDescripcion(): string
    {
        return $this->attributes['descripcion'];
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->attributes['descripcion'] = $descripcion;
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
    public function tipoMateriales(): HasMany
    {
        return $this->hasMany(TipoMaterial::class, 'materialId');
    }

    public function presentacion(): BelongsTo
    {
        return $this->belongsTo(Presentacion::class, 'presentacionId');
    }

    // Relations setters and getters
    public function getTipoMateriales(): Collection
    {
        return $this->tipoMateriales;
    }

    public function setTipoMateriales(Collection $tipoMateriales): void
    {
        $this->tipoMateriales = $tipoMateriales;
    }

    public function getPresentacion(): ?Presentacion
    {
        return $this->presentacion;
    }

    public function setPresentacion(?Presentacion $presentacion): void
    {
        $this->presentacion = $presentacion;
    }
}
