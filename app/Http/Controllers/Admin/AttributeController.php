<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::orderBy('type')
                               ->orderBy('sort_order')
                               ->get();
        
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $types = [
            'outfit_type'     => 'Outfit Type',
            'color_type'      => 'Color Type',
          
        ];

        return view('admin.attributes.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|string',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'integer|min:0',
            'is_active'   => 'boolean',
        ]);

        Attribute::create($request->all());

        return redirect()->route('admin.attributes.index')
                         ->with('success', 'Attribute created successfully!');
    }

    public function edit(Attribute $attribute)
    {
        $types = [
            'outfit_type'     => 'Outfit Type',
           
            'color_type'      => 'Color Type',
          
        ];

        return view('admin.attributes.edit', compact('attribute', 'types'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
        ]);

        $attribute->update($request->all());

        return redirect()->route('admin.attributes.index')
                         ->with('success', 'Attribute updated successfully!');
    }

  public function destroy(Attribute $attribute)
{
    // 🔥 First, safely remove references from all products
    \App\Models\Product::where('outfit_type_id', $attribute->id)
        ->update(['outfit_type_id' => null]);

   

    \App\Models\Product::where('best_worn_in_id', $attribute->id)
        ->update(['best_worn_in_id' => null]);

  
    // Now safely delete the attribute
    $attribute->delete();

    return redirect()
        ->route('admin.attributes.index')
        ->with('success', 'Attribute deleted successfully! (References removed from products)');
}
        /**
     * Display the specified attribute (we excluded show route, but blade still links to it)
     */
    public function show($id)
    {
        return redirect()
            ->route('admin.attributes.index')
            ->with('info', 'Attribute detail view is not available.');
    }
}