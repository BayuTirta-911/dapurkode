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

    public function index()
    {
        // Ambil semua service yang statusnya approved
        $services = Service::where('status', 'approved')->get();

        return view('affiliate.service.index', compact('services'));
    }
}
