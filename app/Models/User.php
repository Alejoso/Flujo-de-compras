<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
     * $this->attributes['role'] - string - contains the role of the user (can be admin or technician)
     * $this->attributes['id_number'] - string - contains the document number of the user
     * $this->attributes['salary'] - string - contains the salary of the user
     * $this->attributes['phone_number'] - string - contains the phone number
     * $this->attributes['receives_notifications'] - bool - true if the user will receive email quotes
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->quotations - Quotation[] - contains the quotations that the user has created
     * $this->projects - Project[] - contains the projects created by the user
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_number',
        'salary',
        'phone_number',
        'receives_notifications',
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
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    // email
    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    // email_verified_at
    public function getEmailVerifiedAt(): string
    {
        return $this->attributes['email_verified_at'];
    }

    // remember_token
    public function getRememberToken(): ?string
    {
        return $this->attributes['remember_token'];
    }

    // role
    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    // id_number
    public function getIdNumber(): string
    {
        return $this->attributes['id_number'];
    }

    public function setIdNumber(string $idNumber): void
    {
        $this->attributes['id_number'] = $idNumber;
    }

    // salary
    public function getSalary(): string
    {
        return $this->attributes['salary'];
    }

    public function setSalary(string $salary): void
    {
        $this->attributes['salary'] = $salary;
    }

    // phone_number
    public function getPhoneNumber(): string
    {
        return $this->attributes['phone_number'];
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->attributes['phone_number'] = $phoneNumber;
    }

    // receives_notifications
    public function getReceivesNotifications(): bool
    {
        return $this->attributes['receives_notifications'];
    }

    public function setReceivesNotifications(bool $receivesNotifications): void
    {
        $this->attributes['receives_notifications'] = $receivesNotifications;
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
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'created_by');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // Relations setters and getters
    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function setQuotations(Collection $quotations): void
    {
        $this->quotations = $quotations;
    }
}
