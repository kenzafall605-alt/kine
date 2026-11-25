<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'actif',
        'ordre',
    ];
    protected $casts = [
    'actif' => 'boolean',
    'ordre' => 'integer',
];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
