<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';

    /**
     * CLIENT ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['name'] - string - contains the name of the client
     * $this->attributes['id_number'] - ?string - contains the document number of the client
     * $this->attributes['email'] - ?string - contains the email of the client
     * $this->attributes['phone'] - ?string - contains the phone number of the client
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->projects - Project[] - contains the projects associated with this client
     */
    protected $fillable = [
        'name',
        'id_number',
        'email',
        'phone',
    ];

    // id
    public function getId(): int
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

    // id_number
    public function getIdNumber(): ?string
    {
        return $this->attributes['id_number'];
    }

    public function setIdNumber(string $idNumber): void
    {
        $this->attributes['id_number'] = $idNumber;
    }

    // email
    public function getEmail(): ?string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    // phone
    public function getPhone(): ?string
    {
        return $this->attributes['phone'];
    }

    public function setPhone(string $phone): void
    {
        $this->attributes['phone'] = $phone;
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
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    // Relations setters and getters
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function setProjects(Collection $projects): void
    {
        $this->projects = $projects;
    }
}
