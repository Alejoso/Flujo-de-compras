<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    /**
     * PROVEEDOR ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['nit'] - string - contains the NIT of the supplier
     * $this->attributes['nombre'] - string - contains the name of the supplier
     * $this->attributes['nombreAsesor'] - string - contains the name of the advisor
     * $this->attributes['numeroCuenta'] - string|null - contains the account number
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->facturas - Factura[] - contains the invoices associated with this supplier
     */
    protected $fillable = [
        'nit',
        'nombre',
        'nombreAsesor',
        'numeroCuenta',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // nit
    public function getNit(): string
    {
        return $this->attributes['nit'];
    }

    public function setNit(string $nit): void
    {
        $this->attributes['nit'] = $nit;
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

    // nombreAsesor
    public function getNombreAsesor(): string
    {
        return $this->attributes['nombreAsesor'];
    }

    public function setNombreAsesor(string $nombreAsesor): void
    {
        $this->attributes['nombreAsesor'] = $nombreAsesor;
    }

    // numeroCuenta
    public function getNumeroCuenta(): ?string
    {
        return $this->attributes['numeroCuenta'];
    }

    public function setNumeroCuenta(?string $numeroCuenta): void
    {
        $this->attributes['numeroCuenta'] = $numeroCuenta;
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
        return $this->hasMany(Factura::class, 'proveedorId');
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
}
