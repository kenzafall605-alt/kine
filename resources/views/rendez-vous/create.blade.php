<x-layouts.app title="Nouveau rendez-vous">

    <x-page-header
        title="Nouveau rendez-vous"
        description="Planifiez une nouvelle prestation pour un client du salon."
    />

    <div class="mt-6 max-w-5xl">

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- En-tête bordeaux --}}
            <div class="border-b border-slate-100 bg-rose-950 px-6 py-5">
                <h2 class="text-lg font-semibold text-white">
                    Planifier un rendez-vous
                </h2>
                <p class="mt-1 text-sm text-rose-100">
                    Complétez les informations pour enregistrer le rendez-vous.
                </p>
            </div>

            <form
                action="{{ route('rendez-vous.store') }}"
                method="POST"
                class="p-6 sm:p-8"
            >
                @csrf

                {{-- Informations du rendez-vous --}}
                <div class="mb-8">

                    <div class="mb-5">
                        <h3 class="text-base font-semibold text-slate-800">
                            Informations du client
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Sélectionnez un client déjà enregistré.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Client --}}
                        <div class="sm:col-span-2">
                            <label for="client_id" class="mb-2 block text-sm font-medium text-slate-700">
                                Client <span class="text-rose-700">*</span>
                            </label>

                            <select
                                id="client_id"
                                name="client_id"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >
                                <option value="">Sélectionner un client</option>

                                @forelse ($clients as $client)
                                    <option
                                        value="{{ $client->id }}"
                                        @selected(old('client_id') == $client->id)
                                    >
                                        {{ $client->prenom }} {{ $client->nom }}
                                        — {{ $client->telephone }}
                                    </option>
                                @empty
                                    <option value="" disabled>
                                        Aucun client actif disponible
                                    </option>
                                @endforelse
                            </select>

                            @error('client_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            @if ($clients->isEmpty())
                                <p class="mt-2 text-sm text-amber-700">
                                    Aucun client actif n'est disponible.
                                    <a href="{{ route('clients.create') }}" class="font-semibold underline">
                                        Ajouter un client
                                    </a>
                                </p>
                            @endif
                        </div>

                        {{-- Prestation --}}
                        <div class="sm:col-span-2">
                            <label for="prestation" class="mb-2 block text-sm font-medium text-slate-700">
                                Prestation <span class="text-rose-700">*</span>
                            </label>

                            <input
                                type="text"
                                id="prestation"
                                name="prestation"
                                value="{{ old('prestation') }}"
                                placeholder="Ex : Tresses, coupe, massage, soin du visage..."
                                required
                                maxlength="255"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >

                            @error('prestation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Date et horaires --}}
                <div class="border-t border-slate-100 pt-7 mb-8">

                    <div class="mb-5">
                        <h3 class="text-base font-semibold text-slate-800">
                            Date et horaires
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Définissez le jour et la durée de la prestation.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Date --}}
                        <div class="sm:col-span-2">
                            <label for="date_rendez_vous" class="mb-2 block text-sm font-medium text-slate-700">
                                Date du rendez-vous <span class="text-rose-700">*</span>
                            </label>

                            <input
                                type="date"
                                id="date_rendez_vous"
                                name="date_rendez_vous"
                                value="{{ old('date_rendez_vous') }}"
                                min="{{ now()->toDateString() }}"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >

                            @error('date_rendez_vous')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Heure de début --}}
                        <div>
                            <label for="heure_debut" class="mb-2 block text-sm font-medium text-slate-700">
                                Heure de début <span class="text-rose-700">*</span>
                            </label>

                            <input
                                type="time"
                                id="heure_debut"
                                name="heure_debut"
                                value="{{ old('heure_debut') }}"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >

                            @error('heure_debut')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Heure de fin --}}
                        <div>
                            <label for="heure_fin" class="mb-2 block text-sm font-medium text-slate-700">
                                Heure de fin <span class="text-rose-700">*</span>
                            </label>

                            <input
                                type="time"
                                id="heure_fin"
                                name="heure_fin"
                                value="{{ old('heure_fin') }}"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >

                            @error('heure_fin')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Informations financières --}}
                <div class="border-t border-slate-100 pt-7 mb-8">

                    <div class="mb-5">
                        <h3 class="text-base font-semibold text-slate-800">
                            Tarification et statut
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Indiquez le prix et l'état du rendez-vous.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Prix --}}
                        <div>
                            <label for="prix" class="mb-2 block text-sm font-medium text-slate-700">
                                Prix (FCFA) <span class="text-rose-700">*</span>
                            </label>

                            <input
                                type="number"
                                id="prix"
                                name="prix"
                                value="{{ old('prix') }}"
                                placeholder="Ex : 15000"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >

                            @error('prix')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Statut --}}
                        <div>
                            <label for="statut" class="mb-2 block text-sm font-medium text-slate-700">
                                Statut <span class="text-rose-700">*</span>
                            </label>

                            <select
                                id="statut"
                                name="statut"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                            >
                                <option value="en_attente" @selected(old('statut', 'en_attente') === 'en_attente')>
                                    En attente
                                </option>

                                <option value="confirme" @selected(old('statut') === 'confirme')>
                                    Confirmé
                                </option>

                                <option value="annule" @selected(old('statut') === 'annule')>
                                    Annulé
                                </option>
                            </select>

                            @error('statut')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Notes --}}
                <div class="border-t border-slate-100 pt-7">

                    <div class="mb-5">
                        <h3 class="text-base font-semibold text-slate-800">
                            Informations complémentaires
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Ajoutez des remarques si nécessaire.
                        </p>
                    </div>

                    <div>
                        <label for="notes" class="mb-2 block text-sm font-medium text-slate-700">
                            Notes
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Préférences du client, demandes particulières..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-rose-800 focus:bg-white focus:ring-4 focus:ring-rose-100"
                        >{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Boutons --}}
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px; border-top: 1px solid #f1f1f1; padding-top: 24px; margin-top: 32px;">

                    <a
                        href="{{ route('rendez-vous.index') }}"
                        style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; border: 1px solid #cbd5e1; border-radius: 10px; color: #475569; text-decoration: none; font-size: 14px; font-weight: 600;"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        style="display: inline-flex !important; visibility: visible !important; opacity: 1 !important; align-items: center; justify-content: center; padding: 12px 24px; background-color: #7b1e3a !important; color: white !important; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;"
                    >
                        Enregistrer le rendez-vous
                    </button>

                </div>

            </form>
        </div>

        <p class="mt-4 text-xs text-slate-400">
            Les champs marqués d'un astérisque (*) sont obligatoires.
        </p>

    </div>

</x-layouts.app>
