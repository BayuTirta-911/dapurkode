<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InstallerController extends Controller
{
    public function showBalance()
    {
        $user = auth()->user();

        // Hitung reward yang bisa diklaim (proyek 'finished' sejak terakhir update saldo)
        $potentialReward = Invoice::where('project_status', 'finished')
            ->whereHas('projectRequests', function ($query) use ($user) {
                $query->where('installer_id', $user->id)->where('status', 'approved');
            })
            ->where('updated_at', '>', $user->last_balance_updated ?? '1970-01-01 00:00:00')
            ->get()
            ->sum(function ($invoice) {
                return $invoice->service->installer_fee ?? 0;
            });

        return view('installer.balance', compact('user', 'potentialReward'));
    }

    public function updateBalance()
    {
        $user = auth()->user();

        // Hitung reward yang bisa diklaim
        $reward = Invoice::where('project_status', 'finished')
            ->whereHas('projectRequests', function ($query) use ($user) {
                $query->where('installer_id', $user->id)->where('status', 'approved');
            })
            ->where('updated_at', '>', $user->last_balance_updated ?? '1970-01-01 00:00:00')
            ->get()
            ->sum(function ($invoice) {
                return $invoice->service->installer_fee ?? 0;
            });

        // Tambahkan reward ke saldo
        $user->increment('balance', $reward);
        $user->update(['last_balance_updated' => now()]);

        return redirect()->route('installer.balance')->with('success', 'Balance updated successfully.');
    }
}
