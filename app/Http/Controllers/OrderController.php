<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->with('order_details')->with('order_details.product')->get();

        $customers = Customer::all();
        $products = Product::all();

        return view('order', compact('orders', 'customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order = Order::create($request->all() + ['invoice_number' => $this->invoiceNumber()]);

        if ($request->product_id) {
            foreach ($request->product_id as $key => $value) {
                $produk = explode('|', $value);
                $order->order_details()->create([
                    'product_id' => $produk[0],
                    'quantity' => $request->banyaknya[$key],
                    'total_price' => $produk[1] * $request->banyaknya[$key],
                ]);
            }
        }

        Alert::success('Sukses', 'Data Order berhasil ditambahkan');

        return to_route('order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->order_details()->delete();
        $order->delete();

        Alert::success('Sukses', 'Data Order berhasil dihapus');

        return to_route('order.index');
    }

    private function invoiceNumber()
    {
        $latest = Order::latest()->first();

        if (!$latest) {
            return 'INV0001';
        }

        $string = preg_replace("/[^0-9\.]/", '', $latest->invoice_number);

        return 'INV' . sprintf('%04d', $string + 1);
    }
}
