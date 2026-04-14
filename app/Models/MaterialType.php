<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialType extends Model
{
    protected $table = 'material_types';

    /**
     * MATERIAL TYPE ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['material_id'] - int - contains the foreign key of the material
     * $this->attributes['type_id'] - int - contains the foreign key of the type
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->material - Material - contains the material associated
     * $this->type - Type - contains the type associated
     * $this->presentationMaterialTypes - PresentationMaterialType[] - contains the presentation combinations
     */
    protected $fillable = [
        'material_id',
        'type_id',
    ];

    // id
    public function getId(): int
    {
        return $this->attributes['id'];
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
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function presentationMaterialTypes(): HasMany
    {
        return $this->hasMany(PresentationMaterialType::class, 'material_type_id');
    }

    // Relations setters and getters
    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function setMaterial(Material $material): void
    {
        $this->material = $material;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    public function getPresentationMaterialTypes(): Collection
    {
        return $this->presentationMaterialTypes;
    }

    public function setPresentationMaterialTypes(Collection $presentationMaterialTypes): void
    {
        $this->presentationMaterialTypes = $presentationMaterialTypes;
    }
}
