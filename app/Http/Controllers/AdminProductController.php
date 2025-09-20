<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminProductController extends Controller
{
    private function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_free_available' => 'boolean',
            'is_active' => 'boolean'
        ];
    }
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'sometimes|string|max:255',
            'status' => 'sometimes|boolean',
            'free' => 'sometimes|boolean'
        ]);

        $query = Product::query();

        if ($request->filled('search')) {
            $search = htmlspecialchars($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        if ($request->filled('free')) {
            $query->where('is_free_available', $request->boolean('free'));
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        return view('admin.product-form');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());

        try {
            $data = [
                'name' => htmlspecialchars($request->name),
                'short_description' => htmlspecialchars($request->short_description),
                'price' => $request->price,
                'description' => htmlspecialchars($request->description),
                'is_free_available' => $request->boolean('is_free_available'),
                'is_active' => $request->boolean('is_active')
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('products', 'public');
                }
                $data['images'] = $imagePaths;
            }

            Product::create($data);
            return redirect()->route('admin.products.index')
                ->with('success', 'เพิ่มสินค้าเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มสินค้า');
        }
    }

    public function edit(Product $product)
    {
        return view('admin.product-form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate($this->getValidationRules());

        try {
            $data = [
                'name' => htmlspecialchars($request->name),
                'short_description' => htmlspecialchars($request->short_description),
                'price' => $request->price,
                // 'description' => htmlspecialchars($request->description),
                'description' => $request->description,
                'is_free_available' => $request->boolean('is_free_available'),
                'is_active' => $request->boolean('is_active')
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            if ($request->hasFile('images')) {
                // Delete old images
                if ($product->images && is_array($product->images)) {
                    foreach ($product->images as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('products', 'public');
                }
                $data['images'] = $imagePaths;
            }

            $product->update($data);
            return redirect()->route('admin.products.index')
                ->with('success', 'แก้ไขสินค้าเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการแก้ไขสินค้า');
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Delete main image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Delete multiple images
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $product->delete();
            return redirect()->route('admin.products.index')
                ->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการลบสินค้า');
        }
    }
}
