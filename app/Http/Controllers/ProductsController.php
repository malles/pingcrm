<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Auth::user()->account->products()
                ->with('supplier')
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'cost_price' => $product->cost_price,
                        'selling_price' => $product->selling_price,
                        'deleted_at' => $product->deleted_at,
                        'supplier' => $product->supplier ? $product->supplier->only('name') : null,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create', [
            'suppliers' => Auth::user()->account
                ->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->products()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'supplier_id' => ['nullable', Rule::exists('suppliers', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'park_reference' => ['nullable', 'max:100'],
                'supplier_reference' => ['nullable', 'max:100'],
                'cost_price' => ['nullable', 'numeric'],
                'selling_price' => ['nullable', 'numeric'],
                'vat' => ['nullable', 'numeric'],
                'notes' => ['nullable'],
            ])
        );

        return Redirect::route('products')->with('success', 'Produkt aangemaakt.');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'supplier_id' => $product->supplier_id,
                'park_reference' => $product->park_reference,
                'supplier_reference' => $product->supplier_reference,
                'cost_price' => $product->cost_price,
                'selling_price' => $product->selling_price,
                'vat' => $product->vat,
                'notes' => $product->notes,
                'deleted_at' => $product->deleted_at,
            ],
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Product $product)
    {
        $product->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'supplier_id' => ['nullable', Rule::exists('suppliers', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'park_reference' => ['nullable', 'max:100'],
                'supplier_reference' => ['nullable', 'max:100'],
                'cost_price' => ['nullable', 'numeric'],
                'vat' => ['nullable', 'numeric'],
                'selling_price' => ['nullable', 'numeric'],
                'notes' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', 'Produkt opgeslagen.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return Redirect::back()->with('success', 'Produkt verwijderd.');
    }

    public function restore(Product $product)
    {
        $product->restore();

        return Redirect::back()->with('success', 'Produkt hersteld.');
    }
}
