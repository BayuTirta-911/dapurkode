<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\AffiliateRequest;


class AdminController extends Controller
{
    public function index()
    {
        // Jumlah service dengan status 'Pending'
        $pendingServicesCount = Service::where('status', 'Pending')->count();

        // Jumlah invoice dengan status 'Paid'
        $paidInvoicesCount = Invoice::where('status', 'Paid')->count();

        // Jumlah permintaan affiliator dengan status 'Pending'
        $pendingAffiliateRequestsCount = AffiliateRequest::where('status', 'Pending')->count();

        return view('admin.dashboard', compact('pendingServicesCount', 'paidInvoicesCount', 'pendingAffiliateRequestsCount'));
    }

    public function profileManager()
    {   
        $users = User::all(); // Mengambil semua data pengguna
        return view('admin.profile_manager', compact('users'));
    }

    public function deleteProfile(User $user)
    {
        // Pastikan admin tidak bisa menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.profile_manager')->with('error', 'You cannot delete your own profile.');
        }

        // Hapus pengguna
        $user->delete();

        return redirect()->route('admin.profile_manager')->with('success', 'User profile deleted successfully.');
    }

    public function changeStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:normal,verified,banned',
        ]);

        // Update status pengguna
        $user->status = $request->status;
        $user->save();

        return redirect()->route('admin.profile_manager')->with('success', 'User status updated successfully.');
    }

    public function manageServices()
    {
        $services = Service::with('user')->get(); // Ambil semua service dengan data user terkait
        return view('admin.services.index', compact('services'));
    }

    // Menampilkan form untuk mengubah status service
    public function editServiceStatus(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Memperbarui status service
    public function updateServiceStatus(Request $request, Service $service)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        // Update status dan catatan admin
        $service->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service status updated successfully.');
    }

    // Menampilkan halaman untuk mengubah fee
    public function editFees(Service $service)
    {
        return view('admin.services.edit_fees', compact('service'));
    }

    // Menyimpan perubahan fee
    public function updateFees(Request $request, Service $service)
    {
        $request->validate([
            'installer_fee' => 'required|numeric|min:0',
            'affiliator_fee' => 'required|numeric|min:0',
            'other_fee' => 'required|numeric|min:0',
        ]);

        $service->update([
            'installer_fee' => $request->installer_fee,
            'affiliator_fee' => $request->affiliator_fee,
            'other_fee' => $request->other_fee,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Fees updated successfully.');
    }

    public function createDiscount()
    {
        // Ambil semua service yang berstatus approved
        $services = Service::where('status', 'approved')->get();

        return view('admin.discounts.create', compact('services'));
    }

    // Menyimpan diskon baru
    public function storeDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code',
            'amount' => 'required|numeric|min:0',
            'service_ids' => 'required|array', // Pastikan array service_ids dikirim
            'service_ids.*' => 'exists:services,id', // Pastikan setiap ID valid
            
        ]);

        Discount::create([
            'code' => $request->code,
            'amount' => $request->amount,
            'service_ids' => json_encode($request->service_ids),
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully.');
    }

    // Menampilkan daftar diskon
    public function indexDiscounts()
    {
        $discounts = Discount::all();

        return view('admin.discounts.index', compact('discounts'));
    }

    public function destroyDiscount($id)
    {
        // Temukan diskon berdasarkan ID
        $discount = Discount::findOrFail($id);

        // Hapus diskon
        $discount->delete();

        // Redirect kembali ke daftar diskon dengan pesan sukses
        return redirect()->route('admin.discounts.index')->with('success', 'Discount deleted successfully.');
    }
}
