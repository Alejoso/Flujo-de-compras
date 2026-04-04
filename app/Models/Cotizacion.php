<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    /**
     * COTIZACION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['estado'] - string - contains the state of the quotation  ['Tecnico', 'Tecnico Editada', 'Pendiente', 'Admin Editada', 'En Proceso', 'Facturada', 'Cancelada'])
     * $this->attributes['proyectoId'] - int - contains the foreign key of the project
     * $this->attributes['creadoPor'] - int - contains the foreign key of the user who created it
     * $this->attributes['facturaId'] - int|null - contains the foreign key of the invoice
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->proyecto - Proyecto - contains the project associated
     * $this->creadoPor - User - contains the user who created the quotation
     * $this->factura - Factura|null - contains the invoice associated
     * $this->versionCotizaciones - VersionCotizacion[] - contains the versions of this quotation
     */
    protected $fillable = [
        'estado',
        'proyectoId',
        'creadoPor',
        'facturaId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
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

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class, 'facturaId');
    }

    public function versionCotizaciones(): HasMany
    {
        return $this->hasMany(VersionCotizacion::class, 'cotizacionId');
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

    public function getCreadoPor(): User
    {
        return $this->creador;
    }

    public function setCreadoPor(User $user): void
    {
        $this->creador = $user;
    }

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): void
    {
        $this->factura = $factura;
    }

    public function getVersionCotizaciones(): Collection
    {
        return $this->versionCotizaciones;
    }

    public function setVersionCotizaciones(Collection $versionCotizaciones): void
    {
        $this->versionCotizaciones = $versionCotizaciones;
    }
}
