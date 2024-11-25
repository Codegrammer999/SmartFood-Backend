<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Menu;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showRegister(Request $request)
    {
        return view('admin.register');
    }

    public function showOrderOwner($id)
    {
        $user = User::findorfail($id);
        return view('admin.user', compact('user'));
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
        $pendingOrders = Order::where('status', 'pending')->latest()->paginate(10);
        return view('admin.orders', compact('pendingOrders'));
    }

    public function showMenus(Request $request)
    {
        $menus = Menu::paginate(10);

        return view('admin.menus', compact('menus'));
    }

    public function showPendingUsers(Request $request)
    {
        $users = User::where('registration_status', 'pending')->latest()->paginate(10);
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

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }

    public function confirmOrder($id)
    {
        $order = Order::find($id);

        if (!$order || $order->status !== 'pending')
        {
            return redirect()->back()->withErrors(['error' => 'Order not found or order has already been confirmed']);
        }

        if ($order->payment_receipt)
        {
            $img = str_replace(url('storage'). '/', '', $order->payment_receipt);

            if (Storage::disk('public')->exists($img))
            {
                Storage::disk('public')->delete($img);
            }
        }

        $order->status = 'Confirmed';
        $order->payment_receipt = null;
        $order->save();
        return redirect()->back()->with('success', 'Order confirmed successfully');
    }

    public function confirmUserRegistration($id)
    {
        $user = User::find($id);

        if (!$user)
        {
            return redirect()->back()->withErrors(['error' => 'User not found']);
        }

        if ($user->payment_receipt)
        {
            $img = str_replace(url('storage'). '/', '', $user->payment_receipt);

            if (Storage::disk('public')->exists($img))
            {
                Storage::disk('public')->delete($img);
                $user->payment_receipt = 'paid';
            }
        }

        if ($user->referrer)
        {
            $referrer = User::findorfail($user->referrer->referrer_id);

            if ($referrer->registration_status !== 'confirmed')
            {
                return redirect()->back()->withErrors(['error' => 'Please confirm this user referrer first']);
            }

            $referrer->bonusWallet->balance += 5000;
            $referrer->bonusWallet->save();
        }

        $user->bonusWallet()->create([
            'balance' => 5000
        ]);

        $user->registration_status = 'confirmed';
        $user->save();

        return redirect()->back()->with('success', 'User confirmed successfully');
    }

    public function rejectUserRegistration($id)
    {
        $user = User::find($id);

        if (!$user)
        {
            return redirect()->back()->withErrors(['error' => 'User not found']);
        }

        $user->tokens()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User registration rejected');
    }

    public function showCodes(Request $request)
    {
        $codes = Code::where('status', 'pending')->latest()->paginate(10);

        return view('admin.pending-codes', compact('codes'));
    }

    public function activateCode($id)
    {
        $code = Code::find($id);

        if (!$code)
        {
            return redirect()->back()->withErrors(['error' => 'Code not found']);
        }

        $code->status = 'Activated';
        $code->save();

        return redirect()->back()->with(['success', 'Code activated successfully']);
    }
}
