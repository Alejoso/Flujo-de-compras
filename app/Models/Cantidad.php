<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cantidad extends Model
{
    protected $table = 'cantidades';

    /**
     * COTIZACION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['numero'] - string - contains in which quantity the material could be registered
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     */
    protected $fillable = [
        'numero',
    ];

    // Id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getNumero(): string
    {
        return $this->attributes['numero'];
    }

    public function setNumero(string $numero): void
    {
        $this->attributes['numero'] = $numero;
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
        return $this->hasMany(UnidadMedidaCantidad::class, 'cantidadId');
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
