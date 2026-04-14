<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $table = 'invoices';

    /**
     * INVOICE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['total_value'] - int - contains the total value of the invoice
     * $this->attributes['status'] - enum('Pending', 'Approved', 'Rejected', 'Paid', 'Cancelled') - contains the status of the invoice
     * $this->attributes['project_id'] - int - contains the foreign key of the project
     * $this->attributes['supplier_id'] - int - contains the foreign key of the supplier
     * $this->attributes['quotation_id'] - int - contains the foreign key of the quotation
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->project - Project - contains the project associated
     * $this->supplier - Supplier - contains the supplier associated
     * $this->quotation - Quotation|null - contains the quotation associated
     * $this->presentationMaterialTypeInvoices - PresentationMaterialTypeInvoice[]
     */
    protected $fillable = [
        'total_value',
        'status',
        'project_id',
        'supplier_id',
        'quotation_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // total_value
    public function getTotalValue(): int
    {
        return $this->attributes['total_value'];
    }

    public function setTotalValue(int $totalValue): void
    {
        $this->attributes['total_value'] = $totalValue;
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

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function presentationMaterialTypeInvoices(): HasMany
    {
        return $this->hasMany(PresentationMaterialTypeInvoice::class, 'invoice_id');
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

    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier): void
    {
        $this->supplier = $supplier;
    }

    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(?Quotation $quotation): void
    {
        $this->quotation = $quotation;
    }

    public function getPresentationMaterialTypeInvoices(): Collection
    {
        return $this->presentationMaterialTypeInvoices;
    }

    public function setPresentationMaterialTypeInvoices(Collection $items): void
    {
        $this->presentationMaterialTypeInvoices = $items;
    }
}
