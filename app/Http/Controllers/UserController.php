<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        if (Role::where('id', '=', $request->input('role'))->exists()) {
            $user->roles()->attach($request->input('role'));
        }

        return redirect('app/users')
            ->with('alert_message', 'The user has been created.')
            ->with('alert_type', 'success');
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
        $roles = Role::select('name')->get()->toArray();

        $user = User::findOrFail($id);

        if ($user->hasRole($roles)) {
            $user_role_id = $user->roles()->first()->id;
        } else {
            $user_role_id = '';
        }

        return view('user.edit', [
            'user' => User::findOrFail($id), 
            'roles' => Role::all(), 
            'user_role_id' => $user_role_id
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if (Role::where('id', '=', $request->input('role'))->exists()) {
            $user->roles()->attach($request->input('role'));
        }

        $user->save();

        return redirect('app/users')
            ->with('alert_message', 'The user has been updated.')
            ->with('alert_type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::destroy($id)) {
            return response()->json([
                    'status' => 'success',
                    'id' => $id,
                    'msg' => 'The '.$id.' user is deleted.'
                ]);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * Send ticket list for ajax request
     * @return json array
     */
    public function getDataTable(Request $request)
    {
        $data = array();

        $users = User::orderBy('created_at', 'desc')
                            ->skip($request->input('start'))
                            ->take($request->input('length'))
                            ->get();

        foreach ($users as $user) {
            $user_roles = $user->roles()->get();

            $roles = Role::select('name')->get()->toArray();

            if ($user->hasRole($roles)) {
                $role_name = $user_roles->first()->display_name;
            } else {
                $role_name = '';
            }

            $data[] = [
                'id' => (string) $user->id,
                'name' => (string) $user->first_name.' '.$user->last_name,
                'role' => $role_name,
                'created_at' => (string) $user->created_at,
            ];
        }

        return response()
            ->json([
                "draw" => $request->input('draw'),
                "recordsTotal"=> User::count(),
                "recordsFiltered"=> User::count(),
                'data' => $data
            ]);
    }
}
