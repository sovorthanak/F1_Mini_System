<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::all();
        return view('administration.tariffs.index', compact('tariffs'));
    }

    public function create()
    {
        return view('administration.tariffs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        Tariff::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => true, // or false if you prefer to start inactive
        ]);

        return redirect()->route('tariffs.index')->with('status', 'Tariff created successfully!');
    }

    public function edit(Tariff $tariff)
    {
        return view('tariffs.edit', compact('tariff'));
    }

    public function update(Request $request, Tariff $tariff)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $tariff->update($request->all());

        return redirect()->route('tariffs.index')->with('status', 'Tariff updated!');
    }

    public function destroy($id)
    {
        $tariff = Tariff::findOrFail($id);
        $tariff->delete();

        return redirect()->route('tariffs.index')->with('status', 'Tariff deleted successfully.');
    }

    public function toggleStatus(Tariff $tariff)
    {
        $tariff->status = !$tariff->status;
        $tariff->save();

        return redirect()->back()->with('status', 'Tariff status updated successfully!');
    }


}
