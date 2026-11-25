<x-layouts.app title="Rendez-vous">

<div class="space-y-8">

    {{-- EN-TÊTE --}}
    <div>
        <p class="text-sm font-medium text-bordeaux-700">
            ESPACE DE GESTION / RENDEZ-VOUS
        </p>

        <h1 class="mt-2 text-3xl font-bold text-bordeaux-900"
            style="font-family: 'Playfair Display', serif;">
            Gestion des rendez-vous
        </h1>

        <p class="mt-2 text-sm text-stone-500">
            Organisez les réservations et suivez l'activité de votre salon.
        </p>
    </div>

    {{-- STATISTIQUES --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-stone-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Aujourd'hui</p>
            <h2 class="mt-4 text-3xl font-bold text-bordeaux-900">
                {{ $aujourdHui }}
            </h2>
            <p class="mt-1 text-xs text-stone-400">
                Rendez-vous programmés
            </p>
        </div>

        <div class="rounded-2xl border border-stone-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Confirmés</p>
            <h2 class="mt-4 text-3xl font-bold text-green-700">
                {{ $confirmes }}
            </h2>
            <p class="mt-1 text-xs text-stone-400">
                Réservations confirmées
            </p>
        </div>

        <div class="rounded-2xl border border-stone-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">En attente</p>
            <h2 class="mt-4 text-3xl font-bold text-amber-600">
                {{ $enAttente }}
            </h2>
            <p class="mt-1 text-xs text-stone-400">
                À confirmer
            </p>
        </div>

        <div class="rounded-2xl border border-stone-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Annulés</p>
            <h2 class="mt-4 text-3xl font-bold text-red-600">
                {{ $annules }}
            </h2>
            <p class="mt-1 text-xs text-stone-400">
                Réservations annulées
            </p>
        </div>

    </div>

    {{-- PLANNING --}}
    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">

        <div class="border-b border-stone-100 p-5">
            <h2 class="text-xl font-bold text-bordeaux-900">
                Planning des rendez-vous
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Consultez les réservations enregistrées dans votre salon.
            </p>
        </div>

        {{-- RECHERCHE ET FILTRES --}}
        <form method="GET"
              action="{{ route('rendez-vous.index') }}"
              class="flex flex-col gap-3 border-b border-stone-100 p-5 sm:flex-row">

            <input
                type="search"
                name="recherche"
                value="{{ request('recherche') }}"
                placeholder="Rechercher un client..."
                class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm outline-none focus:border-bordeaux-700 focus:ring-2 focus:ring-bordeaux-100">

            <select
                name="statut"
                class="rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-600 outline-none focus:border-bordeaux-700">

                <option value="">Tous les statuts</option>

                <option value="confirme"
                    @selected(request('statut') === 'confirme')>
                    Confirmé
                </option>

                <option value="en_attente"
                    @selected(request('statut') === 'en_attente')>
                    En attente
                </option>

                <option value="termine"
                    @selected(request('statut') === 'termine')>
                    Terminé
                </option>

                <option value="annule"
                    @selected(request('statut') === 'annule')>
                    Annulé
                </option>

            </select>

            <input
                type="date"
                name="date"
                value="{{ request('date') }}"
                class="rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-600 outline-none focus:border-bordeaux-700">

            <button type="submit"
                class="rounded-xl bg-bordeaux-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-bordeaux-800">
                Filtrer
            </button>

            <a href="{{ route('rendez-vous.index') }}"
                class="rounded-xl border border-stone-200 px-5 py-3 text-center text-sm font-medium text-stone-600 hover:bg-stone-50">
                Réinitialiser
            </a>

        </form>

        {{-- TABLEAU --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-stone-50 text-xs uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Client</th>
                        <th class="px-6 py-4 font-semibold">Prestation</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Horaire</th>
                        <th class="px-6 py-4 font-semibold">Statut</th>
                        <th class="px-6 py-4 text-right font-semibold">Prix</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-stone-100">

                    @forelse ($rendezVous as $rdv)

                        @php
                            $statut = strtolower($rdv->statut);

                            $statutStyle = match ($statut) {
                                'confirme', 'confirmé' => 'bg-green-50 text-green-700',
                                'en_attente' => 'bg-amber-50 text-amber-700',
                                'termine', 'terminé' => 'bg-blue-50 text-blue-700',
                                'annule', 'annulé' => 'bg-red-50 text-red-700',
                                default => 'bg-stone-100 text-stone-600',
                            };

                            $statutLabel = match ($statut) {
                                'confirme', 'confirmé' => 'Confirmé',
                                'en_attente' => 'En attente',
                                'termine', 'terminé' => 'Terminé',
                                'annule', 'annulé' => 'Annulé',
                                default => ucfirst(str_replace('_', ' ', $statut)),
                            };
                        @endphp

                        <tr class="transition hover:bg-stone-50">

                            {{-- CLIENT --}}
                            <td class="whitespace-nowrap px-6 py-5">
                                @if ($rdv->client)
                                    <p class="font-semibold text-bordeaux-900">
                                        {{ $rdv->client->prenom }}
                                        {{ $rdv->client->nom }}
                                    </p>

                                    <p class="mt-1 text-xs text-stone-400">
                                        {{ $rdv->client->telephone }}
                                    </p>
                                @else
                                    <span class="text-stone-400">
                                        Client introuvable
                                    </span>
                                @endif
                            </td>

                            {{-- PRESTATION --}}
                            <td class="whitespace-nowrap px-6 py-5 text-stone-600">
                                {{ $rdv->prestation }}
                            </td>

                            {{-- DATE --}}
                            <td class="whitespace-nowrap px-6 py-5 text-stone-600">
                                {{ $rdv->date_rendez_vous->format('d/m/Y') }}
                            </td>

                            {{-- HORAIRE --}}
                            <td class="whitespace-nowrap px-6 py-5 font-medium text-stone-700">
                                {{ substr($rdv->heure_debut, 0, 5) }}
                                -
                                {{ substr($rdv->heure_fin, 0, 5) }}
                            </td>

                            {{-- STATUT --}}
                            <td class="whitespace-nowrap px-6 py-5">
                                <span class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $statutStyle }}">
                                    {{ $statutLabel }}
                                </span>
                            </td>

                            {{-- PRIX --}}
                            <td class="whitespace-nowrap px-6 py-5 text-right font-semibold text-bordeaux-900">
                                {{ number_format((float) $rdv->prix, 0, ',', ' ') }} FCFA
                            </td>
                            {{-- ACTIONS --}}
                            <td class="whitespace-nowrap px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">

                            <a href="{{ route('rendez-vous.show', $rdv) }}"
                            class="rounded-lg bg-bordeaux-900 px-3 py-2 text-xs font-semibold text-white hover:bg-bordeaux-800">
                            Voir
                            </a>

                            <a href="{{ route('rendez-vous.edit', $rdv) }}"
                            class="rounded-lg border border-bordeaux-800 px-3 py-2 text-xs font-semibold text-bordeaux-900 hover:bg-rose-50">
                            Modifier
                            </a>

                            </div>
                            </td>
{{-- ACTIONS --}}

        <a href="{{ route('rendez-vous.show', $rdv) }}"
           class="rounded-lg bg-bordeaux-900 px-3 py-2 text-xs font-semibold text-white hover:bg-bordeaux-800">
            Voir
        </a>

        <a href="{{ route('rendez-vous.edit', $rdv) }}"
           class="rounded-lg border border-bordeaux-800 px-3 py-2 text-xs font-semibold text-bordeaux-900 hover:bg-rose-50">
            Modifier
        </a>

        @if (!in_array(strtolower($rdv->statut), ['annule', 'annulé']))
            <form action="{{ route('rendez-vous.destroy', $rdv) }}"
                  method="POST"
                  onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                    Annuler
                </button>
            </form>
        @endif


                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-50">
                                        <span class="text-3xl text-bordeaux-800">▦</span>
                                    </div>

                                    <h3 class="mt-4 text-lg font-semibold text-bordeaux-900">
                                        Aucun rendez-vous trouvé
                                    </h3>

                                    <p class="mt-2 max-w-sm text-sm text-stone-500">
                                        Les rendez-vous enregistrés apparaîtront ici.
                                        Vous pouvez modifier vos filtres ou effectuer une nouvelle recherche.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if ($rendezVous->hasPages())
            <div class="border-t border-stone-100 px-6 py-4">
                {{ $rendezVous->links() }}
            </div>
        @endif

        <div class="border-t border-stone-100 px-6 py-4">
            <p class="text-xs text-stone-400">
                {{ $rendezVous->total() }}
                rendez-vous enregistré(s).
            </p>
        </div>

    </div>

</div>

</x-layouts.app>
