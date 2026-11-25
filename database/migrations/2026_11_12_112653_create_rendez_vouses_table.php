<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();

            // Relation avec les clients
            $table->foreignId('client_id')
                ->constrained('clients')
                ->restrictOnDelete();

            // Informations du rendez-vous
            $table->string('prestation', 150);

            $table->date('date_rendez_vous');
            $table->time('heure_debut');
            $table->time('heure_fin');

            // Prix en FCFA
            $table->decimal('prix', 10, 2)->default(0);

            // Statut de réservation
            $table->string('statut', 20)->default('en_attente');

            // Informations complémentaires
            $table->text('notes')->nullable();

            $table->timestamps();

            // Index pour les recherches et le planning
            $table->index(
                ['date_rendez_vous', 'statut'],
                'rendez_vous_date_statut_index'
            );

            $table->index(
                ['client_id', 'date_rendez_vous'],
                'rendez_vous_client_date_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
