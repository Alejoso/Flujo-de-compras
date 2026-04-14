<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';

    /**
     * SUPPLIER ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['nit'] - string - contains the NIT of the supplier
     * $this->attributes['name'] - string - contains the name of the supplier
     * $this->attributes['advisor_name'] - string - contains the name of the advisor
     * $this->attributes['account_number'] - string|null - contains the account number
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->invoices - Invoice[] - contains the invoices associated with this supplier
     */
    protected $fillable = [
        'nit',
        'name',
        'advisor_name',
        'account_number',
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

    // name
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    // advisor_name
    public function getAdvisorName(): string
    {
        return $this->attributes['advisor_name'];
    }

    public function setAdvisorName(string $advisorName): void
    {
        $this->attributes['advisor_name'] = $advisorName;
    }

    // account_number
    public function getAccountNumber(): ?string
    {
        return $this->attributes['account_number'];
    }

    public function setAccountNumber(?string $accountNumber): void
    {
        $this->attributes['account_number'] = $accountNumber;
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
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'supplier_id');
    }

    // Relations setters and getters
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function setInvoices(Collection $invoices): void
    {
        $this->invoices = $invoices;
    }
}
