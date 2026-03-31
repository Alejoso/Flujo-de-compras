<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnidadMedidaCantidad extends Model
{
    /**
     * UNIDAD MEDIDA ATTRIBUTES
     * $this->attributes['id'] - int - contains the primary key
     * $this->attributes['created_at'] - string - contains the creation timestamp
     * $this->attributes['updated_at'] - string - contains the update timestamp
     * $this->cantidad - Cantidad - contains the quantity
     * $this->unidadMedida - UnidadMedida - contains the measurement unit
     */

    // id
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    // Relations
    public function cantidad(): BelongsTo
    {
        return $this->belongsTo(Cantidad::class);
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class);
    }

    // Relations setters and getters
 
}
