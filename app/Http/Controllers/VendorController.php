<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class VendorController extends Controller
{
    public function showBalance()
    {
        $user = auth()->user();

        // Hitung reward yang bisa diklaim (service yang dijual oleh vendor dengan status invoice 'finished')
        $potentialReward = Invoice::where('project_status', 'finished')
            ->whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id); // Hanya service yang dibuat oleh vendor saat ini
            })
            ->where('updated_at', '>', $user->last_balance_updated ?? '1970-01-01 00:00:00')
            ->get()
            ->sum(function ($invoice) {
                return $invoice->service->price_1 ?? 0; // Harga service
            });

        return view('vendor.balance', compact('user', 'potentialReward'));
    }

    public function updateBalance()
    {
        $user = auth()->user();

        // Hitung reward yang bisa diklaim
        $reward = Invoice::where('project_status', 'finished')
            ->whereHas('service', function ($query) use ($user) {
                $query->where('user_id', $user->id); // Hanya service yang dibuat oleh vendor saat ini
            })
            ->where('updated_at', '>', $user->last_balance_updated ?? '1970-01-01 00:00:00')
            ->get()
            ->sum(function ($invoice) {
                return $invoice->service->price_1 ?? 0;
            });

        // Tambahkan reward ke saldo vendor
        $user->increment('balance', $reward);
        $user->update(['last_balance_updated' => now()]);

        return redirect()->route('vendor.balance')->with('success', 'Balance updated successfully.');
    }

}
