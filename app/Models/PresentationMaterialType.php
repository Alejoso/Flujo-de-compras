<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresentationMaterialType extends Model
{
    protected $table = 'presentation_material_types';

    /**
     * PRESENTATION MATERIAL TYPE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['presentation_quantity'] - int - contains the number of base units per presentation
     * $this->attributes['presentation_id'] - int - contains the foreign key of the presentation
     * $this->attributes['material_type_id'] - int - contains the foreign key of the material type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->presentation - Presentation - contains the presentation associated
     * $this->materialType - MaterialType - contains the material type associated
     * $this->presentationMaterialTypeQuotationVersions - PresentationMaterialTypeQuotationVersion[]
     * $this->presentationMaterialTypeInvoices - PresentationMaterialTypeInvoice[]
     */
    protected $fillable = [
        'presentation_quantity',
        'presentation_id',
        'material_type_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // presentation_quantity
    public function getPresentationQuantity(): string
    {
        return $this->attributes['presentation_quantity'];
    }

    public function setPresentationQuantity(string $presentationQuantity): void
    {
        $this->attributes['presentation_quantity'] = $presentationQuantity;
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
    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class, 'presentation_id');
    }

    public function materialType(): BelongsTo
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }

    public function presentationMaterialTypeQuotationVersions(): HasMany
    {
        return $this->hasMany(PresentationMaterialTypeQuotationVersion::class, 'presentation_material_type_id');
    }

    public function presentationMaterialTypeInvoices(): HasMany
    {
        return $this->hasMany(PresentationMaterialTypeInvoice::class, 'presentation_material_type_id');
    }

    // Relations setters and getters
    public function getPresentation(): Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(Presentation $presentation): void
    {
        $this->presentation = $presentation;
    }

    public function getMaterialType(): MaterialType
    {
        return $this->materialType;
    }

    public function setMaterialType(MaterialType $materialType): void
    {
        $this->materialType = $materialType;
    }

    public function getPresentationMaterialTypeQuotationVersions(): Collection
    {
        return $this->presentationMaterialTypeQuotationVersions;
    }

    public function getPresentationMaterialTypeInvoices(): Collection
    {
        return $this->presentationMaterialTypeInvoices;
    }
}
