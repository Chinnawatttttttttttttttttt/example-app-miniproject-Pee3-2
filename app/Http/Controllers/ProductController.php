<?php

namespace App\Http\Controllers;

use App\Models\product;

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Psy\CodeCleaner\ReturnTypePass;


class ProductController extends Controller
{

    public function AddProduct()
    {
        return view('product.addproduct');
    }

    public function AddProductPost(Request $request)
    {
        $product = new product();
        $product->name = $request->name;
        $product->price = $request->price;
        $products = $product->save();

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
        $name = $request->name;
        $price = $request->price;

        $product = Product::find($request->id);
        $product->name = $name;
        $product->price = $price;
        $answer = $product->save();

        if ($answer) {
            return back()->with('success', 'แก้ไขสำเร็จ');
        } else {
            return back()->with('fail', 'แก้ไขไม่สำเร็จ');
        }
    }

    public function Delete($id)
    {
        $product = product::find($id);

        if (!$product) {
            return redirect()->back()->with('fail', 'Product not found.');
        }
        $product->delete();

        return redirect()->back()->with('success', 'ลบสินค้าสำเร็จ');
    }
}
