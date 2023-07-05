<?php

namespace App\Http\Controllers\Masterfiles;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
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
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addColumn('formatted_status', function($user) {
                    return $user->status ? '<span class="badge bg-success">Enabled</span>' : '<span class="badge bg-danger">Disabled</span>';
                })
                ->addColumn('formatted_created_at', function($user) {
                    return date('F d, Y h:i:s a', strtotime($user->created_at));
                })
                ->addColumn('formatted_updated_at', function($user) {
                    return date('F d, Y h:i:s a', strtotime($user->updated_at));
                })
                ->addColumn('action', function($user) {
                    // add custom actions or buttons here
                    return '<div class="hstack gap-1">
                        <button id="modal_btn" class="align-self-start btn btn-sm btn-outline-dark" data-id="' . encrypt($user->id) . '">
                            <i class="bi bi-pen-fill"></i>
                            Edit
                        </button>
                    </div>';
                })
                ->rawColumns(['formatted_status', 'action'])
                ->toJson();
        }
        return view('masterfiles.users', [
            'datatable_ajax' => route('users.index')
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
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email_address'  => 'required',
            'mobile_number'  => 'required',
            'address'        => 'required',
            'status'         => 'nullable'
        ]);

        $validated_data['status'] = array_key_exists('status', $validated_data) ? true : false;

        // Create a new instance of the data
        $user = User::create($validated_data);

        $status     = $user->save();
        $message    = "User Created " . ($status ? "Successfully" : "Failed") . "";

        return response()->json([
            'status'  => $status ? true : false,
            'title'   => 'Added',
            'message' => $message
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id   = decrypt($id); // decrypt the id

        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated_data = $request->validate([
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email_address'  => 'required',
            'mobile_number'  => 'required',
            'address'        => 'required',
            'status'         => 'nullable'
        ]);

        $validated_data['status'] = array_key_exists('status', $validated_data) ? true : false;

        $id = decrypt($id);

        $user    = User::findOrFail($id);
        $status  = $user->update($validated_data);
        $message = "User Updated " . ($status ? "Successfully" : "Failed") . "";

        return response()->json([
            'status'  => $status ? true : false,
            'title'   => 'Updated',
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * For User Select Options | Data-list
     *
     * @return \Illuminate\Http\Response
     */
    public function dataList() {
        //
        $users = User::all()->where('status', '=', true)->toArray();

        $users = array_map(function($user) {
            $user['data_list_name'] = $user['first_name'] . ' ' . $user['last_name'];
            return $user;
        }, $users);

        return response()->json($users);
    }
}
