<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string'
        ]);

        // Rate limiting
        $key = 'login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with('error', 'มีการพยายามเข้าสู่ระบบมากเกินไป กรุณารอ ' . RateLimiter::availableIn($key) . ' วินาที');
        }

        $admin = Admin::where('username', htmlspecialchars($request->username))->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            Session::put('admin_logged_in', true);
            Session::put('admin_id', $admin->id);
            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($key, 300); // 5 minutes
        return back()->with('error', 'รหัสผ่านไม่ถูกต้อง');
    }

    public function dashboard(Request $request)
    {
        $request->validate([
            'search' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'type' => 'sometimes|boolean',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date|after_or_equal:date_from'
        ]);

        $totalOrders = Order::count();
        $freeOrders = Order::where('is_free', true)->count();
        $paidOrders = Order::where('is_free', false)->count();
        $totalRevenue = Order::sum('total_amount');

        $query = Order::with(['product', 'orderItems.product']);

        if ($request->filled('search')) {
            $search = htmlspecialchars($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('order_no', 'like', '%' . $search . '%')
                  ->orWhereHas('product', function($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('is_free', $request->boolean('type'));
        }

        if ($request->filled('date_from')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to ?? $request->date_from)->endOfDay()
            ]);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.index', compact(
            'totalOrders', 'freeOrders', 'paidOrders', 'totalRevenue', 'orders'
        ));
    }

    public function showOrder($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            abort(404);
        }
        
        $order = Order::with(['product', 'questionnaire', 'orderItems.product'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }

    public function confirmOrder($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            abort(404);
        }
        
        $order = Order::findOrFail($id);
        
        // Validate status transition
        if (!in_array($order->status, ['pending'])) {
            return back()->with('error', 'ไม่สามารถยืนยันคำสั่งซื้อนี้ได้');
        }
        
        $order->update(['status' => 'confirmed']);
        return back()->with('success', 'ยืนยันคำสั่งซื้อเรียบร้อยแล้ว');
    }

    public function completeOrder($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            abort(404);
        }
        
        $order = Order::findOrFail($id);
        
        // Validate status transition
        if (!in_array($order->status, ['confirmed'])) {
            return back()->with('error', 'ไม่สามารถทำให้คำสั่งซื้อนี้เสร็จสิ้นได้');
        }
        
        $order->update(['status' => 'completed']);
        return back()->with('success', 'ทำคำสั่งซื้อเสร็จสิ้นแล้ว');
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function showProfile()
    {
        $adminId = Session::get('admin_id');
        $admin = Admin::findOrFail($adminId);
        return view('admin.profile', compact('admin'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        $adminId = Session::get('admin_id');
        $admin = Admin::findOrFail($adminId);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
        }

        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:8'
        ]);

        try {
            Admin::create([
                'username' => htmlspecialchars($request->username),
                'email' => htmlspecialchars($request->email),
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'เพิ่มแอดมินเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มแอดมิน');
        }
    }

    public function showForgotPassword()
    {
        return view('admin.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255']);

        $admin = Admin::where('email', htmlspecialchars($request->email))->first();
        if (!$admin) {
            return back()->with('error', 'ไม่พบอีเมลนี้ในระบบ');
        }

        $token = Str::random(60);
        $admin->update([
            'reset_token' => $token,
            'reset_token_expires' => Carbon::now()->addHours(1)
        ]);

        // TODO: Send actual email
        return back()->with('success', 'ส่งลิงก์รีเซ็ตรหัสผ่านไปยังอีเมลแล้ว');
    }

    public function showResetPassword($token)
    {
        if (!is_string($token) || strlen($token) !== 60) {
            return redirect()->route('admin.login')->with('error', 'ลิงก์ไม่ถูกต้อง');
        }
        
        $admin = Admin::where('reset_token', $token)
            ->where('reset_token_expires', '>', Carbon::now())
            ->first();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'ลิงก์ไม่ถูกต้องหรือหมดอายุ');
        }

        return view('admin.reset-password', ['token' => $token, 'email' => $admin->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:60',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $admin = Admin::where('email', htmlspecialchars($request->email))
            ->where('reset_token', $request->token)
            ->where('reset_token_expires', '>', Carbon::now())
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
        $request->validate([
            'search' => 'sometimes|string|max:255',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date|after_or_equal:date_from'
        ]);
        
        $query = \App\Models\Questionnaire::with('order.product');

        if ($request->filled('search')) {
            $search = htmlspecialchars($request->search);
            $query->whereHas('order', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to ?? $request->date_from)->endOfDay()
            ]);
        }

        $questionnaires = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.questionnaire-report', compact('questionnaires'));
    }
}
