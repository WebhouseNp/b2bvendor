<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slider\Entities\Slider;
use Image;
use File;
use Validator;

class SliderController extends Controller
{
    protected $slider = null;
    public function __construct(Slider $slider){
        $this->slider = $slider;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $sliders = $this->slider->orderBy('id', 'DESC')->get();
        return view('slider::index',compact('sliders'));
    }

    public function allSliders(){
        $sliders = $this->slider->where('status','publish')->orderBy('id', 'DESC')->get();
        if($sliders->isNotEmpty()){
            return response()->json(['status' => 'successful', 'data' => $sliders],200);
        } else {
            return response()->json(['status' => 'unsuccessful', "message" => "Sliders not found"],404);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $slider_info = null;
        return view('slider::create',compact('slider_info'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $value = $request->except('image', 'publish');
        $value['publish'] = is_null($request->publish) ? 0 : 1;
        if($request->image){
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }
        $success= $this->slider->create($value);
        
        if($success){
            
            $request->session()->flash('success', 'Slider added Successfully.');
        } else {
            $request->session()->flash('error', 'Error While adding Slider Data.');
        }
      
        return redirect()->route('slider.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('slider::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
           $request->session()->flash('error', 'Invalid Slider Id or Slider  not found.');
            return redirect()->route('slider.index');
        }
        return view('slider::create', compact( 'slider_info'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $slider =$this->slider->findorFail($id);
        $value = $request->except('_token');
        // $value['status'] = is_null($request->status) ? 'unpublish' : 'publish';
        if ($request->image) {
        $image = $this->slider->findorFail($id);
            if ($image->image) {
                $thumbPath = public_path('images/thumbnail');
                $listingPath = public_path('images/listing');
                if((file_exists($thumbPath . '/' . $image->image)) && (file_exists($listingPath . '/' . $image->image))){
                    unlink($thumbPath . '/' . $image->image);
                    unlink($listingPath . '/' . $image->image);
                }
            }
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }
        $success = $slider->update($value);
        
        if($success){
            
            $request->session()->flash('success', 'Slider udpated Successfully.');
        } else {
            $request->session()->flash('error', 'Error While adding Slider Data.');
        }
      
        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request,$id)
    {
        $slider = $this->slider->findorFail($id);
            if ($slider->image) {
                $this->unlinkImage($slider->image);
            }
           $success = $slider->delete();
           if($success){
            $request->session()->flash('success', 'Slider deleted successfully');

        } else {
            $request->session()->flash('error', 'Sorry! Slider could not be deleted at this moment.');
        }
        return redirect()->route('slider.index');
    }

    public function imageProcessing($type, $image)
    {
        $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path('images/thumbnail');
        $mainPath = public_path('images/main');
        $listingPath = public_path('images/listing');

        $img1 = Image::make($image->getRealPath());
        $img1->fit(530, 300)->save($thumbPath . '/' . $input['imagename']);


        $img2 = Image::make($image->getRealPath());
        $img2->fit(99, 88)->save($listingPath . '/' . $input['imagename']);

        $destinationPath = public_path('/images');
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $mainPath = public_path('images/main/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        $documentPath = public_path('document/') . $imagename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($mainPath)) {
            unlink($mainPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
        }

        if (file_exists($documentPath)) {
            unlink($documentPath);
        }
        return;
    }
}
