<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VersionCotizacion extends Model
{
    /**
     * VERSION COTIZACION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['numeroVersion'] - string - contains the version number
     * $this->attributes['esLaMasReciente'] - bool - indicates if this is the most recent version
     * $this->attributes['cotizacionId'] - int - contains the foreign key of the quotation
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->cotizacion - Cotizacion - contains the quotation associated
     * $this->tipoMaterialVersionCotizaciones - TipoMaterialVersionCotizacion[] - contains the materials of this version
     */
    protected $fillable = [
        'numeroVersion',
        'esLaMasReciente',
        'cotizacionId',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // numeroVersion
    public function getNumeroVersion(): string
    {
        return $this->attributes['numeroVersion'];
    }

    public function setNumeroVersion(string $numeroVersion): void
    {
        $this->attributes['numeroVersion'] = $numeroVersion;
    }

    // esLaMasReciente
    public function getEsLaMasReciente(): bool
    {
        return $this->attributes['esLaMasReciente'];
    }

    public function setEsLaMasReciente(bool $esLaMasReciente): void
    {
        $this->attributes['esLaMasReciente'] = $esLaMasReciente;
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
    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function tipoMaterialVersionCotizaciones(): HasMany
    {
        return $this->hasMany(TipoMaterialVersionCotizacion::class);
    }

    // Relations setters and getters
    public function getCotizacion(): Cotizacion
    {
        return $this->cotizacion;
    }

    public function setCotizacion(Cotizacion $cotizacion): void
    {
        $this->cotizacion = $cotizacion;
    }

    public function getTipoMaterialVersionCotizaciones(): Collection
    {
        return $this->tipoMaterialVersionCotizaciones;
    }

    public function setTipoMaterialVersionCotizaciones(Collection $tipoMaterialVersionCotizaciones): void
    {
        $this->tipoMaterialVersionCotizaciones = $tipoMaterialVersionCotizaciones;
    }
}
