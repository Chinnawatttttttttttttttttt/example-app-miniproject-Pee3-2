<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Count;
use App\Models\product;

class DashboardController extends Controller
{
    



    public function ShowProduct()
    {
        $products = product::all();
        return view('home', compact('products'));
    }
    public function ShowProducte()
    {
        $products = product::all();
        return view('homee', compact('products'));
    }
    public function submitData(Request $request)
    {
        if ($request->isJson()) {
            $data = $request->json()->all();

            // Assuming Order and Count models exist and are set up correctly
            $order = new Order();
            $order->total = $data['overallTotal'];
            $order->save();

            foreach ($data['items'] as $item) {
                $count = new Count();
                $count->name = $item['name'];
                $count->quantity = $item['quantity'];
                $count->save();
            }

            return response()->json(['success' => true, 'message' => 'Data submitted successfully.']);
        }
    }
}
