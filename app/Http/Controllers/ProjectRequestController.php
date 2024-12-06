<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;

class ProjectRequestController extends Controller
{
    // Menampilkan daftar project requests
    public function index()
    {
        $requests = ProjectRequest::where('installer_id', auth()->id())->get();
        return view('project.requests.index', compact('requests'));
    }

    public function create()
    {
        // Ambil semua invoice dengan status finished dan project_status waiting installer
        $invoices = Invoice::where('status', 'finished')
            ->where('project_status', 'waiting installer')
            ->get();

        return view('project.requests.create', compact('invoices'));
    }

    // Membuat permintaan project
    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'reason' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        if ($invoice->project_status !== 'waiting installer') {
            return back()->with('error', 'This service is not available for project requests.');
        }

        ProjectRequest::create([
            'installer_id' => auth()->id(),
            'invoice_id' => $invoice->id,
            'reason' => $request->reason,
        ]);

        $invoice->update(['project_status' => 'waiting installer']);

        return redirect()->route('project.requests.index')->with('success', 'Project request submitted.');
    }

    // Menampilkan daftar project yang sedang berjalan
    public function progress()
    {
        // Ambil daftar proyek yang statusnya 'wip' (work in progress) untuk installer yang sedang login
        $projectsInProgress = Invoice::where('project_status', 'wip')
            ->whereHas('projectRequests', function ($query) {
                $query->where('installer_id', auth()->id())
                      ->where('status', 'approved');
            })->get();

        $projectsFinished  = Invoice::where('project_status', 'finished')
            ->whereHas('projectRequests', function ($query) {
                $query->where('installer_id', auth()->id())
                      ->where('status', 'approved');
            })->get();

        return view('project.progress.index', compact('projectsInProgress','projectsFinished'));
    }

    // Menampilkan halaman individual progress proyek
    public function showProgress(Invoice $invoice)
    {
        // Pastikan user yang login adalah installer yang terkait dengan invoice tersebut
        if ($invoice->projectRequests()->where('installer_id', auth()->id())->exists()) {
            return view('project.progress.show', compact('invoice'));
        }

        return redirect()->route('project.progress.index')->with('error', 'You are not authorized to view this project.');
    }

    // Mengupdate progress proyek
    public function updateProgress(Request $request, Invoice $invoice)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'log' => 'nullable|string',
        ]);

        if ($invoice->project_status !== 'wip') {
            return back()->with('error', 'This project cannot be updated.');
        }
        //dd($invoice);
        $invoice->update([
            'progress_percentage' => $request->progress_percentage,
            'log' => $request->log,
        ]);

        return redirect()->route('project.progress.show', $invoice->id)->with('success', 'Project progress updated.');
    }

    // Menyelesaikan proyek
    public function completeProject(Invoice $invoice)
    {
        if ($invoice->project_status !== 'wip') {
            return back()->with('error', 'This project cannot be completed.');
        }

        $invoice->update(['project_status' => 'reviewing']);

        return redirect()->route('project.progress.index')->with('success', 'Project marked as complete.');
    }
}

