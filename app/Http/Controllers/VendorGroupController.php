<?php

namespace App\Http\Controllers;

use App\Models\ServiceGroup;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorGroupController extends Controller
{
    // Menampilkan daftar group
    public function index()
    {
        $groups = ServiceGroup::where('vendor_id', Auth::id())->with('services')->get();
        return view('vendor.group.index', compact('groups'));
    }

    // Menampilkan form pembuatan group
    public function create()
    {
        // Ambil hanya services milik vendor yang login
        $services = Service::where('user_id', Auth::id())->whereNull('group_id')->get();

        return view('vendor.group.create', compact('services'));
    }


    // Menyimpan group baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'services' => 'array', // Validasi bahwa ini adalah array
            'services.*' => 'integer', // Setiap item harus berupa integer
        ]);

        $group = ServiceGroup::create([
            'vendor_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Perbarui group_id pada services yang dipilih
        if ($request->services) {
            Service::whereIn('id', $request->services)
                ->where('user_id', Auth::id())
                ->update(['group_id' => $group->id]);
        }

        return redirect()->route('vendor.groups.index')->with('success', 'Group created successfully.');
    }


    // Menampilkan form edit group
    public function edit(ServiceGroup $group)
    {
        //$this->authorize('update', $group);

        // Ambil services milik vendor yang belum dimasukkan ke dalam grup lainnya
        $services = Service::where('user_id', Auth::id())
                        ->where(function ($query) use ($group) {
                            $query->whereNull('group_id')->orWhere('group_id', $group->id);
                        })
                        ->get();

        return view('vendor.group.edit', compact('group', 'services'));
    }

    // Memperbarui data group
    public function update(Request $request, ServiceGroup $group)
    {
        //$this->authorize('update', $group);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'services' => 'array', // Validasi bahwa ini adalah array
            'services.*' => 'integer', // Setiap item harus berupa integer
        ]);

        $group->update($request->only('name', 'description'));

        // Reset group_id untuk semua services lama di group ini
        Service::where('group_id', $group->id)->update(['group_id' => null]);

        // Perbarui group_id pada services yang dipilih
        if ($request->services) {
            Service::whereIn('id', $request->services)
                ->where('user_id', Auth::id())
                ->update(['group_id' => $group->id]);
        }

        return redirect()->route('vendor.groups.index')->with('success', 'Group updated successfully.');
    }



    // Menghapus group
    public function destroy(ServiceGroup $group)
    {
        //$this->authorize('delete', $group);

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
}

