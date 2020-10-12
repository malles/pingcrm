<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ParksController extends Controller
{
    public function index()
    {
        return Inertia::render('Parks/Index', [
            'filters' => Request::all('search', 'trashed'),
            'parks' => Auth::user()->account->parks()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'code', 'name', 'contact', 'city', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Parks/Create');
    }

    public function store()
    {
        Auth::user()->account->parks()->create(
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
                'notes' => ['nullable'],
            ])
        );

        return Redirect::route('parks')->with('success', 'Park aangemaakt.');
    }

    public function edit(Park $park)
    {
        return Inertia::render('Parks/Edit', [
            'park' => [
                'id' => $park->id,
                'code' => $park->code,
                'name' => $park->name,
                'address' => $park->address,
                'postal_code' => $park->postal_code,
                'city' => $park->city,
                'country' => $park->country,
                'contact' => $park->contact,
                'email' => $park->email,
                'phone' => $park->phone,
                'notes' => $park->notes,
                'deleted_at' => $park->deleted_at,
            ],
        ]);
    }

    public function update(Park $park)
    {
        $park->update(
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
                'notes' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', 'Park opgeslagen.');
    }

    public function destroy(Park $park)
    {
        $park->delete();

        return Redirect::back()->with('success', 'Park verwijderd.');
    }

    public function restore(Park $park)
    {
        $park->restore();

        return Redirect::back()->with('success', 'Park hersteld.');
    }
}
