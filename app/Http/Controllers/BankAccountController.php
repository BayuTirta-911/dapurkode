<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    // Menampilkan daftar rekening bank
    public function index()
    {
        $accounts = BankAccount::all();
        return view('bank_accounts.index', compact('accounts'));
    }

    // Form tambah rekening bank
    public function create()
    {
        return view('bank_accounts.create');
    }

    // Simpan rekening bank baru
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20|unique:bank_accounts',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bank_images', 'public');
        }

        BankAccount::create($data);

        return redirect()->route('bank_accounts.index')->with('success', 'Bank account added successfully.');
    }

    // Form edit rekening bank
    public function edit(BankAccount $bankAccount)
    {
        return view('bank_accounts.edit', compact('bankAccount'));
    }

    // Update rekening bank
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => "required|string|max:20|unique:bank_accounts,account_number,{$bankAccount->id}",
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($bankAccount->image) {
                Storage::disk('public')->delete($bankAccount->image);
            }

            // Upload gambar baru
            $data['image'] = $request->file('image')->store('bank_images', 'public');
        }

        $bankAccount->update($data);

        return redirect()->route('bank_accounts.index')->with('success', 'Bank account updated successfully.');
    }

    // Hapus rekening bank
    public function destroy(BankAccount $bankAccount)
    {
        if ($bankAccount->image) {
            Storage::disk('public')->delete($bankAccount->image);
        }

        $bankAccount->delete();

        return redirect()->route('bank_accounts.index')->with('success', 'Bank account deleted successfully.');
    }
}
