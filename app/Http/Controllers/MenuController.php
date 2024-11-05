<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * function to create a menu
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,png,gif,jpeg|max:2048',
            'price' => 'required',
            'priceOff' => 'nullable'
        ]);

        $image = '';

        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $image,
            'price' => $request->price,
            'priceOff' => $request->priceOff
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $imagePath = $request->image->storeAs('menus', $imageName, 'public');
        $menu->image = $imagePath;
        $menu->save();

        return redirect()->back()->with('success', 'New menu addedd');
    }

    /**
     * function to delete a menu
     */
    public function delete(Request $request)
    {
        $menu = Menu::find($request->menuId);

        if (!$menu)
        {
            return redirect()->back()->with('error', 'Menu not found!');
        }

        if ($menu->image && Storage::exists('public/' . $menu->image)) {
            Storage::delete('public/' . $menu->image);
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted');
    }

    /**
     * function to send menus to frontend
     */
    public function sendMenus(Request $request)
    {
        $menus = Menu::paginate(30);

        return response()->json($menus);
    }

    /**
     * function to fetch specific menu by id
     */
    public function getSpecificMenu($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'error' => 'Menu not found!'
            ], 404);
        }

        return response()->json($menu, 200);
    }
}
