<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->get();
        return view('admin.admins', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins|max:255',
            'email' => 'required|email|unique:admins|max:255',
            'password' => 'required|min:6'
        ]);

        Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'เพิ่มแอดมินเรียบร้อยแล้ว');
    }

    public function edit(Admin $admin)
    {
        return view('admin.admin-form', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $rules = [
            'username' => 'required|max:255|unique:admins,username,' . $admin->id,
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $request->validate($rules);

        $data = [
            'username' => $request->username,
            'email' => $request->email
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'แก้ไขแอดมินเรียบร้อยแล้ว');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id == 1) {
            return back()->with('error', 'ไม่สามารถลบแอดมินหลักได้');
        }

        $admin->delete();
        return redirect()->route('admin.admins.index')
            ->with('success', 'ลบแอดมินเรียบร้อยแล้ว');
    }
}
