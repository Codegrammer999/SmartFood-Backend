<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $image = asset('storage/' . $imagePath);

        $menu->image = $image;
        $menu->save();

        return redirect()->back()->with('success', 'New menu addedd');
    }

    public function delete(Request $request)
    {
        $menuId = $request->menuId;

        if (!$menuId)
        {
            return redirect()->back()->with('error', 'Menu id is required');
        }

        $menu = Menu::where('id', $request->menuId);

        if (!$menu)
        {
            return redirect()->back()->with('error', 'Menu not found!');
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted');
    }
}
