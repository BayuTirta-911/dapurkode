<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliateRequest;
use Illuminate\Support\Facades\Auth;

class AffiliateRequestController extends Controller
{
    // Menampilkan form pengajuan affiliate
    public function create()
    {
        return view('affiliate.request');
    }

    // Menyimpan permintaan affiliate
    public function store(Request $request)
    {
        $request->validate([
            'self_description' => 'required|string',
            'marketing_plan' => 'required|string',
        ]);

        AffiliateRequest::create([
            'user_id' => Auth::id(),
            'self_description' => $request->self_description,
            'marketing_plan' => $request->marketing_plan,
        ]);

        return redirect()->route('affiliate.request.create')->with('success', 'Your request has been submitted.');
    }

    // Menampilkan daftar permintaan affiliate untuk admin
    public function index()
    {
        $requests = AffiliateRequest::with('user')->get();
        return view('admin.affiliate.requests.index', compact('requests'));
    }

    // Menampilkan detail permintaan affiliate
    public function show($id)
    {
        $request = AffiliateRequest::with('user')->findOrFail($id);
        return view('admin.affiliate.requests.show', compact('request'));
    }

    // Memperbarui status dan catatan permintaan affiliate
    public function update(Request $request, $id)
    {
        $affiliateRequest = AffiliateRequest::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:Accepted,Pending,Rejected',
            'admin_note' => 'nullable|string',
            'affiliate_code' => 'nullable|string',
        ]);

        // Perbarui data permintaan
        $affiliateRequest->update($request->only('status', 'admin_note', 'affiliate_code'));

        // Jika status adalah 'Accepted', ubah level user menjadi 'affiliator'
        if ($request->status === 'Accepted') {
            $user = $affiliateRequest->user;
            $user->role = 'affiliator'; // Mengubah level user
            $user->save(); // Simpan perubahan
        }

        return redirect()->route('admin.affiliate.requests.index')->with('success', 'Affiliate request updated successfully.');
    }

}
