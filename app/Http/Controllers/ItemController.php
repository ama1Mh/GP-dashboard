<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
      // Show the list of items in a table + chart
      public function index()
      {
        $items = Item::all(); // Get all items from the database

        // Prepare data for the chart
        $labels = $items->pluck('title'); // Get item titles
        $values = $items->pluck('quantity'); // Get item quantities
    
        // Calculate total number of items
        $totalItems = $items->sum('quantity'); 
        
        // Get distinct categories (you can adjust this part if your database schema supports categories)
        $categories = $items->groupBy('category'); // Assuming 'category' is a column in your Item model
        $categoryCounts = $categories->map(function ($categoryItems) {
            return $categoryItems->count();
        });
  
        return view('admin.item.index', compact('items', 'labels', 'values', 'totalItems', 'categoryCounts'));
    }
  
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:item,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
        ]);
    
        $item = Item::findOrFail($request->id);
        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
        ]);
    
        return redirect()->back()->with('success', 'Item updated successfully!');
    }
    
}
