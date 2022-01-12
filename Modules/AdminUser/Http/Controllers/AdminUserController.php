<?php

namespace Modules\AdminUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB, Validator;
use App\Models\User;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;

class AdminUserController extends Controller
{
    protected $ACCESS_LEVELS = [
        'category' => 'Category',
        'subcategory' => 'Sub category',
        'product' => 'Product',
        'offer' => 'Offer',
        'brand' => 'Brand',
        'advertisement' => 'Advertisement',
        'slider' => 'Slider',
        'quotation' => 'Quotation',
        'dashboard' => 'Dashboard',
        'web-setting' => 'Site Setting',
        
     ];
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = User::when(request()->filled('search'), function($query) {
            return $query->where('name', 'like', '%'. request('search') . "%")
            ->orWhere('email', 'like', '%'. request('search'));
            })
        ->published()
        ->with('roles')
        ->latest()
        ->paginate(15)
        ->withQueryString();
        
        return view('adminuser::index', compact('details'));
    }

    public function getallroles(){
        $role = Role::where('publish', 1)->get();
        return response()->json(['data'=>$role, 'status_code'=>200]);
    }

    //
    public function getUsers()
    {
        $details = User::published()->with('roles')->paginate(5);
        $view = \View::make("adminuser::usersTable")->with('details', $details)->render();

        return response()->json(['html' => $view, 'status' => 'successful',
         'data' => $details,
         'pagination' => (string) $details->links()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $access_levels = $this->ACCESS_LEVELS;
        return view('adminuser::create',compact('access_levels'));
    }

    public function createuser(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'email' => 'required|unique:users',
            'password' => 'required|min:5',
            'phone_num' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        DB::beginTransaction();
        try{
            $value = $request->except('publish');
            $name = explode(' ', $request->name);
            $username = $name[0] . rand(10, 1000);
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $value['username'] = $username;
            $value['password'] = bcrypt($request->password);
            $value['access_level'] = '';
            if ($request->access) {
                $accesses = $request->access;
                // foreach ($accesses as $access) {
                // //    $value['access_level'] .= ($value['access_level'] == '' ? '' : ',') . $access;
                $value['access_level'] = json_encode($accesses, true);
                // }
             }
            //  dd($value);
            
            $userExist = User::create($value);

        if ($userExist){
            $user = User::where('email', $request->email)->first();
          }
          $formData = $request->except('publish', 'password_confirmation', 'access');
        
          
          $formData['user_id'] = $user->id;
          $role = Role::where('name','admin')->first();
          $role_data = [
            'role_id' => $role->id,
            'user_id' => $formData['user_id']
          ];
          $formData = $request->except('_token');
          $formData['user_id'] = $user->id;
          $role_user = Role_user::create($role_data);
        DB::commit();

        return response()->json(['status' => 'successful', 'message' => 'User Created Successfully.','data' => $userExist]);

        }  catch(\Exception $exception){
            DB::rollback();
              return response([
                  'message' => $exception->getMessage()
              ],400);
          }
    }

    public function deleteuser(Request $request)
    {
        // dd($request->all());
        try{
            $user = DB::table('users')->where('id',$request->id)->delete();
            // dd($user);
            // $user->delete();delet

      return response()->json([
        'status' => 'successful',
        "message" => "User deleted successfully!"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function edituser(Request $request)
    {
        try{
            $user = User::findorFail($request->id);
            // dd($user);

      return response()->json([
        "data" => $user
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updateUser(Request $request){
        // dd($request->all());
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $user = User::findorFail($request->id);
            $value = $request->except('publish','_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $value['password'] = bcrypt($request->password);
            $value['phone_num'] = $request->phone_num;
            $value['access_level'] = '';
            if ($request->access) {
                $accesses = $request->access;
                // foreach ($accesses as $access) {
                // //    $value['access_level'] .= ($value['access_level'] == '' ? '' : ',') . $access;
                $value['access_level'] = json_encode($accesses, true);
                // }
             }
            //  dd($value);
            $success = $user->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "users updated successfully"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
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
        return view('adminuser::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $access_levels = $this->ACCESS_LEVELS;
        return view('adminuser::edit',compact('id','access_levels'));
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
