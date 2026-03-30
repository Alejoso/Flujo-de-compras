<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * USER ATTRIBUTES
     * $this->attributes['id'] - string - contains the user primary key
     * Default laravel fields
     * $this->attributes['name'] - string - contains the name
     * $this->attributes['email'] - string - contains the email
     * $this->attributes['email_verified_at'] - string|null - contains the timestamp of when the email was verified
     * $this->attributes['password'] - string - contains the password
     * $this->attributes['remember_token'] - string|null - stores the token used for "remember me" sessions
     * End of default laravel fields
     * $this->attributes['rol'] - string - contains the role of the user (Can be admin or técnico)
     * $this->attributes['cedula'] - string - contains the document number of the user
     * $this->attributes['sueldo'] - string - contains the salary of the user
     * $this->attributes['numeroTelefono'] - string - contains the phone number
     * $this->attributes['recibeNotificaciones'] - bool - Is true or false. True if the user will recieve email quotes
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->cotizaciones - Cotizacion[] - contains the quotations that the user has done
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'cedula',
        'sueldo',
        'numeroTelefono',
        'recibeNotificaciones',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // id
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    // name
    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    // email
    public function setEmail( string $email): void
    {
        $this->attributes['email'] = $email;
    }
    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    // email_verified_at
    public function getEmailVerifiedAt(): string
    {
        return $this->attributes['email_verified_at'];
    }

    // remember_token
    public function getRememberToken(): string
    {
        return $this->attributes['remember_token'];
    }

    // rol
    public function setRol(string $rol): void
    {
        $this->attributes['rol'] = $rol;
    }

    public function getRol(): string
    {
        return $this->attributes['rol'];
    }

    // cedula
    public function setCedula (string $cedula): void
    {
        $this->attributes['cedula'] = $cedula;
    }

    public function getCedula(): string
    {
        return $this->attributes['cedula'];
    }

    // sueldo
    public function setSueldo (string $sueldo): void
    {
        $this->attributes['sueldo'] = $sueldo;
    }

    public function getSueldo(): string
    {
        return $this->attributes['sueldo'];
    }

    // numeroTelefono
    public function setNumeroTelefono(string $numeroTelefono): void
    {
        $this->attributes['numeroTelefono'] = $numeroTelefono;
    }

    public function getNumeroTelefono(): string
    {
        return $this->attributes['numeroTelefono'];
    }

    // recibeNotificaciones
    public function setRecibeNotificaciones(bool $recibeNotificaciones): void
    {
        $this->attributes['recibeNotificaciones'] = $recibeNotificaciones;
    }

    public function getRecibeNotificaciones(): bool
    {
        return $this->attributes['recibeNotificaciones'];
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
    // public function cotizaciones(): HasMany
    // {
    //     return $this->hasMany(Cotizaciones::class);
    // }

    // Relatiosn setters and getters
    public function setCotizaciones(Collection $cotizaciones): void
    {
        $this->cotizaciones = $cotizaciones;
    }

    public function getCotizaciones(): Collection
    {
        return $this->cotizaciones;
    }
    
}
