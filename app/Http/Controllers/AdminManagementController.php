<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.admins', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:admins|max:255',
            'email' => 'required|email|unique:admins|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            Admin::create([
                'username' => htmlspecialchars($request->username),
                'email' => htmlspecialchars($request->email),
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('admin.admins.index')
                ->with('success', 'เพิ่มแอดมินเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มแอดมิน');
        }
    }

    public function edit(Admin $admin)
    {
        return view('admin.admin-form', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        try {
            $data = [
                'username' => htmlspecialchars($request->username),
                'email' => htmlspecialchars($request->email)
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $admin->update($data);

            return redirect()->route('admin.admins.index')
                ->with('success', 'แก้ไขแอดมินเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการแก้ไขแอดมิน');
        }
    }

    public function destroy(Admin $admin)
    {
        // Prevent deleting main admin
        if ($admin->id == 1) {
            return back()->with('error', 'ไม่สามารถลบแอดมินหลักได้');
        }

        // Prevent self-deletion
        $currentAdminId = Session::get('admin_id');
        if ($admin->id == $currentAdminId) {
            return back()->with('error', 'ไม่สามารถลบตัวเองได้');
        }

        try {
            $admin->delete();
            return redirect()->route('admin.admins.index')
                ->with('success', 'ลบแอดมินเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการลบแอดมิน');
        }
    }
}
