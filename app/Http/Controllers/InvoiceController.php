<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::paginate(10);
        return response()->json([
            "message" => "Berhasil mendapatkan data invoice",
            "data" => $invoices
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "StockCode" => "required|integer",
            "Description" => "required|string",
            "Quantity" => "required|string",
            "UnitPrice" => "required|integer",
            "CustomerId" => "required|integer",
            "Country" => "required|string"
        ]);

        $invoiceNo = random_int(536367, 1000000);

        $invoice = Invoice::create([
            "InvoiceNo" => $invoiceNo,
            "StockCode" => $validated['StockCode'],
            "Description" => $validated['Description'],
            "Quantity" => $validated['Quantity'],
            "InvoiceDate" => now(),
            "UnitPrice" => $validated['UnitPrice'],
            "CustomerId" => $validated['CustomerId'],
            "Country" => $validated['Country'],
        ]);

        return response()->json([
            "message" => "Berhasil menambahkan data",
            "invoice" => $invoice
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $invoiceNo)
    {
        $validated = $request->validate([
            "StockCode" => "nullable|integer",
            "Description" => "nullable|string",
            "Quantity" => "nullable|string",
            "UnitPrice" => "nullable|integer",
            "CustomerId" => "nullable|integer",
            "Country" => "nullable|string"
        ]);

        $invoice = Invoice::where('InvoiceNo', (int) $invoiceNo)->first();

        if (!$invoice) {
            return response()->json([
                "message" => "Invoice Tidak Ada",
            ], 404);
        }

        $invoice->update($validated);

        return response()->json([
            "message" => "Berhasil update data",
            "invoice" => $invoice
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoiceNo)
    {
        $invoice = Invoice::where('InvoiceNo', (int) $invoiceNo)->first();

        if (!$invoice) {
            return response()->json([
                "message" => "Invoice Tidak Ada"
            ], 404);
        }

        $invoice->delete();

        return response()->json([
            "message" => "Berhasil delete data",
            "invoice" => $invoice
        ], 200);
    }
}
