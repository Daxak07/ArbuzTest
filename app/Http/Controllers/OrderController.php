<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $order = new Order;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->delivery_day = $request->delivery_day;
        $order->delivery_period = $request->delivery_period;
        $order->status = $request->status;
        $order->save();

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Заказ не найден'], 404);
        }
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Заказ не найден'], 404);
        }

        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->delivery_day = $request->delivery_day;
        $order->delivery_period = $request->delivery_period;
        $order->status = $request->status;

        $order->save();

        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Заказ не найден'], 404);
        }
        $order->delete();

        return response()->json(['message' => 'Заказ успешно удален']);
    }

    public function addProduct($orderId, $productId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Заказ не найден'], 404);
        }
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Продукт не найден'], 404);
        }
        $orderProduct = new OrderProduct;
        $orderProduct->order_id = $orderId;
        $orderProduct->product_id = $productId;
        $orderProduct->save();

        return response()->json(['message' => 'Продукт успешно добавлен к заказу']);
    }
}
