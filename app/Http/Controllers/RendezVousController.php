<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $query = RendezVous::with('client');

        // Recherche par nom, prénom ou téléphone
        if ($request->filled('recherche')) {
            $recherche = $request->recherche;

            $query->whereHas('client', function ($q) use ($recherche) {
                $q->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('prenom', 'like', "%{$recherche}%")
                    ->orWhere('telephone', 'like', "%{$recherche}%");
            });
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('date_rendez_vous', $request->date);
        }

        // Liste des rendez-vous
        $rendezVous = $query
            ->orderBy('date_rendez_vous')
            ->orderBy('heure_debut')
            ->paginate(10)
            ->withQueryString();

        // Statistiques
        $aujourdHui = RendezVous::whereDate(
            'date_rendez_vous',
            today()
        )->count();

        $confirmes = RendezVous::whereIn('statut', [
            'confirme',
            'confirmé',
        ])->count();

        $enAttente = RendezVous::where(
            'statut',
            'en_attente'
        )->count();

        $annules = RendezVous::whereIn('statut', [
            'annule',
            'annulé',
        ])->count();

        return view('rendez-vous.index', compact(
            'rendezVous',
            'aujourdHui',
            'confirmes',
            'enAttente',
            'annules'
        ));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $clients = Client::where('statut', true)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('rendez-vous.create', compact('clients'));
    }

    /**
     * Enregistrer un nouveau rendez-vous.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id')
                    ->where(fn ($query) => $query
                        ->where('statut', true)
                        ->whereNull('deleted_at')),
            ],

            'prestation' => [
                'required',
                'string',
                'max:255',
            ],

            'date_rendez_vous' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'heure_debut' => [
                'required',
                'date_format:H:i',
            ],

            'heure_fin' => [
                'required',
                'date_format:H:i',
                'after:heure_debut',
            ],

            'prix' => [
                'required',
                'numeric',
                'min:0',
            ],

            'statut' => [
                'required',
                Rule::in([
                    'en_attente',
                    'confirme',
                    'confirmé',
                    'annule',
                    'annulé',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        // Vérifier les conflits horaires
        $conflit = RendezVous::whereDate(
            'date_rendez_vous',
            $validated['date_rendez_vous']
        )
            ->whereNotIn('statut', [
                'annule',
                'annulé',
            ])
            ->whereTime('heure_debut', '<', $validated['heure_fin'])
            ->whereTime('heure_fin', '>', $validated['heure_debut'])
            ->exists();

        if ($conflit) {
            return back()
                ->withErrors([
                    'heure_debut' => 'Ce créneau est déjà occupé. Veuillez choisir un autre horaire.',
                ])
                ->withInput();
        }

        // Enregistrer le rendez-vous
        RendezVous::create($validated);

        return redirect()
            ->route('rendez-vous.index')
            ->with('success', 'Le rendez-vous a été créé avec succès.');
    }

    /**
     * Consulter les détails d'un rendez-vous.
     */
    public function show(RendezVous $rendezVous)
    {
        $rendezVous->load('client');

        return view('rendez-vous.show', compact('rendezVous'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(RendezVous $rendezVous)
    {
        $rendezVous->load('client');

        $clients = Client::where('statut', true)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        // Conserver le client actuel même s'il a été archivé.
        if ($rendezVous->client &&
            !$clients->contains('id', $rendezVous->client_id)) {
            $clients->push($rendezVous->client);
        }

        $clients = $clients->sortBy('nom')->values();

        return view('rendez-vous.edit', compact(
            'rendezVous',
            'clients'
        ));
    }

    /**
     * Enregistrer les modifications.
     */
    public function update(Request $request, RendezVous $rendezVous)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id')
                    ->where(function ($query) use ($rendezVous) {
                        $query->where(function ($q) use ($rendezVous) {
                            $q->where(function ($active) {
                                $active->where('statut', true)
                                    ->whereNull('deleted_at');
                            })->orWhere('id', $rendezVous->client_id);
                        });
                    }),
            ],
            'prestation' => ['required', 'string', 'max:255'],
            'date_rendez_vous' => ['required', 'date'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin' => [
                'required',
                'date_format:H:i',
                'after:heure_debut',
            ],
            'prix' => ['required', 'numeric', 'min:0'],
            'statut' => [
                'required',
                Rule::in([
                    'en_attente',
                    'confirme',
                    'confirmé',
                    'annule',
                    'annulé',
                ]),
            ],
            'notes' => ['nullable', 'string'],
        ]);

        // Vérifier les conflits sans compter le rendez-vous actuel.
        $conflit = RendezVous::whereDate(
            'date_rendez_vous',
            $validated['date_rendez_vous']
        )
            ->where('id', '!=', $rendezVous->id)
            ->whereNotIn('statut', ['annule', 'annulé'])
            ->whereTime('heure_debut', '<', $validated['heure_fin'])
            ->whereTime('heure_fin', '>', $validated['heure_debut'])
            ->exists();

        if ($conflit) {
            return back()
                ->withErrors([
                    'heure_debut' => 'Ce créneau est déjà occupé. Choisissez un autre horaire.',
                ])
                ->withInput();
        }

        $rendezVous->update($validated);

        return redirect()
            ->route('rendez-vous.index')
            ->with('success', 'Le rendez-vous a été modifié avec succès.');
    }

    /**
     * Annuler un rendez-vous sans supprimer son historique.
     */
    public function destroy(RendezVous $rendezVous)
    {
        if (in_array($rendezVous->statut, ['annule', 'annulé'])) {
            return redirect()
                ->route('rendez-vous.index')
                ->with('info', 'Ce rendez-vous est déjà annulé.');
        }

        $rendezVous->update([
            'statut' => 'annule',
        ]);

        return redirect()
            ->route('rendez-vous.index')
            ->with('success', 'Le rendez-vous a été annulé avec succès.');
    }

}
