<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentationMaterialTypeQuotationVersion extends Model
{
    protected $table = 'presentation_material_type_quotation_versions';

    /**
     * PRESENTATION MATERIAL TYPE QUOTATION VERSION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['quantity'] - double - contains the quantity requested in this version
     * $this->attributes['quotation_version_id'] - int - contains the foreign key of the quotation version
     * $this->attributes['presentation_material_type_id'] - int - contains the foreign key of the presentation material type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->quotationVersion - QuotationVersion - contains the quotation version associated
     * $this->presentationMaterialType - PresentationMaterialType - contains the presentation material type associated
     */
    protected $fillable = [
        'quantity',
        'quotation_version_id',
        'presentation_material_type_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // quantity — double in DB, PHP does not support double natively, float is used
    public function getQuantity(): float
    {
        return $this->attributes['quantity'];
    }

    // double in DB, PHP does not support double natively, float is used
    public function setQuantity(float $quantity): void
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
    public function quotationVersion(): BelongsTo
    {
        return $this->belongsTo(QuotationVersion::class, 'quotation_version_id');
    }

    public function presentationMaterialType(): BelongsTo
    {
        return $this->belongsTo(PresentationMaterialType::class, 'presentation_material_type_id');
    }

    // Relations setters and getters
    public function getQuotationVersion(): QuotationVersion
    {
        return $this->quotationVersion;
    }

    public function setQuotationVersion(QuotationVersion $quotationVersion): void
    {
        $this->quotationVersion = $quotationVersion;
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
