<?php

namespace App\Http\Controllers;

use App\Models\Bandwidth;
use Illuminate\Http\Request;

class BandwidthController extends Controller
{
    public function index()
    {
        $bandwidths = Bandwidth::where('status', 1)
            ->orderByRaw("CAST(REPLACE(speed, 'Mbps', '') AS UNSIGNED) ASC")
            ->get();
            
        return view('administration.bandwidths.index', compact('bandwidths'));
    }

    public function create()
    {
        return view('administration.bandwidths.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bandwidth' => 'required|integer|min:1',
        ]);

        $bandwidthValue = $request->input('bandwidth') . ' Mbps';

        Bandwidth::create([
            'speed' => $bandwidthValue, // string like "50 Mbps"
            'status' => 1,
        ]);

        return redirect()->back()->with('status', 'Bandwidth added successfully.');
    }

    public function toggleStatus(Bandwidth $bandwidth)
    {
        $bandwidth->status = !$bandwidth->status;
        $bandwidth->save();

        return redirect()->back()->with('status', 'Bandwidth status updated.');
    }

    public function destroy(Bandwidth $bandwidth)
    {
        $bandwidth->delete();
        return redirect()->back()->with('status', 'Bandwidth deleted successfully.');
    }
}
