<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    protected $table = 'rendez_vouses';

    protected $fillable = [
        'client_id',
        'service_id',
        'prestation',
        'date_rendez_vous',
        'heure_debut',
        'heure_fin',
        'prix',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date_rendez_vous' => 'date',
        'prix' => 'decimal:2',
    ];

    /**
     * Un rendez-vous appartient à un client.
     * On conserve l'accès aux clients archivés.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    /**
     * Un rendez-vous peut être associé à une prestation.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
