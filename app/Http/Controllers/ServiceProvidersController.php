<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;

class ServiceProvidersController extends Controller
{
    public function index()
    {
        $serviceProviders = ServiceProvider::all();
        return view('admin.service-providers.index', compact('serviceProviders'));
    }

    public function update(Request $request, $providerID)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'contact_info' => 'nullable|string',
        ]);

        // Find the service provider and update
        $provider = ServiceProvider::findOrFail($providerID);
        $provider->update([
            'name' => $request->name,
            'service_type' => $request->service_type,
            'contact_info' => $request->contact_info,
        ]);

        return redirect()->route('service-providers.index')->with('success', 'Service provider updated successfully!');
    }
}
