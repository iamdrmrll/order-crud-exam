<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        /**
         * ----------------------------------------------------
         * For DataTable Server Side
         * ----------------------------------------------------
         */
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addColumn('formatted_quantity', function($product) {
                    return $product->quantity ?: "<span class=\"text-danger\">$product->quantity</span>";
                })
                ->addColumn('formatted_status', function($product) {
                    return $product->status ? '<span class="badge bg-success">Enabled</span>' : '<span class="badge bg-danger">Disabled</span>';
                })
                ->addColumn('formatted_created_at', function($product) {
                    return date('F d, Y h:i:s a', strtotime($product->created_at));
                })
                ->addColumn('formatted_updated_at', function($product) {
                    return date('F d, Y h:i:s a', strtotime($product->updated_at));
                })
                ->addColumn('action', function($product) {
                    // add custom actions or buttons here
                    return '<div class="hstack gap-1">
                        <button id="modal_btn" class="align-self-start btn btn-sm btn-outline-dark" data-id="' . encrypt($product->id) . '">
                            <i class="bi bi-pen-fill"></i>
                            Edit
                        </button>
                    </div>';
                })
                ->rawColumns(['formatted_quantity', 'formatted_status', 'action'])
                ->toJson();
        }
        return view('masterfiles.products', [
            'datatable_ajax' => route('products.index')
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
            'product_name'        => 'required',
            'product_description' => 'required',
            'quantity'            => 'required|min:0',
            'price'               => 'required|min:1',
            'status'              => 'nullable'
        ]);

        $validated_data['status'] = array_key_exists('status', $validated_data) ? true : false;

        // Create a new instance of the data
        $product = Product::create($validated_data);

        $status     = $product->save();
        $message    = "Product Created " . ($status ? "Successfully" : "Failed") . "";

        return response()->json([
            'status'  => $status ? true : false,
            'title'   => 'Added',
            'message' => $message
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id      = decrypt($id); // decrypt the id

        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated_data = $request->validate([
            'product_name'        => 'required',
            'product_description' => 'required',
            'quantity'            => 'required|min:0',
            'price'               => 'required|min:1',
            'status'              => 'nullable'
        ]);

        $validated_data['status'] = array_key_exists('status', $validated_data) ? true : false;

        $id = decrypt($id);

        $product = Product::findOrFail($id);
        $status  = $product->update($validated_data);
        $message = "Product Updated " . ($status ? "Successfully" : "Failed") . "";

        return response()->json([
            'status'  => $status ? true : false,
            'title'   => 'Updated',
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * For Product Select Options | Data-list
     *
     * @return \Illuminate\Http\Response
     */
    public function dataList()
    {
        //
        $products = Product::all()->where('status', '=', true)->toArray();

        $products = array_map(function($product) {
            $product['data_list_name'] = $product['product_name'];
            return $product;
        }, $products);

        return response()->json($products);
    }
}
