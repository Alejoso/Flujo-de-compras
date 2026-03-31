<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo extends Model
{
    protected $table = 'tipos';
    /**
     * TIPO ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['especificacion'] - string - contains the specification of the type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->tipoMateriales - TipoMaterial[] - contains the type materials associated with this type
     * $this->unidadMedidaCantidades - UnidadMedidaCantidad[] - contains the unit-quantity entries for this type
     */
    protected $fillable = [
        'especificacion',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // especificacion
    public function getEspecificacion(): string
    {
        return $this->attributes['especificacion'];
    }

    public function setEspecificacion(string $especificacion): void
    {
        $this->attributes['especificacion'] = $especificacion;
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
        return $this->hasMany(TipoMaterial::class, 'tipoId');
    }

    public function unidadMedidaCantidades(): HasMany
    {
        return $this->hasMany(UnidadMedidaCantidad::class, 'tipoId');
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

    public function getUnidadMedidaCantidades(): Collection
    {
        return $this->unidadMedidaCantidades;
    }

    public function setUnidadMedidaCantidades(Collection $unidadMedidaCantidades): void
    {
        $this->unidadMedidaCantidades = $unidadMedidaCantidades;
    }
}
