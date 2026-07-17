<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index()
    {
        // Load default settings if not exists (usually should be done via Seeder)
        $this->ensureDefaultSettings();

        $settings = Setting::getAllGrouped();
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                // For checkboxes (booleans), if they are in the request they are true
                // We handle missing checkboxes below
                $setting->update(['value' => $value]);
            }
        }

        // Handle missing checkboxes (if a boolean setting was unchecked, it's missing from $request)
        $booleanSettings = Setting::where('type', 'boolean')->get();
        foreach ($booleanSettings as $setting) {
            if (!isset($data[$setting->key])) {
                $setting->update(['value' => 'false']);
            } else {
                $setting->update(['value' => 'true']);
            }
        }

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètres mis à jour avec succès.');
    }

    private function ensureDefaultSettings()
    {
        if (Setting::count() === 0) {
            $defaults = [
                ['key' => 'biblio_nom', 'value' => 'Bibliothèque Universitaire de Dakar', 'type' => 'string', 'category' => 'general'],
                ['key' => 'biblio_adresse', 'value' => 'Dakar, Sénégal', 'type' => 'string', 'category' => 'general'],
                ['key' => 'biblio_telephone', 'value' => '33 825 20 20', 'type' => 'string', 'category' => 'general'],
                ['key' => 'biblio_email', 'value' => 'contact@bibliotheque.sn', 'type' => 'string', 'category' => 'general'],
                
                ['key' => 'pret_duree', 'value' => '14', 'type' => 'integer', 'category' => 'prets'],
                ['key' => 'pret_max_prolongations', 'value' => '1', 'type' => 'integer', 'category' => 'prets'],
                ['key' => 'pret_duree_prolongation', 'value' => '7', 'type' => 'integer', 'category' => 'prets'],
                
                ['key' => 'penalite_etudiant', 'value' => '100', 'type' => 'integer', 'category' => 'penalites'],
                ['key' => 'penalite_enseignant', 'value' => '50', 'type' => 'integer', 'category' => 'penalites'],
                ['key' => 'penalite_externe', 'value' => '250', 'type' => 'integer', 'category' => 'penalites'],
                ['key' => 'penalite_seuil_blocage', 'value' => '1000', 'type' => 'integer', 'category' => 'penalites'],
                
                ['key' => 'notif_rappel', 'value' => 'true', 'type' => 'boolean', 'category' => 'notifications'],
                ['key' => 'notif_retard', 'value' => 'true', 'type' => 'boolean', 'category' => 'notifications'],
                ['key' => 'notif_confirmation', 'value' => 'true', 'type' => 'boolean', 'category' => 'notifications'],
            ];

            foreach ($defaults as $default) {
                Setting::create($default);
            }
        }
    }
}
