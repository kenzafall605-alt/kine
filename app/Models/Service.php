<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'nom',
        'description',
        'prix',
        'duree_minutes',
        'actif',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'duree_minutes' => 'integer',
        'actif' => 'boolean',
    ];

    /**
     * Une prestation appartient à une catégorie.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    /**
     * Une prestation peut être utilisée dans plusieurs rendez-vous.
     */
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class, 'service_id');
    }
}
