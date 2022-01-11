<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Profile;
use Modules\User\Entities\Address;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
    }

    public function editUserProfile(Request $request , $id){
        $id= auth()->user()->id;
        $old = Profile::where('user_id', $id)->first();
        try{
          $validator = Validator::make($request->all(), [
              'full_name' => 'nullable',
              'email' => 'nullable',
              'birthday' => 'nullable|',
              'gender' => 'sometimes',
              'mobile_num' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
     
           ]);
          
          if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
            exit;
        }
        $value = $request->except('publish');
        $value['publish'] = is_null($request->publish) ? 0 : 1;
        $old->update($value);
  
        return response()->json([
          "message" => "User Profile updated Successfully!!",
        ],200);
  
  
        } catch(\Exception $exception){
          return response([
              'message' => $exception->getMessage()
          ],400);
      }
      }

      public function addAddress(Request $request, $id){
        
        $id= auth()->user()->id;
        
        try{
          $validator = Validator::make($request->all(), [
            'area' => 'nullable|',
            'country' => 'sometimes',
            'city' => 'sometimes',
            'address' => 'sometimes',
   
         ]);
        
        if($validator->fails()) {
          return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
          exit;
      }

        $value = $request->except('publish');
        
        $value['publish'] = is_null($request->publish) ? 0 : 1;
        $value['user_id'] = auth()->user()->id;
        $address = Address::create($value);
        return response()->json([
            "message" => "Address Created Successfully!!",
          ],200);
  
        } catch(\Exception $exception){
          return response([
              'message' => $exception->getMessage()
          ],400);
      }
      }

      public function editAddress(Request $request,$id){
          $id= auth()->user()->id;
        $old = Address::where('user_id', $id)->first();
        try{
            $validator = Validator::make($request->all(), [
              'area' => 'nullable|',
              'country' => 'sometimes',
              'city' => 'sometimes',
              'address' => 'sometimes',
     
           ]);
          
          if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
  
          $value = $request->all();
          $old->update($value);
          return response()->json([
              "message" => "Address Updated Successfully!!",
            ],200);
    
          } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

      }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
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
