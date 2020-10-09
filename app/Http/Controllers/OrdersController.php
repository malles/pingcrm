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
                ->with('supplier', 'parc')
                ->orderBy('order_date', 'desc')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($order) {
                    return [
                        'id' => $order->id,
                        'order_date' => $order->order_date,
                        'reference' => $order->reference,
                        'cost_price' => $order->cost_price,
                        'selling_price' => $order->selling_price,
                        'deleted_at' => $order->deleted_at,
                        'parc' => $order->parc ? $order->parc->only('name') : null,
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
            'parcs' => Auth::user()->account
                ->parcs()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->orders()->create(
            Request::validate([
                'parc_id' => ['required', Rule::exists('parcs', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'supplier_id' => ['required', Rule::exists('suppliers', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'cost_price' => ['nullable', 'numeric'],
                'selling_price' => ['nullable', 'numeric'],
                'vat' => ['nullable', 'numeric'],
                'internal_invoice_id' => ['nullable', 'max:50'],
                'external_invoice_id' => ['nullable', 'max:50'],
                'ordered_at' => ['nullable', 'date'],
                'shipped_at' => ['nullable', 'date'],
                'received_at' => ['nullable', 'date'],
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
                'order_date' => $order->order_date,
                'reference' => $order->reference,
                'parc_id' => $order->parc_id,
                'supplier_id' => $order->supplier_id,
                'internal_invoice_id' => $order->internal_invoice_id,
                'external_invoice_id' => $order->external_invoice_id,
                'cost_price' => $order->cost_price,
                'selling_price' => $order->selling_price,
                'vat' => $order->vat,
                'ordered_at' => $order->ordered_at,
                'shipped_at' => $order->shipped_at,
                'received_at' => $order->received_at,
                'invoiced_at' => $order->invoiced_at,
                'notes' => $order->notes,
                'deleted_at' => $order->deleted_at,
            ],
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'parcs' => Auth::user()->account->parcs()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Order $order)
    {
        $order->update(
            Request::validate([
                'order_date' => ['required', 'date'],
                'reference' => ['required', 'max:50'],
                'parc_id' => ['required', Rule::exists('parcs', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'supplier_id' => ['required', Rule::exists('suppliers', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'cost_price' => ['nullable', 'numeric'],
                'selling_price' => ['nullable', 'numeric'],
                'vat' => ['nullable', 'numeric'],
                'internal_invoice_id' => ['nullable', 'max:50'],
                'external_invoice_id' => ['nullable', 'max:50'],
                'ordered_at' => ['nullable', 'date'],
                'shipped_at' => ['nullable', 'date'],
                'received_at' => ['nullable', 'date'],
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
