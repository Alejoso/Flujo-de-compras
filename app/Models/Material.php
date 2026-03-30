<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    /**
     * MATERIAL ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['descripcion'] - string - contains the description of the material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->tipoMateriales - TipoMaterial[] - contains the type materials associated with this material
     */
    protected $fillable = [
        'descripcion',
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
        return $this->hasMany(TipoMaterial::class);
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
}
