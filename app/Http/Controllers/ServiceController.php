<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private function verifierPermission(string $permission): void
    {
        abort_unless(
            auth()->user()?->hasPermission($permission),
            403
        );
    }

    // LISTE DES PRESTATIONS
    public function index(Request $request)
    {
        $this->verifierPermission('services.view');

        $query = Service::with('category');

        // Recherche
        if ($request->filled('recherche')) {
            $recherche = $request->recherche;

            $query->where('nom', 'like', "%{$recherche}%");
        }

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->where('service_category_id', $request->categorie);
        }

        // Filtre par statut
        if ($request->statut === 'actif') {
            $query->where('actif', true);
        } elseif ($request->statut === 'inactif') {
            $query->where('actif', false);
        }

        $services = $query->latest()->paginate(10)->withQueryString();

        $categories = ServiceCategory::orderBy('ordre')
            ->orderBy('nom')
            ->get();

        $totalPrestations = Service::count();
        $totalActives = Service::where('actif', true)->count();
        $totalCategories = ServiceCategory::count();

        return view('prestations.index', compact(
            'services',
            'categories',
            'totalPrestations',
            'totalActives',
            'totalCategories'
        ));
    }

    // FORMULAIRE DE CREATION
    public function create()
    {
        $this->verifierPermission('services.manage');

        $categories = ServiceCategory::where('actif', true)
            ->orderBy('ordre')
            ->orderBy('nom')
            ->get();

        return view('prestations.create', compact('categories'));
    }

    // ENREGISTREMENT
    public function store(Request $request)
    {
        $this->verifierPermission('services.manage');

        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'duree_minutes' => 'required|integer|min:1',
        ]);

        $validated['actif'] = true;

        Service::create($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'La prestation a été ajoutée avec succès.');
    }

    // FORMULAIRE DE MODIFICATION
    public function edit(Service $service)
    {
        $this->verifierPermission('services.manage');

        $categories = ServiceCategory::orderBy('ordre')
            ->orderBy('nom')
            ->get();

        return view('prestations.edit', compact(
            'service',
            'categories'
        ));
    }

    // MISE A JOUR
    public function update(Request $request, Service $service)
    {
        $this->verifierPermission('services.manage');

        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'duree_minutes' => 'required|integer|min:1',
        ]);

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'La prestation a été modifiée avec succès.');
    }

    // ACTIVER / DESACTIVER UNE PRESTATION
    public function toggleStatus(Service $service)
    {
        $this->verifierPermission('services.manage');

        $service->update([
            'actif' => !$service->actif,
        ]);

        return redirect()
            ->route('services.index')
            ->with('success', 'Le statut de la prestation a été modifié.');
    }
}
