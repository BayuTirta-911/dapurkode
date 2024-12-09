<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class AffiliateController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Dapatkan kode affiliate dari tabel affiliate_request
        $affiliateCode = $user->affiliateRequest->affiliate_code ?? null;

        // Pastikan kode affiliate ada
        if (!$affiliateCode) {
            return redirect()->route('dashboard')->with('error', 'You do not have an affiliate code.');
        }

        // Ambil daftar pembelian berdasarkan kode affiliate, gunakan paginate
        $purchases = Invoice::where('affiliate_code', $affiliateCode)
            ->with(['buyer'])
            ->paginate(10); // Menampilkan 10 item per halaman

        return view('affiliate.purchases.index', compact('purchases'));
    }

    public function showBalance()
    {
        $user = Auth::user();

        // Dapatkan kode affiliate user
        $affiliateCode = $user->affiliateRequest->affiliate_code ?? null;

        // Pastikan user memiliki kode affiliate
        if (!$affiliateCode) {
            return redirect()->route('dashboard')->with('error', 'You do not have an affiliate code.');
        }

        // Hitung total reward potensial dari transaksi selesai
        $potentialReward = Invoice::where('affiliate_code', $affiliateCode)
            ->where('status', 'finished')
            ->where('updated_at', '>', $user->last_balance_updated ?? '1970-01-01') // Dari tanggal terakhir cek saldo
            ->with('service')
            ->get()
            ->sum(fn($invoice) => $invoice->service->affiliator_fee);

        return view('affiliate.balance', compact('user', 'potentialReward'));
    }

    public function updateBalance()
    {
        $user = Auth::user();

        // Dapatkan kode affiliate user
        $affiliateCode = $user->affiliateRequest->affiliate_code ?? null;

        // Validasi keberadaan kode affiliate
        if (!$affiliateCode) {
            return redirect()->route('dashboard')->with('error', 'You do not have an affiliate code.');
        }

        // Hitung reward baru berdasarkan `affiliator_fee`
        $newReward = Invoice::where('affiliate_code', $affiliateCode)
            ->where('status', 'Finished')
            ->where('updated_at', '>', $user->last_balance_updated ?? '1970-01-01')
            ->with('service')
            ->get()
            ->sum(fn($invoice) => $invoice->service->affiliator_fee);

        // Tambahkan reward ke saldo user
        $user->increment('balance', $newReward);

        // Perbarui waktu terakhir saldo diperbarui
        $user->update(['last_balance_updated' => now()]);

        return redirect()->route('affiliate.balance')->with('success', 'Balance updated successfully!');
    }


}

