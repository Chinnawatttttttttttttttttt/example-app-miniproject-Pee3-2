<?php

namespace App\Http\Controllers;

use App\Models\product;

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Facades\Storage; // นำเข้า Storage ที่ถูกต้อง


class ProductController extends Controller
{

    public function AddProduct()
    {
        return view('product.addproduct');
    }

    public function AddProductPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product(); // เปลี่ยนเป็นตัวพิมพ์ใหญ่
        $product->name = $request->name;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            // กำหนดพาธสำหรับจัดเก็บไฟล์
            $imagePath = 'images/' . time() . '_' . $request->file('image')->getClientOriginalName(); // ตั้งชื่อไฟล์ใหม่เพื่อหลีกเลี่ยงการชนกัน
            $request->file('image')->move(public_path('images'), $imagePath); // ย้ายไฟล์ไปที่ public/images
            $product->image = $imagePath; // บันทึกพาธในฐานข้อมูล
        }

        $product->save();

        session()->flash('success', 'ข้อมูลถูกบันทึกแล้ว');
        session()->flash('refreshTime', 1500);

        return redirect()->back();
    }


    public function ShowProduct()
    {
        $products = product::all();
        return view('product.product', compact('products'));
    }

    public function EditProduct($id)
    {
        $product = product::find($id);
        return view('product.editproduct', compact('product'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            // ลบรูปเก่า (ถ้ามี) ก่อนที่จะอัปเดตรูปใหม่
            if ($product->image) {
                // ลบไฟล์รูปภาพจาก public/images
                unlink(public_path($product->image));
            }
            // เก็บไฟล์รูปภาพใหม่ใน public/images
            $imagePath = 'images/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $imagePath);
            $product->image = $imagePath;
        }

        $answer = $product->save();

        if ($answer) {
            return back()->with('success', 'แก้ไขสำเร็จ');
        } else {
            return back()->with('fail', 'แก้ไขไม่สำเร็จ');
        }
    }

    public function Delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('fail', 'Product not found.');
        }

        // ตรวจสอบว่ามีรูปภาพหรือไม่ และทำการลบรูปภาพจากโฟลเดอร์ public/images
        if ($product->image) {
            // ลบไฟล์รูปภาพจาก public/images
            unlink(public_path($product->image));
        }

        // ลบข้อมูลสินค้าจากฐานข้อมูล
        $product->delete();

        return redirect()->back()->with('success', 'ลบสินค้าสำเร็จ');
    }
}
