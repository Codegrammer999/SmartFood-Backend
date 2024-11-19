<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showRegister(Request $request)
    {
        return view('admin.register');
    }

    public function showLogin(Request $request)
    {
        return view('admin.login');
    }

    public function showDashboard(Request $request)
    {
        $data = [
            'total_users' => User::count(),
            'pending_users' => User::where('registration_status', 'pending')->count(),
            'total_orders' => Order::count(),
            'total_menus' => Menu::count(),
            'total_revenue' => Order::sum('total_price'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function showPendingOrders(Request $request)
    {
        $pendingOrders = Order::where('status', 'pending')->paginate(10);
        return view('admin.orders', compact('pendingOrders'));
    }

    public function showMenus(Request $request)
    {
        $menus = Menu::paginate(10);
        return view('admin.menus', compact('menus'));
    }

    public function showPendingUsers(Request $request)
    {
        $users = User::where('registration_status', 'pending')->paginate(10);
        return view('admin.pending-users', compact('users'));
    }

    public function register(Request $request)
    {
       $data = $request->validate([
        'username' => 'required|string|min:5|max:30',
        'email' => 'required|email|max:255|unique:admins',
        'password' => 'required|string|min:6|max:30|confirmed',
        'access_code' => 'required|string'
       ]);

       if ($data['access_code'] !== env('AWS_PRO_KEY'))
       {
        return redirect()->back()->withErrors(['access_code_error' => 'Invalid access code']);
       }

       $admin = Admin::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
       ]);



       return redirect('/admin/login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|min:5|max:30',
            'password' => 'required|string|min:6|max:30'
        ]);

        if(!Auth::guard('admin')->attempt(['username' => $data['username'], 'password' => $data['password']]))
        {
            return redirect()->back()->withErrors(['invalid' => 'Incorrect username or password']);
        }

        return redirect()->intended('/admin/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }

    public function confirmOrder(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order || $order->status !== 'pending') {
            return redirect()->back()->with(['error', 'Order not found or order is not pending']);
        }

        if ($order->payment_receipt && Storage::exists('public/' . $order->payment_receipt)) {
            Storage::delete('public/' . $order->payment_receipt);
        }

        $order->status = 'Confirmed';
        $order->save();
        return redirect()->back()->with(['success', 'Order confirmed']);
    }

    public function confirmUserRegistration($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['confirmation_error' => 'User not found']);
        }

        $referrer = User::findorfail($user->referrer->id);
        $referrer->bonusWallet->balance += 5000;
        $referrer->bonusWallet->save();

        $user->bonusWallet()->create([
            'balance' => 5000
        ]);

        $user->registration_status = 'confirmed';
        $user->save();

        return redirect()->back()->with('success', 'User confirmed successfully');
    }
}
