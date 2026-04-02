<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentacion extends Model
{
    protected $table = 'presentaciones';

    /**
     * PRESENTACION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['nombre'] - string - contains the presentation name (e.g. "Rollo", "Paquete", "Unitario")
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->presentacionTipoMateriales - PresentacionTipoMaterial[] - contains the material combinations for this presentation
     */
    protected $fillable = [
        'nombre',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // nombre
    public function getNombre(): string
    {
        return $this->attributes['nombre'];
    }

    public function setNombre(string $nombre): void
    {
        $this->attributes['nombre'] = $nombre;
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
    public function presentacionTipoMateriales(): HasMany
    {
        return $this->hasMany(PresentacionTipoMaterial::class, 'presentacionId');
    }

    // Relations setters and getters
    public function getPresentacionTipoMateriales(): Collection
    {
        return $this->presentacionTipoMateriales;
    }

    public function setPresentacionTipoMateriales(Collection $presentacionTipoMateriales): void
    {
        $this->presentacionTipoMateriales = $presentacionTipoMateriales;
    }
}
