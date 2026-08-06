<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50|unique:roles,name|regex:/^[a-z0-9_]+$/',
            'label'       => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color'       => 'required|string|max:7',
            'redirect_to' => 'required|string|max:100',
            'allowed_groups' => 'nullable|array',
            'allowed_groups.*' => 'string',
        ], [
            'name.regex' => 'Nama role hanya boleh huruf kecil, angka, dan underscore.',
        ]);

        $data = $request->only('name', 'label', 'description', 'color', 'redirect_to');
        $data['allowed_groups'] = $request->input('allowed_groups', []);

        Role::create($data);

        return redirect()->route('master.user.index', ['tab' => 'role'])
            ->with('success', 'Role berhasil ditambahkan.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'label'       => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color'       => 'required|string|max:7',
            'redirect_to' => 'required|string|max:100',
            'allowed_groups' => 'nullable|array',
            'allowed_groups.*' => 'string',
        ]);

        $data = $request->only('label', 'description', 'color', 'redirect_to');
        $data['allowed_groups'] = $request->input('allowed_groups', []);

        $role->update($data);

        return redirect()->route('master.user.index', ['tab' => 'role'])
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('master.user.index', ['tab' => 'role'])
                ->with('error', "Role '{$role->label}' tidak dapat dihapus karena masih digunakan oleh {$role->users()->count()} akun.");
        }

        $role->delete();

        return redirect()->route('master.user.index', ['tab' => 'role'])
            ->with('success', 'Role berhasil dihapus.');
    }
}
