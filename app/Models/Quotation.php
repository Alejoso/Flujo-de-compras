<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    protected $table = 'quotations';

    /**
     * QUOTATION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['status'] - enum('Technician', 'Technician Edited', 'Pending', 'Admin Edited', 'In Process', 'Invoiced', 'Cancelled') - contains the status of the quotation
     * $this->attributes['project_id'] - int - contains the foreign key of the project
     * $this->attributes['created_by'] - int - contains the foreign key of the user who created it
     * $this->attributes['invoice_id'] - int|null - contains the foreign key of the invoice
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->project - Project - contains the project associated
     * $this->creator - User - contains the user who created the quotation
     * $this->invoice - Invoice|null - contains the invoice associated
     * $this->quotationVersions - QuotationVersion[] - contains the versions of this quotation
     */
    protected $fillable = [
        'status',
        'project_id',
        'created_by',
        'invoice_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
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
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function quotationVersions(): HasMany
    {
        return $this->hasMany(QuotationVersion::class, 'quotation_id');
    }

    // Relations setters and getters
    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setCreator(User $user): void
    {
        $this->creator = $user;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getQuotationVersions(): Collection
    {
        return $this->quotationVersions;
    }

    public function setQuotationVersions(Collection $quotationVersions): void
    {
        $this->quotationVersions = $quotationVersions;
    }
}
