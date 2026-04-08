<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    protected $table = 'facturas';

    /**
     * FACTURA ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['valorTotal'] - int - contains the total value of the invoice
     * $this->attributes['estado'] - enum('Pendiente', 'Aprobada', 'Rechazada', 'Pagada', 'Cancelada') - contains the state of the invoice
     * $this->attributes['proyectoId'] - int - contains the foreign key of the project
     * $this->attributes['proveedorId'] - int - contains the foreign key of the supplier
     * $this->attributes['cotizacionId'] - int - contains the foreign key of the quotation
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->proyecto - Proyecto - contains the project associated
     * $this->proveedor - Proveedor - contains the supplier associated
     * $this->cotizacion - Cotizacion|null - contains the quotation associated
     * $this->presentacionTipoMaterialFacturas - PresentacionTipoMaterialFactura[]
     */
    protected $fillable = [
        'valorTotal',
        'estado',
        'proyectoId',
        'proveedorId',
        'cotizacionId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // valorTotal
    public function getValorTotal(): int
    {
        return $this->attributes['valorTotal'];
    }

    public function setValorTotal(int $valorTotal): void
    {
        $this->attributes['valorTotal'] = $valorTotal;
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
        return $this->belongsTo(Proyecto::class, 'proyectoId');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedorId');
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacionId');
    }

    public function presentacionTipoMaterialFacturas(): HasMany
    {
        return $this->hasMany(PresentacionTipoMaterialFactura::class, 'facturaId');
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

    public function getProveedor(): Proveedor
    {
        return $this->proveedor;
    }

    public function setProveedor(Proveedor $proveedor): void
    {
        $this->proveedor = $proveedor;
    }

    public function getCotizacion(): ?Cotizacion
    {
        return $this->cotizacion;
    }

    public function setCotizacion(?Cotizacion $cotizacion): void
    {
        $this->cotizacion = $cotizacion;
    }

    public function getPresentacionTipoMaterialFacturas(): Collection
    {
        return $this->presentacionTipoMaterialFacturas;
    }

    public function setPresentacionTipoMaterialFacturas(Collection $items): void
    {
        $this->presentacionTipoMaterialFacturas = $items;
    }
}
