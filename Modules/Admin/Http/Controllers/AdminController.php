<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Http\JsonResponse;

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

        if (!$user) {
            return $this->sendLoginErrorResponse($request);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendLoginErrorResponse($request);
        }

        // if ($user->role == 'admin' && $user->publish == 0) {
        //     return back()->with('message', "Your account is inactive! Please contact Team.");
        // }

        $roles = [];
        foreach ($user->roles()->get() as $role) {
            array_push($roles, $role->slug);
        }

        // Return if user is not super_admin or admin or vendor
        if (!in_array('super_admin', $roles, TRUE) && !in_array('admin', $roles, TRUE) && !in_array('vendor', $roles, TRUE)) {
            return $this->sendLoginErrorResponse($request);
        }

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            $profile = Auth::user();
            $profile->api_token = $token;
            $profile->save();

            return redirect('/admin/dashboard');
        } else {
            return back()->withErrors(['login' => 'Something went wrong while logging you in.']);
        }
    }

    private function sendLoginErrorResponse(Request $request)
    {
        return $request->wantsJson()
            ? new JsonResponse([
                'error' => 'These credentials do not match our records.',
            ], 404)
            : redirect()->back()->withErrors(['login' => 'These credentials do not match our records.']);
    }

    public function admin__logout()
    {
        if(checkrole(auth()->user()->id) == 'admin' || checkrole(auth()->user()->id) == 'super_admin' ){
            Auth::logout();
            Session::flush();
            return redirect()->route('login');
        } else {
            Auth::logout();
            Session::flush();
            return redirect()->to('/vendor-login');;
        }
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
