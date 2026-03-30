<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo extends Model
{
    /**
     * TIPO ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['especificacion'] - string - contains the specification of the type
     * $this->attributes['unidad_medida_id'] - int - contains the foreign key of the unit of measure
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->unidadMedida - UnidadMedida - contains the unit of measure associated with this type
     * $this->tipoMateriales - TipoMaterial[] - contains the type materials associated with this type
     */
    protected $fillable = [
        'especificacion',
        'unidad_medida_id',
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
    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class);
    }

    public function tipoMateriales(): HasMany
    {
        return $this->hasMany(TipoMaterial::class);
    }

    // Relations setters and getters
    public function getUnidadMedida(): UnidadMedida
    {
        return $this->unidadMedida;
    }

    public function setUnidadMedida(UnidadMedida $unidadMedida): void
    {
        $this->unidadMedida = $unidadMedida;
    }

    public function getTipoMateriales(): Collection
    {
        return $this->tipoMateriales;
    }

    public function setTipoMateriales(Collection $tipoMateriales): void
    {
        $this->tipoMateriales = $tipoMateriales;
    }
}
