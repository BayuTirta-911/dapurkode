<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    // Menampilkan halaman withdraw untuk affiliator
    public function index()
    {
        $requests = Auth::user()->withdrawRequests()->orderBy('created_at', 'desc')->get();
        return view('withdraw.index', compact('requests'));
    }

    // Membuat permintaan withdraw
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        if ($user->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }

        // Kurangi saldo user
        $user->decrement('balance', $request->amount);

        // Buat request withdraw
        WithdrawRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('withdraw.index')->with('success', 'Withdraw request submitted.');
    }

    // Menampilkan daftar request untuk admin
    public function adminIndex()
    {
        $requests = WithdrawRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.withdraws.index', compact('requests'));
    }

    // Menyetujui request withdraw
    public function approve(Request $request, $id)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($id);

        if ($withdrawRequest->status !== 'Pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        // Update status menjadi Approved dan tambahkan bukti transfer
        $withdrawRequest->update([
            'status' => 'Approved',
            'proof' => $request->file('proof')->store('withdraw_proofs', 'public'),
        ]);

        return redirect()->route('admin.withdraws.index')->with('success', 'Withdraw approved.');
    }

    // Menolak request withdraw
    public function reject(Request $request, $id)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($id);

        if ($withdrawRequest->status !== 'Pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        // Kembalikan saldo ke user
        $withdrawRequest->user->increment('balance', $withdrawRequest->amount);

        // Update status menjadi Rejected dan tambahkan alasan
        $withdrawRequest->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        return redirect()->route('admin.withdraws.index')->with('success', 'Withdraw rejected.');
    }
}

