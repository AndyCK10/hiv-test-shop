<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)->first();
        
        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_logged_in', true);
            Session::put('admin_id', $admin->id);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'รหัสผ่านไม่ถูกต้อง');
    }

    public function dashboard(Request $request)
    {
        $totalOrders = Order::count();
        $freeOrders = Order::where('is_free', true)->count();
        $paidOrders = Order::where('is_free', false)->count();
        $totalRevenue = Order::sum('total_amount');
        
        $query = Order::with('product');
        
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhereHas('product', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->type !== null) {
            $query->where('is_free', $request->type);
        }
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->get();

        // return view('admin.dashboard', compact(
        //     'totalOrders', 'freeOrders', 'paidOrders', 'totalRevenue', 'orders'
        // ));
        return view('admin.index', compact(
            'totalOrders', 'freeOrders', 'paidOrders', 'totalRevenue', 'orders'
        ));
    }

    public function showOrder($id)
    {
        $order = Order::with(['product', 'questionnaire'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }

    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'confirmed']);
        return back()->with('success', 'Order confirmed successfully');
    }

    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Order completed successfully');
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function showProfile()
    {
        return view('admin.profile');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        if ($request->current_password !== 'admin123') {
            return back()->with('error', 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
        }

        // In real app, update admin password in database
        return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6'
        ]);

        Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'เพิ่มแอดมินเรียบร้อยแล้ว');
    }

    public function showForgotPassword()
    {
        return view('admin.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->with('error', 'ไม่พบอีเมลนี้ในระบบ');
        }

        $token = Str::random(60);
        $admin->update([
            'reset_token' => $token,
            'reset_token_expires' => now()->addHours(1)
        ]);

        // Send email (simplified)
        return back()->with('success', 'ส่งลิงก์รีเซ็ตรหัสผ่านไปยังอีเมลแล้ว');
    }

    public function showResetPassword($token)
    {
        $admin = Admin::where('reset_token', $token)
            ->where('reset_token_expires', '>', now())
            ->first();
            
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'ลิงก์ไม่ถูกต้องหรือหมดอายุ');
        }

        return view('admin.reset-password', ['token' => $token, 'email' => $admin->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $admin = Admin::where('email', $request->email)
            ->where('reset_token', $request->token)
            ->where('reset_token_expires', '>', now())
            ->first();

        if (!$admin) {
            return back()->with('error', 'ข้อมูลไม่ถูกต้อง');
        }

        $admin->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        return redirect()->route('admin.login')->with('success', 'รีเซ็ตรหัสผ่านเรียบร้อยแล้ว');
    }

    public function questionnaireReport(Request $request)
    {
        $query = \App\Models\Questionnaire::with('order.product');
        
        if ($request->search) {
            $query->whereHas('order', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $questionnaires = $query->orderBy('created_at', 'desc')->get();
            
        return view('admin.questionnaire-report', compact('questionnaires'));
    }
}
