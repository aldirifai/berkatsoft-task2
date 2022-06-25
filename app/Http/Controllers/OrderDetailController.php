<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use RealRashid\SweetAlert\Facades\Alert;

class OrderDetailController extends Controller
{
    public function update(OrderDetailRequest $request, OrderDetail $orderDetail)
    {
        $product = explode('|', $request->product_id);

        $orderDetail->update([
            'product_id' => $product[0],
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $product[1],
        ]);

        $sum = OrderDetail::where('order_id', $orderDetail->order_id)->sum('total_price');
        Order::where('id', $orderDetail->order_id)->update(['total_price' => $sum]);

        Alert::success('Sukses', 'Data Order Detail berhasil diubah');

        return to_route('order.index');
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();
        $sum = OrderDetail::where('order_id', $orderDetail->order_id)->sum('total_price');
        Order::where('id', $orderDetail->order_id)->update(['total_price' => $sum]);

        Alert::success('Sukses', 'Data Order Detail berhasil dihapus');

        return to_route('order.index');
    }
}
