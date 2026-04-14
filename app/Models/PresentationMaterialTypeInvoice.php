<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentationMaterialTypeInvoice extends Model
{
    protected $table = 'presentation_material_type_invoices';

    /**
     * PRESENTATION MATERIAL TYPE INVOICE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['unit_price'] - double(15,2) - contains the unit price paid
     * $this->attributes['quantity'] - int - contains the quantity purchased
     * $this->attributes['invoice_id'] - int - contains the foreign key of the invoice
     * $this->attributes['presentation_material_type_id'] - int - contains the foreign key of the presentation material type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->invoice - Invoice - contains the invoice associated
     * $this->presentationMaterialType - PresentationMaterialType - contains the presentation material type associated
     */
    protected $fillable = [
        'unit_price',
        'quantity',
        'invoice_id',
        'presentation_material_type_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // unit_price — double in DB, PHP does not support double natively, float is used
    public function getUnitPrice(): float
    {
        return $this->attributes['unit_price'];
    }

    // double in DB, PHP does not support double natively, float is used
    public function setUnitPrice(float $unitPrice): void
    {
        $this->attributes['unit_price'] = $unitPrice;
    }

    // quantity
    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
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
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function presentationMaterialType(): BelongsTo
    {
        return $this->belongsTo(PresentationMaterialType::class, 'presentation_material_type_id');
    }

    // Relations setters and getters
    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getPresentationMaterialType(): PresentationMaterialType
    {
        return $this->presentationMaterialType;
    }

    public function setPresentationMaterialType(PresentationMaterialType $presentationMaterialType): void
    {
        $this->presentationMaterialType = $presentationMaterialType;
    }
}
