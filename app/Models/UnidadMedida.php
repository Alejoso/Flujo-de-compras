<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadMedida extends Model
{
    protected $table = 'unidad_medidas';
    /**
     * UNIDAD MEDIDA ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['nombre'] - string - contains the name of the unit
     * $this->attributes['abreviatura'] - string - contains the abbreviation of the unit
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->unidadMedidaCantidades - UnidadMedidaCantidad[] - contains the unit-quantity entries for this unit
     */
    protected $fillable = [
        'nombre',
        'abreviatura',
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

    // abreviatura
    public function getAbreviatura(): string
    {
        return $this->attributes['abreviatura'];
    }

    public function setAbreviatura(string $abreviatura): void
    {
        $this->attributes['abreviatura'] = $abreviatura;
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
    public function unidadMedidaCantidades(): HasMany
    {
        return $this->hasMany(UnidadMedidaCantidad::class, 'unidadMedidaId');
    }

    // Relations setters and getters
    public function getUnidadMedidaCantidades(): Collection
    {
        return $this->unidadMedidaCantidades;
    }

    public function setUnidadMedidaCantidades(Collection $unidadMedidaCantidades): void
    {
        $this->unidadMedidaCantidades = $unidadMedidaCantidades;
    }
}
