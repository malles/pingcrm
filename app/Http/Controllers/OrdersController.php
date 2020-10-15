<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index()
    {
        return Inertia::render('Orders/Index', [
            'filters' => Request::all('search', 'trashed'),
            'orders' => Auth::user()->account->orders()
                ->with('supplier', 'park')
                ->orderBy('reference', 'desc')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($order) {
                    return [
                        'id' => $order->id,
                        'ordered_at' => $order->ordered_at,
                        'reference' => $order->reference,
                        'park_reference' => $order->park_reference,
                        'cost_price' => $order->cost_price,
                        'selling_price' => $order->selling_price,
                        'deleted_at' => $order->deleted_at,
                        'park' => $order->park ? $order->park->only('code') : null,
                        'supplier' => $order->supplier ? $order->supplier->only('name') : null,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Orders/Create', [
            'suppliers' => Auth::user()->account
                ->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'parks' => Auth::user()->account
                ->parks()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'products' => Auth::user()->account->products()
                ->orderBy('name')
                ->get()
                ->map
                ->only([
                    'id', 'supplier_id', 'name', 'park_reference', 'supplier_reference',
                    'cost_price', 'selling_price',
                ]),
        ]);
    }

    public function store()
    {
        Auth::user()->account->orders()->create(
            Request::validate([
                'park_reference' => ['required', 'max:50'],
                'park_id' => ['required', Rule::exists('parks', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'supplier_id' => ['required', Rule::exists('suppliers', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'cost_price' => ['nullable', 'numeric'],
                'carriage_price' => ['nullable', 'numeric'],
                'selling_price' => ['nullable', 'numeric'],
                'vat' => ['nullable', 'numeric'],
                'internal_invoice_id' => ['nullable', 'max:50'],
                'external_invoice_id' => ['nullable', 'max:50'],
                'invoiced_at' => ['nullable', 'date'],
                'notes' => ['nullable'],
            ])
        );

        return Redirect::route('orders')->with('success', 'Order aangemaakt.');
    }

    public function edit(Order $order)
    {
        return Inertia::render('Orders/Edit', [
            'order' => [
                'id' => $order->id,
                'ordered_at' => $order->ordered_at,
                'park_reference' => $order->park_reference,
                'reference' => $order->reference,
                'park_id' => $order->park_id,
                'supplier_id' => $order->supplier_id,
                'internal_invoice_id' => $order->internal_invoice_id,
                'external_invoice_id' => $order->external_invoice_id,
                'cost_price' => $order->cost_price,
                'carriage_price' => $order->carriage_price,
                'selling_price' => $order->selling_price,
                'vat' => $order->vat,
                'invoiced_at' => $order->invoiced_at,
                'notes' => $order->notes,
                'deleted_at' => $order->deleted_at,
            ],
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'parks' => Auth::user()->account->parks()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'products' => Auth::user()->account->products()
                ->orderBy('name')
                ->get()
                ->map
                ->only([
                    'id', 'supplier_id', 'name', 'park_reference', 'supplier_reference',
                    'cost_price', 'selling_price',
                ]),
        ]);
    }

    public function update(Order $order)
    {
        $order->update(
            Request::validate([
                'ordered_at' => ['required', 'date'],
                'park_reference' => ['required', 'max:50'],
                'reference' => ['required', 'max:50', Rule::unique('orders')->ignore($order->id),],
                'park_id' => ['required', Rule::exists('parks', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'supplier_id' => ['required', Rule::exists('suppliers', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'cost_price' => ['nullable', 'numeric'],
                'carriage_price' => ['nullable', 'numeric'],
                'selling_price' => ['nullable', 'numeric'],
                'vat' => ['nullable', 'numeric'],
                'internal_invoice_id' => ['nullable', 'max:50'],
                'external_invoice_id' => ['nullable', 'max:50'],
                'invoiced_at' => ['nullable', 'date'],
                'notes' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', 'Order opgeslagen.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return Redirect::back()->with('success', 'Order verwijderd.');
    }

    public function restore(Order $order)
    {
        $order->restore();

        return Redirect::back()->with('success', 'Order hersteld.');
    }
}
