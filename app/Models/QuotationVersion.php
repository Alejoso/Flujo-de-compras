<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuotationVersion extends Model
{
    protected $table = 'quotation_versions';

    /**
     * QUOTATION VERSION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['version_number'] - string - contains the version number
     * $this->attributes['is_most_recent'] - bool - indicates if this is the most recent version
     * $this->attributes['pdf_path'] - ?string - contains the path to the PDF file
     * $this->attributes['quotation_id'] - int - contains the foreign key of the quotation
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->quotation - Quotation - contains the quotation associated
     * $this->presentationMaterialTypeQuotationVersions - PresentationMaterialTypeQuotationVersion[]
     */
    protected $fillable = [
        'version_number',
        'is_most_recent',
        'quotation_id',
        'pdf_path',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // version_number
    public function getVersionNumber(): string
    {
        return $this->attributes['version_number'];
    }

    public function setVersionNumber(string $versionNumber): void
    {
        $this->attributes['version_number'] = $versionNumber;
    }

    // is_most_recent
    public function getIsMostRecent(): bool
    {
        return $this->attributes['is_most_recent'];
    }

    public function setIsMostRecent(bool $isMostRecent): void
    {
        $this->attributes['is_most_recent'] = $isMostRecent;
    }

    // pdf_path
    public function getPdfPath(): ?string
    {
        return $this->attributes['pdf_path'] ?? null;
    }

    public function setPdfPath(?string $pdfPath): void
    {
        $this->attributes['pdf_path'] = $pdfPath;
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
    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function presentationMaterialTypeQuotationVersions(): HasMany
    {
        return $this->hasMany(PresentationMaterialTypeQuotationVersion::class, 'quotation_version_id');
    }

    // Relations setters and getters
    public function getQuotation(): Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(Quotation $quotation): void
    {
        $this->quotation = $quotation;
    }

    public function getPresentationMaterialTypeQuotationVersions(): Collection
    {
        return $this->presentationMaterialTypeQuotationVersions;
    }

    public function setPresentationMaterialTypeQuotationVersions(Collection $items): void
    {
        $this->presentationMaterialTypeQuotationVersions = $items;
    }
}
