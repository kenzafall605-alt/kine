
<x-layouts.app title="Modifier le rendez-vous">

    <x-page-header
        title="Modifier le rendez-vous"
        description="Mettez à jour les informations du rendez-vous."
    />

    <div class="mt-6 max-w-5xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 bg-rose-950 px-6 py-5">
                <h2 class="text-lg font-semibold text-white">
                    Modifier le rendez-vous #{{ $rendezVous->id }}
                </h2>
                <p class="mt-1 text-sm text-rose-100">
                    Modifiez les informations puis enregistrez les changements.
                </p>
            </div>

            <form action="{{ route('rendez-vous.update', $rendezVous) }}"
                  method="POST"
                  class="p-6 sm:p-8">
                @csrf
                @method('PUT')

                <div class="mb-8">
                    <h3 class="mb-5 text-base font-semibold text-slate-800">
                        Informations du client
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        <div class="sm:col-span-2">
                            <label for="client_id" class="mb-2 block text-sm font-medium text-slate-700">
                                Client *
                            </label>

                            <select id="client_id" name="client_id" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">
                                <option value="">Sélectionner un client</option>

                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        @selected(old('client_id', $rendezVous->client_id) == $client->id)>
                                        {{ $client->prenom }} {{ $client->nom }}
                                        — {{ $client->telephone }}
                                    </option>
                                @endforeach
                            </select>

                            @error('client_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="prestation" class="mb-2 block text-sm font-medium text-slate-700">
                                Prestation *
                            </label>

                            <input type="text" id="prestation" name="prestation"
                                value="{{ old('prestation', $rendezVous->prestation) }}"
                                maxlength="255" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">

                            @error('prestation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="mb-8 border-t border-slate-100 pt-7">
                    <h3 class="mb-5 text-base font-semibold text-slate-800">
                        Date et horaires
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        <div class="sm:col-span-2">
                            <label for="date_rendez_vous" class="mb-2 block text-sm font-medium text-slate-700">
                                Date du rendez-vous *
                            </label>

                            <input type="date" id="date_rendez_vous" name="date_rendez_vous"
                                value="{{ old('date_rendez_vous', \Illuminate\Support\Carbon::parse($rendezVous->date_rendez_vous)->format('Y-m-d')) }}"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">

                            @error('date_rendez_vous')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="heure_debut" class="mb-2 block text-sm font-medium text-slate-700">
                                Heure de début *
                            </label>

                            <input type="time" id="heure_debut" name="heure_debut"
                                value="{{ old('heure_debut', substr($rendezVous->heure_debut, 0, 5)) }}"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">

                            @error('heure_debut')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="heure_fin" class="mb-2 block text-sm font-medium text-slate-700">
                                Heure de fin *
                            </label>

                            <input type="time" id="heure_fin" name="heure_fin"
                                value="{{ old('heure_fin', substr($rendezVous->heure_fin, 0, 5)) }}"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">

                            @error('heure_fin')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="mb-8 border-t border-slate-100 pt-7">
                    <h3 class="mb-5 text-base font-semibold text-slate-800">
                        Tarification et statut
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        <div>
                            <label for="prix" class="mb-2 block text-sm font-medium text-slate-700">
                                Prix (FCFA) *
                            </label>

                            <input type="number" id="prix" name="prix"
                                value="{{ old('prix', $rendezVous->prix) }}"
                                min="0" step="0.01" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">

                            @error('prix')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="statut" class="mb-2 block text-sm font-medium text-slate-700">
                                Statut *
                            </label>

                            <select id="statut" name="statut" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">

                                <option value="en_attente"
                                    @selected(old('statut', $rendezVous->statut) === 'en_attente')>
                                    En attente
                                </option>

                                <option value="confirme"
                                    @selected(in_array(old('statut', $rendezVous->statut), ['confirme', 'confirmé']))>
                                    Confirmé
                                </option>

                                <option value="annule"
                                    @selected(in_array(old('statut', $rendezVous->statut), ['annule', 'annulé']))>
                                    Annulé
                                </option>
                            </select>

                            @error('statut')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="border-t border-slate-100 pt-7">
                    <h3 class="mb-5 text-base font-semibold text-slate-800">
                        Informations complémentaires
                    </h3>

                    <label for="notes" class="mb-2 block text-sm font-medium text-slate-700">
                        Notes
                    </label>

                    <textarea id="notes" name="notes" rows="3"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-rose-800 focus:bg-white">{{ old('notes', $rendezVous->notes) }}</textarea>

                    @error('notes')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-6">

                    <a href="{{ route('rendez-vous.show', $rendezVous) }}"
                       style="display:inline-flex;padding:12px 24px;border:1px solid #cbd5e1;border-radius:10px;color:#475569;text-decoration:none;font-weight:600;">
                        Retour
                    </a>

                    <button type="submit"
                        style="display:inline-flex;padding:12px 24px;background:#7b1e3a;color:white;border:0;border-radius:10px;font-weight:600;cursor:pointer;">
                        Enregistrer les modifications
                    </button>

                </div>

            </form>
        </div>
    </div>

</x-layouts.app>
