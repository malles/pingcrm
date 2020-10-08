<?php

namespace App\Http\Controllers;

use App\Models\Parc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ParcsController extends Controller
{
    public function index()
    {
        return Inertia::render('Parcs/Index', [
            'filters' => Request::all('search', 'trashed'),
            'parcs' => Auth::user()->account->parcs()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'code', 'name', 'phone', 'city', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Parcs/Create');
    }

    public function store()
    {
        Auth::user()->account->parcs()->create(
            Request::validate([
                'code' => ['required', 'max:32'],
                'name' => ['required', 'max:100'],
                'address' => ['nullable', 'max:150'],
                'postal_code' => ['nullable', 'max:25'],
                'city' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'contact' => ['nullable', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::route('parcs')->with('success', 'Park aangemaakt.');
    }

    public function edit(Parc $parc)
    {
        return Inertia::render('Parcs/Edit', [
            'parc' => [
                'id' => $parc->id,
                'code' => $parc->code,
                'name' => $parc->name,
                'address' => $parc->address,
                'postal_code' => $parc->postal_code,
                'city' => $parc->city,
                'country' => $parc->country,
                'contact' => $parc->contact,
                'email' => $parc->email,
                'phone' => $parc->phone,
                'deleted_at' => $parc->deleted_at,
            ],
        ]);
    }

    public function update(Parc $parc)
    {
        $parc->update(
            Request::validate([
                'code' => ['required', 'max:32'],
                'name' => ['required', 'max:100'],
                'address' => ['nullable', 'max:150'],
                'postal_code' => ['nullable', 'max:25'],
                'city' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'contact' => ['nullable', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::back()->with('success', 'Park opgeslagen.');
    }

    public function destroy(Parc $parc)
    {
        $parc->delete();

        return Redirect::back()->with('success', 'Park verwijderd.');
    }

    public function restore(Parc $parc)
    {
        $parc->restore();

        return Redirect::back()->with('success', 'Parck hersteld.');
    }
}
