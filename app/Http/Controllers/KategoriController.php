<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Role;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::withCount('layanans');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        $kategoris = $query->orderBy('nama')->get();
        return view('master.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $roles = Role::orderBy('label')->get();
        return view('master.kategori.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255|unique:kategoris,nama',
            'roles'   => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
            'warna'   => 'nullable|string|max:20',
        ]);

        Kategori::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'roles'     => $request->roles ?? [],
            'warna'     => $request->warna ?: '#005654',
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('master.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $roles    = Role::orderBy('label')->get();
        return view('master.kategori.edit', compact('kategori', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:255|unique:kategoris,nama,' . $id,
            'roles'   => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
            'warna'   => 'nullable|string|max:20',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'roles'     => $request->roles ?? [],
            'warna'     => $request->warna ?: '#005654',
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('master.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::withCount('layanans')->findOrFail($id);

        if ($kategori->layanans_count > 0) {
            return redirect()->route('master.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki layanan.');
        }

        $kategori->delete();
        return redirect()->route('master.kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
