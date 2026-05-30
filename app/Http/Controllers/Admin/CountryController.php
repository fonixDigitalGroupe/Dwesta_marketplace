<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected function getAfricanCountries()
    {
        return [
            ['name' => 'Algérie', 'code' => 'DZ', 'phone' => '+213', 'format' => '00 00 00 00', 'emoji' => '🇩🇿', 'lat' => 28.0339, 'lng' => 1.6596],
            ['name' => 'Angola', 'code' => 'AO', 'phone' => '+244', 'format' => '000 000 000', 'emoji' => '🇦🇴', 'lat' => -11.2027, 'lng' => 17.8739],
            ['name' => 'Bénin', 'code' => 'BJ', 'phone' => '+229', 'format' => '00 00 00 00', 'emoji' => '🇧🇯', 'lat' => 9.3077, 'lng' => 2.3158],
            ['name' => 'Botswana', 'code' => 'BW', 'phone' => '+267', 'format' => '00 000 000', 'emoji' => '🇧🇼', 'lat' => -22.3285, 'lng' => 24.6849],
            ['name' => 'Burkina Faso', 'code' => 'BF', 'phone' => '+226', 'format' => '00 00 00 00', 'emoji' => '🇧🇫', 'lat' => 12.2383, 'lng' => -1.5616],
            ['name' => 'Burundi', 'code' => 'BI', 'phone' => '+257', 'format' => '00 00 00 00', 'emoji' => '🇧🇮', 'lat' => -3.3731, 'lng' => 29.9189],
            ['name' => 'Cabo Verde', 'code' => 'CV', 'phone' => '+238', 'format' => '000 00 00', 'emoji' => '🇨🇻', 'lat' => 16.002, 'lng' => -24.0131],
            ['name' => 'Cameroun', 'code' => 'CM', 'phone' => '+237', 'format' => '0 00 00 00 00', 'emoji' => '🇨🇲', 'lat' => 7.3697, 'lng' => 12.3547],
            ['name' => 'République Centrafricaine', 'code' => 'CF', 'phone' => '+236', 'format' => '00 00 00 00', 'emoji' => '🇨🇫', 'lat' => 6.6111, 'lng' => 20.9394],
            ['name' => 'Tchad', 'code' => 'TD', 'phone' => '+235', 'format' => '00 00 00 00', 'emoji' => '🇹🇩', 'lat' => 15.4542, 'lng' => 18.7322],
            ['name' => 'Comores', 'code' => 'KM', 'phone' => '+269', 'format' => '00 00 00 00', 'emoji' => '🇰🇲', 'lat' => -11.6455, 'lng' => 43.3333],
            ['name' => 'Congo-Brazzaville', 'code' => 'CG', 'phone' => '+242', 'format' => '00 00 00 00', 'emoji' => '🇨🇬', 'lat' => -0.228, 'lng' => 15.8277],
            ['name' => 'Congo-Kinshasa (RDC)', 'code' => 'CD', 'phone' => '+243', 'format' => '000 000 000', 'emoji' => '🇨🇩', 'lat' => -4.0383, 'lng' => 21.7587],
            ['name' => 'Djibouti', 'code' => 'DJ', 'phone' => '+253', 'format' => '00 00 00 00', 'emoji' => '🇩🇯', 'lat' => 11.8251, 'lng' => 42.5903],
            ['name' => 'Égypte', 'code' => 'EG', 'phone' => '+20', 'format' => '000 000 0000', 'emoji' => '🇪🇬', 'lat' => 26.8206, 'lng' => 30.8025],
            ['name' => 'Guinée Équatoriale', 'code' => 'GQ', 'phone' => '+240', 'format' => '000 000 000', 'emoji' => '🇬🇶', 'lat' => 1.6508, 'lng' => 10.2679],
            ['name' => 'Érythrée', 'code' => 'ER', 'phone' => '+291', 'format' => '0 000 000', 'emoji' => '🇪🇷', 'lat' => 15.1794, 'lng' => 39.7823],
            ['name' => 'Eswatini', 'code' => 'SZ', 'phone' => '+268', 'format' => '0000 0000', 'emoji' => '🇸🇿', 'lat' => -26.5225, 'lng' => 31.4659],
            ['name' => 'Éthiopie', 'code' => 'ET', 'phone' => '+251', 'format' => '00 000 0000', 'emoji' => '🇪🇹', 'lat' => 9.145, 'lng' => 40.4897],
            ['name' => 'Gabon', 'code' => 'GA', 'phone' => '+241', 'format' => '0 00 00 00 00', 'emoji' => '🇬🇦', 'lat' => -0.8037, 'lng' => 11.6094],
            ['name' => 'Gambie', 'code' => 'GM', 'phone' => '+220', 'format' => '000 0000', 'emoji' => '🇬🇲', 'lat' => 13.4432, 'lng' => -15.3101],
            ['name' => 'Ghana', 'code' => 'GH', 'phone' => '+233', 'format' => '00 000 0000', 'emoji' => '🇬🇭', 'lat' => 7.9465, 'lng' => -1.0232],
            ['name' => 'Guinée', 'code' => 'GN', 'phone' => '+224', 'format' => '000 00 00 00', 'emoji' => '🇬🇳', 'lat' => 9.9456, 'lng' => -9.6966],
            ['name' => 'Guinée-Bissau', 'code' => 'GW', 'phone' => '+245', 'format' => '0 000 000', 'emoji' => '🇬🇼', 'lat' => 11.8037, 'lng' => -15.1804],
            ['name' => 'Côte d’Ivoire', 'code' => 'CI', 'phone' => '+225', 'format' => '00 00 00 00 00', 'emoji' => '🇨🇮', 'lat' => 7.54, 'lng' => -5.5471],
            ['name' => 'Kenya', 'code' => 'KE', 'phone' => '+254', 'format' => '000 000 000', 'emoji' => '🇰🇪', 'lat' => -0.0236, 'lng' => 37.9062],
            ['name' => 'Lesotho', 'code' => 'LS', 'phone' => '+266', 'format' => '0000 0000', 'emoji' => '🇱🇸', 'lat' => -29.61, 'lng' => 28.2336],
            ['name' => 'Liberia', 'code' => 'LR', 'phone' => '+231', 'format' => '00 000 0000', 'emoji' => '🇱🇷', 'lat' => 6.4281, 'lng' => -9.4295],
            ['name' => 'Libye', 'code' => 'LY', 'phone' => '+218', 'format' => '00 0000000', 'emoji' => '🇱🇾', 'lat' => 26.3351, 'lng' => 17.2283],
            ['name' => 'Madagascar', 'code' => 'MG', 'phone' => '+261', 'format' => '00 00 000 00', 'emoji' => '🇲🇬', 'lat' => -18.7669, 'lng' => 46.8691],
            ['name' => 'Malawi', 'code' => 'MW', 'phone' => '+265', 'format' => '0 0000 0000', 'emoji' => '🇲🇼', 'lat' => -13.2543, 'lng' => 34.3015],
            ['name' => 'Mali', 'code' => 'ML', 'phone' => '+223', 'format' => '00 00 00 00', 'emoji' => '🇲🇱', 'lat' => 17.5707, 'lng' => -3.9962],
            ['name' => 'Mauritanie', 'code' => 'MR', 'phone' => '+222', 'format' => '00 00 00 00', 'emoji' => '🇲🇷', 'lat' => 21.0079, 'lng' => -10.9408],
            ['name' => 'Maurice', 'code' => 'MU', 'phone' => '+230', 'format' => '0000 0000', 'emoji' => '🇲🇺', 'lat' => -20.3484, 'lng' => 57.5522],
            ['name' => 'Maroc', 'code' => 'MA', 'phone' => '+212', 'format' => '0-00000000', 'emoji' => '🇲🇦', 'lat' => 31.7917, 'lng' => -7.0926],
            ['name' => 'Mozambique', 'code' => 'MZ', 'phone' => '+258', 'format' => '00 000 0000', 'emoji' => '🇲🇿', 'lat' => -18.6657, 'lng' => 35.5296],
            ['name' => 'Namibie', 'code' => 'NA', 'phone' => '+264', 'format' => '00 000 0000', 'emoji' => '🇳🇦', 'lat' => -22.9576, 'lng' => 18.4904],
            ['name' => 'Niger', 'code' => 'NE', 'phone' => '+227', 'format' => '00 00 00 00', 'emoji' => '🇳🇪', 'lat' => 17.6078, 'lng' => 8.0817],
            ['name' => 'Nigeria', 'code' => 'NG', 'phone' => '+234', 'format' => '000 000 0000', 'emoji' => '🇳🇬', 'lat' => 9.082, 'lng' => 8.6753],
            ['name' => 'Rwanda', 'code' => 'RW', 'phone' => '+250', 'format' => '000 000 000', 'emoji' => '🇷🇼', 'lat' => -1.9403, 'lng' => 29.8739],
            ['name' => 'Sao Tomé-et-Principe', 'code' => 'ST', 'phone' => '+239', 'format' => '000 0000', 'emoji' => '🇸🇹', 'lat' => 0.1864, 'lng' => 6.6131],
            ['name' => 'Sénégal', 'code' => 'SN', 'phone' => '+221', 'format' => '00 000 00 00', 'emoji' => '🇸🇳', 'lat' => 14.4974, 'lng' => -14.4524],
            ['name' => 'Seychelles', 'code' => 'SC', 'phone' => '+248', 'format' => '0 000 000', 'emoji' => '🇸🇨', 'lat' => -4.6796, 'lng' => 55.492],
            ['name' => 'Sierra Leone', 'code' => 'SL', 'phone' => '+232', 'format' => '00 000000', 'emoji' => '🇸🇱', 'lat' => 8.4606, 'lng' => -11.7799],
            ['name' => 'Somalie', 'code' => 'SO', 'phone' => '+252', 'format' => '0 0000000', 'emoji' => '🇸🇴', 'lat' => 5.1521, 'lng' => 46.1996],
            ['name' => 'Afrique du Sud', 'code' => 'ZA', 'phone' => '+27', 'format' => '00 000 0000', 'emoji' => '🇿🇦', 'lat' => -30.5595, 'lng' => 22.9375],
            ['name' => 'Soudan du Sud', 'code' => 'SS', 'phone' => '+211', 'format' => '000000000', 'emoji' => '🇸🇸', 'lat' => 6.877, 'lng' => 31.307],
            ['name' => 'Soudan', 'code' => 'SD', 'phone' => '+249', 'format' => '00 0000000', 'emoji' => '🇸🇩', 'lat' => 12.8628, 'lng' => 30.2176],
            ['name' => 'Tanzanie', 'code' => 'TZ', 'phone' => '+255', 'format' => '000 000 000', 'emoji' => '🇹🇿', 'lat' => -6.369, 'lng' => 34.8888],
            ['name' => 'Togo', 'code' => 'TG', 'phone' => '+228', 'format' => '00 00 00 00', 'emoji' => '🇹🇬', 'lat' => 8.6195, 'lng' => 0.8248],
            ['name' => 'Tunisie', 'code' => 'TN', 'phone' => '+216', 'format' => '00 000 000', 'emoji' => '🇹🇳', 'lat' => 33.8869, 'lng' => 9.5375],
            ['name' => 'Ouganda', 'code' => 'UG', 'phone' => '+256', 'format' => '000 000 000', 'emoji' => '🇺🇬', 'lat' => 1.3733, 'lng' => 32.2903],
            ['name' => 'Zambie', 'code' => 'ZM', 'phone' => '+260', 'format' => '000000000', 'emoji' => '🇿🇲', 'lat' => -13.1339, 'lng' => 27.8493],
            ['name' => 'Zimbabwe', 'code' => 'ZW', 'phone' => '+263', 'format' => '0 0000000', 'emoji' => '🇿🇼', 'lat' => -19.0154, 'lng' => 29.1549],
        ];
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $countries = Country::query()
            ->when($search, function($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return view('admin.countries.index', compact('countries', 'search', 'perPage'));
    }

    public function create()
    {
        $africanCountries = $this->getAfricanCountries();
        return view('admin.countries.create', compact('africanCountries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:5|unique:countries,code',
            'phone_code' => 'nullable|string|max:10',
            'phone_format' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:10',
            'flag' => 'nullable|string|max:50',
            'map' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'map_external_url' => 'nullable|url',
            'is_active' => 'nullable|boolean'
        ]);

        $mapPath = null;
        if ($request->hasFile('map')) {
            $mapPath = $request->file('map')->store('maps', 'public');
        } elseif ($request->filled('map_external_url')) {
            try {
                $contents = file_get_contents($request->map_external_url);
                if ($contents) {
                    $filename = 'maps/' . strtolower($request->code) . '_' . time() . '.png';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $contents);
                    $mapPath = $filename;
                }
            } catch (\Exception $e) {
                // Fail silently or log error
            }
        }

        Country::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'phone_code' => $request->phone_code,
            'phone_format' => $request->phone_format,
            'currency' => $request->currency ?? 'FCFA',
            'flag' => $request->flag,
            'map' => $mapPath,
            'is_active' => $request->has('is_active') ? $request->is_active : true
        ]);

        return redirect()->route('admin.countries.index')->with('success', 'Pays créé avec succès. Carte récupérée automatiquement.');
    }

    public function edit(Country $country)
    {
        $africanCountries = $this->getAfricanCountries();
        return view('admin.countries.edit', compact('country', 'africanCountries'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:5|unique:countries,code,' . $country->id,
            'phone_code' => 'nullable|string|max:10',
            'phone_format' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:10',
            'flag' => 'nullable|string|max:255',
            'map' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('flag')) {
            if ($country->flag) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($country->flag);
            }
            $country->flag = $request->file('flag')->store('flags', 'public');
        }

        if ($request->hasFile('map')) {
            if ($country->map) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($country->map);
            }
            $country->map = $request->file('map')->store('maps', 'public');
        }

        $country->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'phone_code' => $request->phone_code,
            'phone_format' => $request->phone_format,
            'currency' => $request->currency ?? 'FCFA',
            'flag' => $request->flag ?? $country->flag,
            'is_active' => $request->has('is_active') ? $request->is_active : true
        ]);
        
        $country->save();

        return redirect()->route('admin.countries.index')->with('success', 'Pays mis à jour avec succès.');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.countries.index')->with('success', 'Pays supprimé avec succès.');
    }

    public function toggleStatus(Country $country)
    {
        $country->is_active = !$country->is_active;
        $country->save();

        return back()->with('success', 'Statut du pays mis à jour.');
    }
}
