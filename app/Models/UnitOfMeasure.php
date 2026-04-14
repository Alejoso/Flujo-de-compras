<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitOfMeasure extends Model
{
    protected $table = 'unit_of_measures';

    /**
     * UNIT OF MEASURE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['name'] - string - contains the name of the unit
     * $this->attributes['abbreviation'] - string - contains the abbreviation of the unit
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->types - Type[] - contains the types that use this unit of measure
     */
    protected $fillable = [
        'name',
        'abbreviation',
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

    // abbreviation
    public function getAbbreviation(): string
    {
        return $this->attributes['abbreviation'];
    }

    public function setAbbreviation(string $abbreviation): void
    {
        $this->attributes['abbreviation'] = $abbreviation;
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
    public function types(): HasMany
    {
        return $this->hasMany(Type::class, 'unit_of_measure_id');
    }

    // Relations setters and getters
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function setTypes(Collection $types): void
    {
        $this->types = $types;
    }
}
