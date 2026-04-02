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
     * $this->attributes['nombre'] - string - contains the presentation name (e.g. "Rollo", "Caja", "Carreta")
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->materiales - Material[] - contains the materials that use this presentation
     */
    protected $fillable = [
        'nombre',
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

    // Attributes
    public function getNombre(): string
    {
        return $this->attributes['nombre'];
    }

    public function setNombre(string $nombre): void
    {
        $this->attributes['nombre'] = $nombre;
    }

    // Relations
    public function materiales(): HasMany
    {
        return $this->hasMany(Material::class, 'presentacionId');
    }

    // Relations setters and getters
    public function getMateriales(): Collection
    {
        return $this->materiales;
    }

    public function setMateriales(Collection $materiales): void
    {
        $this->materiales = $materiales;
    }
}
