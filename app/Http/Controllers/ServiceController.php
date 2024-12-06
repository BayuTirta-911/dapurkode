<?php
namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\ServiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        // Hanya vendor yang bisa mengakses, selain itu diarahkan ke halaman lain
        $this->middleware('auth');
    }

    // Menampilkan daftar service milik vendor yang sedang login
    public function index()
    {
        $services = Service::where('user_id', Auth::id())->get(); // Menampilkan hanya service milik vendor
        return view('vendor.services.index', compact('services'));
    }

    // Menampilkan form untuk menambah service
    public function create()
    {
        return view('vendor.services.create');
    }

    // Menyimpan data service baru
    public function store(Request $request)
    {
        if ($request->hasFile('image') && $request->file('image')->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'The uploaded file is too large. Maximum size is 2 MB.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_1' => 'required|numeric',
            'price_2' => 'nullable|numeric',
            'price_3' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('service_images', 'public');
        }

        // Menyimpan data service
        Service::create([
            'user_id' => Auth::id(), // Mengaitkan dengan user/vendor yang login
            'name' => $request->name,
            'description' => $request->description,
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'status' => 'pending', // Status default adalah 'pending'
            'image' => $imagePath,
        ]);

        return redirect()->route('vendor.services.index')->with('success', 'Service created successfully.');
    }

    // Menampilkan form untuk mengedit service
    public function edit(Service $service)
    {
        // Pastikan hanya vendor yang dapat mengedit service mereka sendiri
        if ($service->user_id !== Auth::id()) {
            return redirect()->route('vendor.services.index')->with('error', 'Unauthorized action.');
        }

        return view('vendor.services.edit', compact('service'));
    }

    // Menyimpan perubahan pada service
    public function update(Request $request, Service $service)
    {
        // Pastikan hanya user pemilik service yang dapat mengakses
        if ($service->user_id !== Auth::id()) {
            return redirect()->route('vendor.services.index')->with('error', 'Unauthorized action.');
        }

        if ($request->hasFile('image') && $request->file('image')->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'The uploaded file is too large. Maximum size is 2 MB.');
        }

        // Validasi input selain gambar
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_1' => 'required|numeric',
            'price_2' => 'nullable|numeric',
            'price_3' => 'nullable|numeric',
        ]);

        // Periksa apakah ada file yang diunggah
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Periksa ukuran file (maksimal 2 MB)
            if ($file->getSize() > 2 * 1024 * 1024) { // 2 MB dalam byte
                return redirect()->back()->with('error', 'The uploaded file is too large. Maximum size is 2 MB.');
            }

            // Validasi format file
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
            ]);

            // Simpan gambar baru
            $imagePath = $file->store('service_images', 'public');
            $service->image = $imagePath;
        }

        // Perbarui data service
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'status' => 'pending',
        ]);

        return redirect()->route('vendor.services.index')->with('success', 'Service updated successfully.');
    }


    // Menghapus service
    public function destroy(Service $service)
    {
        if ($service->user_id !== Auth::id()) {
            return redirect()->route('vendor.services.index')->with('error', 'Unauthorized action.');
        }

        $service->delete();

        return redirect()->route('vendor.services.index')->with('success', 'Service deleted successfully.');
    }
}
