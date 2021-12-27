<?php

namespace Modules\Subscriber\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscriber\Entities\Subscriber;
use Validator, DB;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'DESC')->get();
        return view('subscriber::index',compact('subscribers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('subscriber::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'             => 'required|email'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
                exit;
            }
            $data=['email'=>$request->email];
            $success= Subscriber::create($data);
            return response()->json(['status' => 'successful', 'message' => 'Subscribed Successfully.', 'data' => $success]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('subscriber::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $detail = Subscriber::findOrFail($id);
        return view('subscriber::edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update($id, Request $request)
    {
        $formData = $request->except('status');
        $detail = Subscriber::findOrFail($id);
        $formData['status'] = is_null($request->status) ? 'unpublish' : 'publish';
        $detail->update($formData);
        return redirect()->route('subscriber.index')->with('success', 'Subscriber update');
    }


    public function delete($id, Request $request)
    {
        $subscriber = Subscriber::findOrFail($id);
        if (!$subscriber){
            $request->session()->flash('error', 'Subscriber detail not found.');
            return redirect()->route('subscriber.index');
        }
        $del = $subscriber->delete();
        if ($del) {


            $request->session()->flash('success', 'Subscriber deleted successfully');
        } else {
            $request->session()->flash('error', 'Sorry! Subscriber could not be deleted at this moment.');
        }
        return redirect()->route('subscriber.index');
    }
}
