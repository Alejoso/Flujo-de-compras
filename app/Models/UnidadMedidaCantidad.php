<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnidadMedidaCantidad extends Model
{
    protected $table = 'unidad_medida_cantidades';

    /**
     * UNIDAD MEDIDA CANTIDAD ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['cantidadId'] - int - contains the foreign key of the quantity
     * $this->attributes['unidadMedidaId'] - int - contains the foreign key of the unit of measure
     * $this->attributes['tipoId'] - int - contains the foreign key of the type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->cantidad - Cantidad - contains the quantity associated
     * $this->unidadMedida - UnidadMedida - contains the unit of measure associated
     * $this->tipo - Tipo - contains the type associated
     */
    protected $fillable = [
        'cantidadId',
        'unidadMedidaId',
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
    public function cantidad(): BelongsTo
    {
        return $this->belongsTo(Cantidad::class, 'cantidadId');
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class, 'unidadMedidaId');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipoId');
    }

    // Relations setters and getters
    public function getCantidad(): Cantidad
    {
        return $this->cantidad;
    }

    public function setCantidad(Cantidad $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function getUnidadMedida(): UnidadMedida
    {
        return $this->unidadMedida;
    }

    public function setUnidadMedida(UnidadMedida $unidadMedida): void
    {
        $this->unidadMedida = $unidadMedida;
    }

    public function getTipo(): Tipo
    {
        return $this->tipo;
    }

    public function setTipo(Tipo $tipo): void
    {
        $this->tipo = $tipo;
    }
}
