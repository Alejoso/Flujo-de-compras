<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table = 'types';

    /**
     * TYPE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['specification'] - string - contains the specification of the type
     * $this->attributes['unit_of_measure_id'] - int|null - contains the optional foreign key of the unit of measure
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->materialTypes - MaterialType[] - contains the material types associated with this type
     * $this->unitOfMeasure - UnitOfMeasure|null - contains the unit of measure associated
     */
    protected $fillable = [
        'specification',
        'unit_of_measure_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // specification
    public function getSpecification(): string
    {
        return $this->attributes['specification'];
    }

    public function setSpecification(string $specification): void
    {
        $this->attributes['specification'] = $specification;
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
    public function materialTypes(): HasMany
    {
        return $this->hasMany(MaterialType::class, 'type_id');
    }

    public function unitOfMeasure(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_of_measure_id');
    }

    // Relations setters and getters
    public function getMaterialTypes(): Collection
    {
        return $this->materialTypes;
    }

    public function setMaterialTypes(Collection $materialTypes): void
    {
        $this->materialTypes = $materialTypes;
    }

    public function getUnitOfMeasure(): ?UnitOfMeasure
    {
        return $this->unitOfMeasure;
    }

    public function setUnitOfMeasure(?UnitOfMeasure $unitOfMeasure): void
    {
        $this->unitOfMeasure = $unitOfMeasure;
    }
}
