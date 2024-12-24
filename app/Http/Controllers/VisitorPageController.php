<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class VisitorPageController extends Controller
{
    // Halaman Home
    public function home()
    {
        // Ambil service yang di-highlight
        $highlightedServices = Service::where('highlight', true)->get();
        $approvedServices = Service::where('status', 'approved')
        ->orderBy('created_at', 'desc')
        ->take(4) // Ambil hanya 4 service
        ->get();

        return view('visitor.home', compact('highlightedServices','approvedServices'));
    }

    // Halaman Services
    public function services(Request $request)
    {
        $query = Service::where('status', 'approved');

        // Pencarian berdasarkan nama service
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil data dengan pagination
        $services = $query->orderBy('created_at', 'desc')->paginate(8);

        return view('visitor.services', compact('services'));
    }


    // Halaman About
    public function about()
    {
        return view('visitor.about');
    }
}