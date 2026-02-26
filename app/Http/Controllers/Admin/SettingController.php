<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
