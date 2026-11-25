
<x-layouts.app title="Détails du rendez-vous">
    <div class="space-y-6">
        <x-page-header
            title="Détails du rendez-vous"
            description="Consultez les informations de ce rendez-vous."
        />

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="bg-rose-950 px-6 py-5 text-white">
                <h2 class="text-xl font-semibold">
                    Rendez-vous #{{ $rendezVous->id }}
                </h2>
                <p class="mt-1 text-sm text-rose-100">
                    Informations du rendez-vous
                </p>
            </div>

            <div class="grid gap-6 p-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Client</p>
                    <p class="font-semibold text-slate-800">
                        {{ $rendezVous->client->prenom ?? '' }}
                        {{ $rendezVous->client->nom ?? 'Client introuvable' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Téléphone</p>
                    <p class="font-semibold text-slate-800">
                        {{ $rendezVous->client->telephone ?? 'Non renseigné' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Prestation</p>
                    <p class="font-semibold text-slate-800">
                        {{ $rendezVous->prestation }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Date</p>
                    <p class="font-semibold text-slate-800">
                        {{ \Carbon\Carbon::parse($rendezVous->date)->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Heure de début</p>
                    <p class="font-semibold text-slate-800">
                        {{ substr($rendezVous->heure_debut, 0, 5) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Heure de fin</p>
                    <p class="font-semibold text-slate-800">
                        {{ substr($rendezVous->heure_fin, 0, 5) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Prix</p>
                    <p class="font-semibold text-slate-800">
                        {{ number_format($rendezVous->prix, 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Statut</p>
                    <p class="font-semibold text-slate-800">
                        {{ $rendezVous->statut }}
                    </p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-slate-500">Notes</p>
                    <p class="text-slate-800">
                        {{ $rendezVous->notes ?: 'Aucune note' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 border-t border-slate-200 p-6">
                <a href="{{ route('rendez-vous.index') }}"
                   style="background:#f1f5f9;color:#334155;padding:10px 18px;border-radius:8px;">
                    Retour
                </a>

                <a href="{{ route('rendez-vous.edit', $rendezVous) }}"
                   style="background:#7b1e3a;color:white;padding:10px 18px;border-radius:8px;">
                    Modifier
                </a>

                @if (!in_array($rendezVous->statut, ['annule', 'annulé']))
                    <form action="{{ route('rendez-vous.destroy', $rendezVous) }}"
                          method="POST"
                          onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                style="background:#dc2626;color:white;padding:10px 18px;border-radius:8px;">
                            Annuler le rendez-vous
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
