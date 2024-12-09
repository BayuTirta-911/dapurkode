<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\AffiliateRequest;
use Illuminate\Http\Request;

class AffiliateServiceController extends Controller
{
    public function show($id)
    {
        // Ambil data service yang statusnya approved dan dengan ID tertentu
        $service = Service::where('id', $id)->where('status', 'approved')->first();

        // Cek jika service ditemukan
        if (!$service) {
            return redirect()->route('home')->with('error', 'Service not found or not approved.');
        }

        // Ambil affiliate_code dari affiliate_request yang terkait dengan user yang sedang login
        $affiliateRequest = AffiliateRequest::where('user_id', auth()->id())->first();

        // Cek jika kode affiliate ditemukan
        if (!$affiliateRequest) {
            return redirect()->route('home')->with('error', 'You do not have an affiliate code.');
        }

        // Ambil kode affiliate
        $affiliateCode = $affiliateRequest->affiliate_code;

        // Generate link affiliate dengan kode
        $affiliateLink = url("/invoice/{$service->id}?aff={$affiliateCode}");

        return view('affiliate.service.show', compact('service', 'affiliateLink'));
    }

    public function index(Request $request)
    {
        // Ambil kata kunci dari input pencarian
        $search = $request->input('search');

        // Query untuk mengambil semua service dengan status approved
        // Jika ada kata kunci, filter berdasarkan nama service
        $services = Service::where('status', 'approved')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(6); // Tampilkan 9 item per halaman

        // Return ke view dengan data services dan kata kunci pencarian
        return view('affiliate.service.index', compact('services', 'search'));
    }

}
