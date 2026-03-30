<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    /**
     * PROYECTO ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['nombre'] - string - contains the name of the project
     * $this->attributes['direccion'] - string - contains the address of the project
     * $this->attributes['ciudad'] - string - contains the city of the project
     * $this->attributes['costoTotal'] - float - contains the total cost of the project
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->facturas - Factura[] - contains the invoices associated with this project
     * $this->cotizaciones - Cotizacion[] - contains the quotations associated with this project
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'costoTotal',
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

    // direccion
    public function getDireccion(): string
    {
        return $this->attributes['direccion'];
    }

    public function setDireccion(string $direccion): void
    {
        $this->attributes['direccion'] = $direccion;
    }

    // ciudad
    public function getCiudad(): string
    {
        return $this->attributes['ciudad'];
    }

    public function setCiudad(string $ciudad): void
    {
        $this->attributes['ciudad'] = $ciudad;
    }

    // costoTotal
    public function getCostoTotal(): float
    {
        return $this->attributes['costoTotal'];
    }

    public function setCostoTotal(float $costoTotal): void
    {
        $this->attributes['costoTotal'] = $costoTotal;
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
    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class);
    }

    // Relations setters and getters
    public function getFacturas(): Collection
    {
        return $this->facturas;
    }

    public function setFacturas(Collection $facturas): void
    {
        $this->facturas = $facturas;
    }

    public function getCotizaciones(): Collection
    {
        return $this->cotizaciones;
    }

    public function setCotizaciones(Collection $cotizaciones): void
    {
        $this->cotizaciones = $cotizaciones;
    }
}
