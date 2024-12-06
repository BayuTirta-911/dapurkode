<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Discount;
use App\Models\PurchaseReport;
use App\Models\Service;
use App\Models\User;
use App\Models\Invoice;
use App\Models\AffiliateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{   
    public function index()
    {
        // Mengambil data invoice berdasarkan id_buyer yang sesuai dengan user login
        $invoices = Invoice::where('id_buyer', Auth::id())->get();

        return view('invoice.index', compact('invoices'));
    }
    // Menampilkan halaman invoice
    public function show($id, Request $request)
    {
        $service = Service::findOrFail($id); // Ambil data service
        $banks = BankAccount::all(); // Ambil semua bank
        $discount = null; // Diskon default null
        // Tangkap parameter `aff` dari URL
        $affiliateCode = $request->query('aff', ''); // Default kosong jika tidak ada

        return view('invoice.show', compact('service', 'banks', 'discount','affiliateCode'));
    }

    // Memproses pembelian
    public function process(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'note' => 'nullable',
            'bank' => 'required',
        ]);

        $service = Service::findOrFail($id);

        // Validasi diskon
        $discount = Discount::where('code', $request->discount_code)
            ->whereJsonContains('service_ids', (string) $id)
            ->first();
        $totalPrice = $service->price_1;
        if ($discount) {
            $totalPrice -= $discount->amount;
        }

        // Simpan invoice
        $invoice = Invoice::create([
            'invoice_id' => uniqid(),
            'id_service' => $service->id,
            'id_buyer' => Auth::id(),
            'service_name' => $service->name,
            'total_price' => str_replace(',', '', $request->summary),
            'discount_code' => $request->discountcodeused,
            'address' => $request->address,
            'phone' => $request->phone,
            'note' => $request->note,
            'bank_id' => $request->bank,
            'affiliate_code' => $request->affiliate_code, // Menyimpan kode affiliate
        ]);
        //var_dump($invoice); die;

        return redirect()->route('invoice.report', $invoice->id)
            ->with('success', 'Invoice berhasil diproses. Silakan lakukan pembayaran.');
    }


    // Menampilkan laporan pembelian
    public function showPurchase($id)
    {
        $purchase = PurchaseReport::with('service', 'bank')->findOrFail($id);

        return view('purchase.show', compact('purchase'));
    }

    // Mengunggah bukti pembayaran
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $purchase = PurchaseReport::findOrFail($id);
        $proofPath = $request->file('proof')->store('payment_proofs', 'public');

        // Simpan bukti pembayaran (bisa ditambahkan kolom di tabel)
        $purchase->status = 'paid';
        $purchase->save();

        return redirect()->route('user.invoices.index', $purchase->id)->with('success', 'Payment proof uploaded successfully.');
    }

    public function applyDiscount(Request $request, $id)
    {
        // Validasi kode diskon
        $request->validate([
            'discount_code' => 'required|string',
        ]);

        $service = Service::findOrFail($id);  // Ambil service berdasarkan ID
        $discountCode = $request->input('discount_code');
        $affiliateCode = $request->query('aff'); // Tangkap query string 'aff'
        
        // Cari diskon berdasarkan kode yang dimasukkan
        $discount = Discount::where('code', $discountCode)->first();
        
        if ($discount) {
            // Hitung total harga setelah diskon
            if ($discount->amount <= 100){
                $discountAmount = $service->price_1*$discount->amount/100;
                $discountWarn = "Your DIscount is ".$discount->amount."%";
            }
            else{
                $discountAmount = $discount->amount;
                $discountWarn = "Your Discount is Rp.".$discount->amount;
            }
            $totalPrice = $service->price_1 + $service->installer_fee + $service->other_fee - $discountAmount;
            $discountCodeUsed = $discount->id;
            // Simpan diskon dalam session untuk ditampilkan pada halaman
            session()->flash('discount_amount', $discountAmount);
            session()->flash('total_price', $totalPrice);
            session()->flash('discountcodeused', $discountCodeUsed);
            session()->flash('discountwarn', $discountWarn);
            //var_dump($affiliateCode); die;
            // Kembalikan ke halaman invoice dengan diskon diterapkan
            $link = route('invoice.show', ['id' => $service->id]).'?aff='.$affiliateCode;
            //var_dump($link); die;
            return redirect($link);
        }

        // Jika kode diskon tidak valid
        $link = route('invoice.show', ['id' => $service->id]).'?aff='.$affiliateCode;
        return redirect($link)->withErrors(['discount_code' => 'Kode diskon tidak valid!']);
    }

    public function showWithAffiliate($id, $affiliateCode)
    {
        $service = Service::findOrFail($id);

        // Validasi affiliate code
        $affiliateUser = AffiliateRequest::where('affiliate_code', $affiliateCode)->first();
        if (!$affiliateUser) {
            return redirect()->route('invoice.show', $id)->with('error', 'Invalid affiliate code.');
        }

        return view('invoices.show', compact('service', 'affiliateCode', 'affiliateUser'));
    }
}
