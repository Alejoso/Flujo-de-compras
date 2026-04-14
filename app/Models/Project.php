<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $table = 'projects';

    /**
     * PROJECT ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['name'] - string - contains the name of the project
     * $this->attributes['address'] - string - contains the address of the project
     * $this->attributes['city'] - string - contains the city of the project
     * $this->attributes['total_cost'] - ?double - contains the total cost of the project
     * $this->attributes['status'] - enum('Negotiation', 'In Progress', 'Completed') - contains the status of the project
     * $this->attributes['client_id'] - int - contains the foreign key of the client
     * $this->attributes['created_by'] - int - contains the foreign key of the user who created it
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->client - Client - contains the client associated
     * $this->createdByUser - User - contains the user who created the project
     * $this->invoices - Invoice[] - contains the invoices associated with this project
     * $this->quotations - Quotation[] - contains the quotations associated with this project
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'total_cost',
        'status',
        'client_id',
        'created_by',
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

    // address
    public function getAddress(): string
    {
        return $this->attributes['address'];
    }

    public function setAddress(string $address): void
    {
        $this->attributes['address'] = $address;
    }

    // city
    public function getCity(): string
    {
        return $this->attributes['city'];
    }

    public function setCity(string $city): void
    {
        $this->attributes['city'] = $city;
    }

    // total_cost — double in DB, PHP does not support double natively, float is used
    public function getTotalCost(): ?float
    {
        return $this->attributes['total_cost'];
    }

    // double in DB, PHP does not support double natively, float is used
    public function setTotalCost(?float $totalCost): void
    {
        $this->attributes['total_cost'] = $totalCost;
    }

    // status
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
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
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'project_id');
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'project_id');
    }

    // Relations setters and getters
    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getCreatedByUser(): User
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(User $user): void
    {
        $this->createdByUser = $user;
    }

    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function setInvoices(Collection $invoices): void
    {
        $this->invoices = $invoices;
    }

    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function setQuotations(Collection $quotations): void
    {
        $this->quotations = $quotations;
    }
}
