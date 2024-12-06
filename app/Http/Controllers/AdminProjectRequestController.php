<?php

namespace App\Http\Controllers;

use App\Models\ProjectRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminProjectRequestController extends Controller
{
    // Menampilkan daftar project request
    public function index()
    {
        $requests = ProjectRequest::with('installer', 'invoice')->where('status', 'pending')->get();
        return view('admin.project_requests.index', compact('requests'));
    }

    // Menerima permintaan
    public function approve(Request $request, ProjectRequest $projectRequest, $id)
    {   
        $projectRequest = ProjectRequest::findOrFail($id);
        //dd($projectRequest->invoice);
        $projectRequest->update(['status' => 'approved']);
        $projectRequest->invoice->update(['project_status' => 'wip']); // Ubah status project
        
        return redirect()->route('admin.project_requests.index')->with('success', 'Request approved successfully.');
    }

    // Menolak permintaan
    public function reject(Request $request, ProjectRequest $projectRequest, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);
        $projectRequest = ProjectRequest::findOrFail($id);
        // dd($projectRequest);
        $projectRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        return redirect()->route('admin.project_requests.index')->with('success', 'Request rejected with reason.');
    }

    public function progress()
    {
        $projects = Invoice::where('project_status', 'wip')
            ->whereHas('projectRequests', function ($query) {
                $query->where('installer_id', auth()->id())
                    ->where('status', 'approved');
            })->get();

        return view('project.progress.index', compact('projects'));
    }

    // Update progress dari installer
    public function updateProgress(Request $request, Invoice $invoice)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'log' => 'nullable|string',
        ]);

        if ($invoice->project_status !== 'wip') {
            return back()->with('error', 'This project is not editable.');
        }

        $invoice->update([
            'progress_percentage' => $request->progress_percentage,
            'log' => $request->log,
        ]);

        return redirect()->route('project.progress.index')->with('success', 'Project progress updated.');
    }

    // Menyelesaikan project
    public function completeProject(Invoice $invoice)
    {
        if ($invoice->project_status !== 'wip') {
            return back()->with('error', 'This project is not completable.');
        }

        $invoice->update(['project_status' => 'reviewing']);

        return redirect()->route('project.progress.index')->with('success', 'Project marked as complete.');
    }
}
