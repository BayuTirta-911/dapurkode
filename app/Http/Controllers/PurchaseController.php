<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Discount;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Storage;



class PurchaseController extends Controller
{
    // Menampilkan semua invoice
    public function index()
    {
        $purchases = Invoice::orderByRaw("FIELD(status, 'Paid') DESC")
        ->orderBy('created_at', 'desc')
        ->get();
        return view('admin.purchases.index', compact('purchases'));
    }

    // Menampilkan detail invoice
    public function show($id)
    {
        $purchases = Invoice::findOrFail($id);
        $discount = Discount::where('id', '=', $purchases->discount_code)->pluck('code')->first();
        $discountamount = Discount::where('id', '=', $purchases->discount_code)->pluck('amount')->first();
        if ($discountamount < 100) {
            $discountamount = Discount::where('id', '=', $purchases->discount_code)->pluck('amount')->first().'%';
        }
        else {
            $discountamount = 'Rp.'.Discount::where('id', '=', $purchases->discount_code)->pluck('amount')->first();
        }
        //$discountcode = $discount->code;
        //echo($discount); die;
        
        //var_dump($purchases);die;
        return view('admin.purchases.show', compact('purchases','discount','discountamount'));
    }

    // Mengupdate status invoice
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Finished,Paid,Waiting Payment,Expired,Rejected',
        ]);

        $purchase = Invoice::findOrFail($id);
        $purchase->status = $request->status;
        $purchase->save();

        return redirect()->route('admin.purchases.index')->with('success', 'Status berhasil diubah.');
    }

    // Menghapus invoice
    public function destroy($id)
    {
        $purchase = Invoice::findOrFail($id);
        $purchase->delete();

        return redirect()->route('admin.purchases.index')->with('success', 'Invoice berhasil dihapus.');
    }

    public function showReport($id)
    {
        $purchase = Invoice::findOrFail($id); // Mengambil data invoice berdasarkan ID
        $banks = BankAccount::all(); // Mengambil daftar bank untuk ditampilkan
        return view('invoice.report', compact('purchase', 'banks'));
    }

    // Menangani upload bukti transfer
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $purchase = Invoice::findOrFail($id);
        $file = $request->file('proof');
        $path = $file->store('proofs', 'public'); // Menyimpan foto bukti transfer di storage/public/proofs

        // Simpan path bukti transfer ke database
        $purchase->proof = $path;
        $purchase->status = 'paid'; // Set status jika perlu
        $purchase->save();

        return redirect()->route('invoice.report', $purchase->id)->with('success', 'Bukti transfer berhasil diupload');
    }
}
