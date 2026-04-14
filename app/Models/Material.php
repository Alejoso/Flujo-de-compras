<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $table = 'materials';

    /**
     * MATERIAL ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['description'] - string - contains the description of the material
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->materialTypes - MaterialType[] - contains the material types associated with this material
     */
    protected $fillable = [
        'description',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    // description
    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
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
        return $this->hasMany(MaterialType::class, 'material_id');
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
}
