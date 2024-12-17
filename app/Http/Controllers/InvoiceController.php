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
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian (jika ada)
        $search = $request->input('search');

        // Filter data berdasarkan id_buyer dan keyword pencarian
        $invoices = Invoice::where('id_buyer', Auth::id())
            ->when($search, function ($query, $search) {
                $query->where('service_name', 'like', '%' . $search . '%')
                    ->orWhere('invoice_id', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->paginate(10); // Pagination dengan 10 item per halaman

        return view('invoice.index', compact('invoices', 'search'));
    }

    // Menampilkan halaman invoice
    public function show($id, Request $request)
    {
        $service = Service::findOrFail($id); // Ambil data service
        $og_price = $service->price_1+$service->installer_fee+$service->affiliator_fee+$service->other_fee;
        //session()->flash('total_price', $og_price);
        // Periksa apakah status service adalah 'approved'
        if ($service->status !== 'approved') {
        // Jika tidak approved, arahkan ke halaman 404
        abort(404);
    }
        $banks = BankAccount::all(); // Ambil semua bank
        $discount = null; // Diskon default null
        // Tangkap parameter `aff` dari URL
        $affiliateCode = $request->query('aff', ''); // Default kosong jika tidak ada

        return view('invoice.show', compact('service', 'banks', 'discount','affiliateCode','og_price'));
    }

    // Memproses pembelian
    public function process(Request $request, $id)
    {
        $request->validate([
            'address' => 'nullable',
            'phone' => 'nullable',
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
            'address' => 'null',
            'phone' => 'null',
            'note' => $request->note,
            'bank_id' => $request->bank,
            'og_price' => str_replace(',', '', $request->og_price),
            'og_disc' => str_replace(',', '', $request->og_disc),
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

    // public function applyDiscount(Request $request, $id)
    // {
    //     // Validasi kode diskon
    //     $request->validate([
    //         'discount_code' => 'required|string',
    //     ]);

    //     $service = Service::findOrFail($id);  // Ambil service berdasarkan ID
    //     $discountCode = $request->input('discount_code');
    //     $affiliateCode = $request->query('aff'); // Tangkap query string 'aff'
        
    //     // Cari diskon berdasarkan kode yang dimasukkan
    //     $discount = Discount::where('code', $discountCode)->first();
    //     if ($discount == NULL) {
    //         $link = route('invoice.show', ['id' => $service->id]).'?aff='.$affiliateCode;
    //         return redirect($link)->withErrors(['discount_code' => 'Kode diskon tidak valid!']);
    //     }
    //     $discounttrueAmount = $discount->amount;
    //     if ($discount) {
    //         // Hitung total harga setelah diskon
    //         if ($discount->amount <= 100){
    //             $discountAmount = $service->price_1*$discount->amount/100;
    //             $discountWarn = "Your Discount is ".$discount->amount."%";
    //         }
    //         else{
    //             $discountAmount = $discount->amount;
    //             $discountWarn = "Your Discount is Rp.".$discount->amount;
    //         }
    //         $totalPrice = $service->price_1+$service->installer_fee+$service->affiliator_fee+$service->other_fee - $discountAmount;
    //         $discountCodeUsed = $discount->code;
    //         // Simpan diskon dalam session untuk ditampilkan pada halaman
    //         session()->flash('discount_amount', $discountAmount);
    //         session()->flash('discount_true_amount', $discounttrueAmount);
    //         session()->flash('total_price', $totalPrice);
    //         session()->flash('discountcodeused', $discountCodeUsed);
    //         session()->flash('discountwarn', $discountWarn);
    //         //var_dump($affiliateCode); die;
    //         // Kembalikan ke halaman invoice dengan diskon diterapkan
    //         $link = route('invoice.show', ['id' => $service->id]).'?aff='.$affiliateCode;
    //         //var_dump($link); die;
    //         return redirect($link);
    //     }

    //     // Jika kode diskon tidak valid
    //     $link = route('invoice.show', ['id' => $service->id]).'?aff='.$affiliateCode;
    //     return redirect($link)->withErrors(['discount_code' => 'Kode diskon tidak valid!']);
    // }
    public function applyDiscount(Request $request, $id)
    {
        // Validasi kode diskon
        $request->validate([
            'discount_code' => 'required|string',
        ]);

        $service = Service::findOrFail($id); // Ambil service berdasarkan ID
        $discountCode = $request->input('discount_code');
        $affiliateCode = $request->query('aff'); // Tangkap query string 'aff'

        // Cari diskon berdasarkan kode yang dimasukkan
        $discount = Discount::where('code', $discountCode)->first();

        // Jika diskon tidak ditemukan
        if (!$discount) {
            $link = route('invoice.show', ['id' => $service->id]) . '?aff=' . $affiliateCode;
            return redirect($link)->withErrors(['discount_code' => 'Kode diskon tidak valid!']);
        }

        // Periksa apakah diskon dapat digunakan pada service ini
        $serviceIds = json_decode($discount->service_ids, true); // Decode JSON service_ids menjadi array
        if (!in_array($service->id, $serviceIds)) {
            $link = route('invoice.show', ['id' => $service->id]) . '?aff=' . $affiliateCode;
            return redirect($link)->withErrors(['discount_code' => 'Kode diskon tidak berlaku untuk layanan ini!']);
        }

        // Hitung jumlah diskon
        $discountTrueAmount = $discount->amount;

        if ($discount->amount <= 100) {
            // Jika diskon dalam bentuk persentase
            $discountAmount = $service->price_1 * $discount->amount / 100;
            $discountWarn = "Your Discount is " . $discount->amount . "%";
        } else {
            // Jika diskon dalam bentuk nominal
            $discountAmount = $discount->amount;
            $discountWarn = "Your Discount is Rp." . number_format($discount->amount, 2);
        }

        // Hitung total harga setelah diskon
        $totalPrice = $service->price_1 + $service->installer_fee + $service->affiliator_fee + $service->other_fee - $discountAmount;
        $discountCodeUsed = $discount->code;

        // Simpan diskon dalam session untuk ditampilkan di halaman
        session()->flash('discount_amount', $discountAmount);
        session()->flash('discount_true_amount', $discountTrueAmount);
        session()->flash('total_price', $totalPrice);
        session()->flash('discountcodeused', $discountCodeUsed);
        session()->flash('discountwarn', $discountWarn);

        // Redirect ke halaman invoice dengan diskon diterapkan
        $link = route('invoice.show', ['id' => $service->id]) . '?aff=' . $affiliateCode;
        return redirect($link);
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
