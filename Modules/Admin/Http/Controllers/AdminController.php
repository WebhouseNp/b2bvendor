<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Role\Entities\Role;
use Modules\Role\Entities\Role_user;
use Session;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    public function login()
    {
        return view('admin::login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        // dd($roles);
        if (!$user) {
            // return back()->with('message', 'User not found');
            return response()->json([
                "message" => "User not found!!"
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            // return back()->with('message', 'Invalid Username\Password');
            return response()->json([
                "message" => "Invalid Username\Password!!"
            ], 401);
        }

        // if ($user->role == 'admin' && $user->publish == 0) {
        //     return back()->with('message', "Your account is inactive! Please contact Team.");
        // }
        
        // dd($user);
        $roles = [];

        foreach ($user->roles()->get() as $role) {
            array_push($roles, $role->slug);
        }
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            $profile = Auth::user();
            $profile->api_token = $token;
            $profile->save();
            if (in_array('super_admin', $roles, TRUE) || in_array('admin', $roles, TRUE)|| in_array('vendor', $roles, TRUE)) {
                return response()->json([
                    "message" => "success",
                    'token' => $token,
                    'data' => $user,
                    'status_code' => 200
                ], 200);
            } else {
                // return redirect()->route('admin.logout');
                return response()->json([
                    "message" => "Not Authenticated User!!"
                ], 401);
            }
        } else {
            // return back()->withInput()->withErrors(['email' => 'something is wrong!']);
            return response()->json([
                "message" => "Sorry could not login!!"
            ], 500);
        }
    }

    public function admin__logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
