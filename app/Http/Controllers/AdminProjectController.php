<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminProjectController extends Controller
{
    // Menampilkan daftar proyek
    public function index()
    {
        // Ambil semua proyek dengan reviewing diurutkan paling atas
        $projects = Invoice::orderByRaw("FIELD(project_status, 'reviewing') DESC")
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.projects.index', compact('projects'));
    }

    // Menampilkan detail proyek
    public function show(Invoice $invoice)
    {
        return view('admin.projects.show', compact('invoice'));
    }

    // Menyelesaikan proyek (ubah status ke finished)
    public function finish(Invoice $invoice)
    {
        if ($invoice->project_status !== 'reviewing') {
            return redirect()->back()->with('error', 'Only projects with status "reviewing" can be finished.');
        }

        $invoice->update(['project_status' => 'finished']);

        return redirect()->route('admin.projects.index')->with('success', 'Project marked as finished.');
    }
}
