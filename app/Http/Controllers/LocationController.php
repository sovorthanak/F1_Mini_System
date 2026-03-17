<?php

namespace App\Http\Controllers;
use App\Models\Location;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('administration.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('administration.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Location::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => true, // default active
        ]);

        return redirect()->route('locations.index')->with('status', 'Location created successfully.');
    }


    public function toggleStatus(Location $location)
    {
        $location->status = !$location->status;
        $location->save();

        return redirect()->back()->with('status', 'Location status updated.');
    }
    
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')->with('status', 'Location deleted successfully.');
    }

}
