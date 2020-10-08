<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SuppliersController extends Controller
{
    public function index()
    {
        return Inertia::render('Suppliers/Index', [
            'filters' => Request::all('search', 'trashed'),
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'phone', 'city', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Suppliers/Create');
    }

    public function store()
    {
        Auth::user()->account->suppliers()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'address' => ['nullable', 'max:150'],
                'postal_code' => ['nullable', 'max:25'],
                'city' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'contact' => ['nullable', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'notes' => ['nullable'],
            ])
        );

        return Redirect::route('suppliers')->with('success', 'Leverancier aangemaakt.');
    }

    public function edit(Supplier $supplier)
    {
        return Inertia::render('Suppliers/Edit', [
            'supplier' => [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'address' => $supplier->address,
                'postal_code' => $supplier->postal_code,
                'city' => $supplier->city,
                'country' => $supplier->country,
                'contact' => $supplier->contact,
                'email' => $supplier->email,
                'phone' => $supplier->phone,
                'notes' => $supplier->notes,
                'deleted_at' => $supplier->deleted_at,
//                'contacts' => $supplier->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Supplier $supplier)
    {
        $supplier->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'address' => ['nullable', 'max:150'],
                'postal_code' => ['nullable', 'max:25'],
                'city' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'contact' => ['nullable', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'notes' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', 'Leverancier opgeslagen.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return Redirect::back()->with('success', 'Leverancier verwijderd.');
    }

    public function restore(Supplier $supplier)
    {
        $supplier->restore();

        return Redirect::back()->with('success', 'Leverancier hersteld.');
    }
}
