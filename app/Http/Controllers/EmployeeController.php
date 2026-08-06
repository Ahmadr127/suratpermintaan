<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nip'              => 'required|string|max:50|unique:employees,nip',
            'nama_karyawan'    => 'required|string|max:255',
            'unit'             => 'required|string|max:255',
            'posisi_pekerjaan' => 'required|string|max:255',
            'profesi'          => 'required|string|max:255',
            'jabatan'          => 'required|string|max:255',
        ]);

        Employee::create($request->only(['nip','nama_karyawan','unit','posisi_pekerjaan','profesi','jabatan']));

        return redirect()->route('master.user.index', ['tab' => 'karyawan'])
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'nip'              => 'required|string|max:50|unique:employees,nip,' . $id,
            'nama_karyawan'    => 'required|string|max:255',
            'unit'             => 'required|string|max:255',
            'posisi_pekerjaan' => 'required|string|max:255',
            'profesi'          => 'required|string|max:255',
            'jabatan'          => 'required|string|max:255',
        ]);

        $employee->update($request->only(['nip','nama_karyawan','unit','posisi_pekerjaan','profesi','jabatan']));

        return redirect()->route('master.user.index', ['tab' => 'karyawan'])
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();

        return redirect()->route('master.user.index', ['tab' => 'karyawan'])
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
