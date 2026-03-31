<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';
    /**
     * CLIENTE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['nombre'] - string - contains the name of the client
     * $this->attributes['cedula'] - string - contains the document number of the client
     * $this->attributes['correo'] - string - contains the email of the client
     * $this->attributes['celular'] - string - contains the phone number of the client
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->proyectos - Proyecto[] - contains the projects associated with this client
     */
    protected $fillable = [
        'nombre',
        'cedula',
        'correo',
        'celular',
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

    // cedula
    public function getCedula(): string
    {
        return $this->attributes['cedula'];
    }

    public function setCedula(string $cedula): void
    {
        $this->attributes['cedula'] = $cedula;
    }

    // correo
    public function getCorreo(): string
    {
        return $this->attributes['correo'];
    }

    public function setCorreo(string $correo): void
    {
        $this->attributes['correo'] = $correo;
    }

    // celular
    public function getCelular(): string
    {
        return $this->attributes['celular'];
    }

    public function setCelular(string $celular): void
    {
        $this->attributes['celular'] = $celular;
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
    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'clienteId');
    }

    // Relations setters and getters
    public function getProyectos(): Collection
    {
        return $this->proyectos;
    }

    public function setProyectos(Collection $proyectos): void
    {
        $this->proyectos = $proyectos;
    }
}
