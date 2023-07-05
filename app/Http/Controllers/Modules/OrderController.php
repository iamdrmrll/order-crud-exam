<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Order::latest()->get();
            return DataTables::of($data)
                ->addColumn('formatted_product_id', function($order) {
                    return $order->product->product_name;
                })
                ->addColumn('formatted_user_id', function($order) {
                    return $order->user->first_name . " " . $order->user->last_name;
                })
                ->addColumn('price', function($order) {
                    return $order->product->price;
                })
                ->addColumn('formatted_created_at', function($order) {
                    return date('F d, Y h:i:s a', strtotime($order->created_at));
                })
                ->toJson();
        }
        return view('modules.orders', [
            'products'       => Product::all()->where('status', '=', true),
            'users'          => User::all()->where('status', '=', true),
            'datatable_ajax' => route('orders.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated_data = $request->validate([
            'product_id' => 'required',
            'user_id'    => 'required'
        ]);

        $product = Product::findOrFail($validated_data['product_id']);

        if ($product->quantity < 1) {
            // Return an error response indicating insufficient quantity
            return response()->json([
                'status'  => false,
                'title'   => 'Error',
                'message' => 'Insufficient quantity for the product',
            ], 400);
        }

        $validated_data['price'] = $product->price;

        try {
            DB::beginTransaction();

            $order   = Order::create($validated_data);
            $status  = $order->save();
            $message = "Order Created " . ($status ? "Successfully" : "Failed") . "";

            if ($status) {
                $product->quantity -= 1;
                $product->save();

                DB::commit();

                return response()->json([
                    'status'  => true,
                    'title'   => 'Added',
                    'message' => $message,
                ]);
            }
        } catch (QueryException $e) {
            DB::rollBack();

            // Handle the exception and return an appropriate error response
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
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
    public function update(Request $request, Order $order)
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
        //
    }
}
