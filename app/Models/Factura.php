<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    /**
     * FACTURA ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['valor_total'] - int - contains the total value of the invoice
     * $this->attributes['estado'] - string - contains the state of the invoice
     * $this->attributes['proyecto_id'] - int - contains the foreign key of the project
     * $this->attributes['cotizacion_id'] - int|null - contains the foreign key of the quotation
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->proyecto - Proyecto - contains the project associated
     * $this->cotizacion - Cotizacion|null - contains the quotation associated
     * $this->materialFacturas - MaterialFactura[] - contains the invoice materials associated
     */
    protected $fillable = [
        'valor_total',
        'estado',
        'proyecto_id',
        'cotizacion_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // valor_total
    public function getValorTotal(): int
    {
        return $this->attributes['valor_total'];
    }

    public function setValorTotal(int $valorTotal): void
    {
        $this->attributes['valor_total'] = $valorTotal;
    }

    // estado
    public function getEstado(): string
    {
        return $this->attributes['estado'];
    }

    public function setEstado(string $estado): void
    {
        $this->attributes['estado'] = $estado;
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
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function materialFacturas(): HasMany
    {
        return $this->hasMany(MaterialFactura::class);
    }

    // Relations setters and getters
    public function getProyecto(): Proyecto
    {
        return $this->proyecto;
    }

    public function setProyecto(Proyecto $proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    public function getCotizacion(): ?Cotizacion
    {
        return $this->cotizacion;
    }

    public function setCotizacion(?Cotizacion $cotizacion): void
    {
        $this->cotizacion = $cotizacion;
    }

    public function getMaterialFacturas(): Collection
    {
        return $this->materialFacturas;
    }

    public function setMaterialFacturas(Collection $materialFacturas): void
    {
        $this->materialFacturas = $materialFacturas;
    }
}
