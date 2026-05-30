<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditServiceConfig;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        if (isset($settings['contact_emails'])) {
            $settings['contact_emails'] = json_decode($settings['contact_emails'], true);
        }
        if (isset($settings['contact_phones'])) {
            $settings['contact_phones'] = json_decode($settings['contact_phones'], true);
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function visibility(Request $request)
    {
        $query = CreditServiceConfig::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('cle', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->orderBy('ordre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.settings.visibility', compact('services'));
    }

    public function visibilityCreate()
    {
        return view('admin.settings.visibility-create');
    }

    public function visibilityStore(Request $request)
    {
        $validated = $request->validate([
            'service_type'   => 'required|in:mise_en_avant,boost,video',
            'description'    => 'nullable|string',
            'credits_requis' => 'required|integer|min:0',
            'duree_jours'    => 'nullable|integer|min:1',
            'actif'          => 'boolean',
            'ordre'          => 'integer',
        ]);

        $serviceInfo = $this->getServiceInfo($validated['service_type']);
        
        // Check if this service type already exists
        if (CreditServiceConfig::where('cle', $serviceInfo['cle'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['service_type' => "Une configuration pour le service '{$serviceInfo['nom']}' existe déjà."]);
        }

        $validated['nom'] = $serviceInfo['nom'];
        $validated['cle'] = $serviceInfo['cle'];
        $validated['actif'] = $request->boolean('actif', true);
        
        CreditServiceConfig::create($validated);

        return redirect()->route('admin.settings.visibility')->with('success', 'Option de visibilité créée avec succès.');
    }

    public function visibilityEdit(CreditServiceConfig $service)
    {
        return view('admin.settings.visibility-edit', compact('service'));
    }

    public function visibilityUpdate(Request $request, CreditServiceConfig $service)
    {
        $validated = $request->validate([
            'service_type'   => 'required|in:mise_en_avant,boost,video',
            'description'    => 'nullable|string',
            'credits_requis' => 'required|integer|min:0',
            'duree_jours'    => 'nullable|integer|min:1',
            'actif'          => 'boolean',
            'ordre'          => 'integer',
        ]);

        $serviceInfo = $this->getServiceInfo($validated['service_type']);
        
        // Check if changed to a type that already exists elsewhere
        if ($service->cle !== $serviceInfo['cle'] && CreditServiceConfig::where('cle', $serviceInfo['cle'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['service_type' => "Une autre configuration pour le service '{$serviceInfo['nom']}' existe déjà."]);
        }

        $validated['nom'] = $serviceInfo['nom'];
        $validated['cle'] = $serviceInfo['cle'];
        $validated['actif'] = $request->boolean('actif');
        
        $service->update($validated);

        return redirect()->route('admin.settings.visibility')->with('success', 'Option de visibilité mise à jour.');
    }

    private function getServiceInfo($type)
    {
        $map = [
            'mise_en_avant' => ['nom' => 'Mise en avant', 'cle' => 'mise_en_avant'],
            'boost'         => ['nom' => 'Boost visibilité', 'cle' => 'boost'],
            'video'         => ['nom' => 'Ajout Vidéo', 'cle' => 'video'],
        ];
        return $map[$type] ?? null;
    }

    public function visibilityDestroy(CreditServiceConfig $service)
    {
        $service->delete();
        return redirect()->route('admin.settings.visibility')->with('success', 'Option de visibilité supprimée.');
    }

    public function visibilityToggle(CreditServiceConfig $service)
    {
        $service->update(['actif' => !$service->actif]);
        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'logo', 'contact_emails', 'contact_phones']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        // Handle multiple emails
        if ($request->has('contact_emails')) {
            Setting::set('contact_emails', json_encode(array_values(array_filter($request->contact_emails))), 'json');
        }

        // Handle multiple phone numbers
        if ($request->has('contact_phones')) {
            Setting::set('contact_phones', json_encode(array_values(array_filter($request->contact_phones))), 'json');
        }

        if ($request->has('remove_logo') && $request->remove_logo == '1') {
            $oldPath = Setting::get('logo');
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            Setting::set('logo', null);
        }

        if ($request->hasFile('logo')) {
            // Delete old logo
            $oldPath = Setting::get('logo');
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $path, 'image');
        }

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
