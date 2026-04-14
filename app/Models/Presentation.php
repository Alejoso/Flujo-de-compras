<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    protected $table = 'presentations';

    /**
     * PRESENTATION ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['name'] - string - contains the presentation name (e.g. "Rollo", "Paquete", "Unitario")
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->presentationMaterialTypes - PresentationMaterialType[] - contains the material combinations for this presentation
     */
    protected $fillable = [
        'name',
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
    public function presentationMaterialTypes(): HasMany
    {
        return $this->hasMany(PresentationMaterialType::class, 'presentation_id');
    }

    // Relations setters and getters
    public function getPresentationMaterialTypes(): Collection
    {
        return $this->presentationMaterialTypes;
    }

    public function setPresentationMaterialTypes(Collection $presentationMaterialTypes): void
    {
        $this->presentationMaterialTypes = $presentationMaterialTypes;
    }
}
