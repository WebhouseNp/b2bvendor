<?php

namespace Modules\Country\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;
use Image, File;
use Module;
use Modules\Country\Entities\Country;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $countries = Country::get();

        return view('country::index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return $this->showForm(new Country());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'flag' => 'required',
            'publish' => 'nullable'
        ]);

        $module = Module::find('country');
        $formInput = $request->except(['flag', 'publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $image_title = $request->name;
        if ($request->hasFile('flag')) {
            $location = public_path('/uploads/' . $module->getName() . '');
            $location1 = 'uploads/' . $module->getName() . '';
            if (!file_exists($location)) {
                mkdir(public_path('/uploads/' . $module->getName() . ''), 0777, true);
            }
            $filename = $image_title . '.' . date('Ymdhis') . rand(0, 1234) . "." . $request['flag']->getClientOriginalName();
            $useImage = Image::make($request['flag']->getRealPath());
            $useImage->save($location . '/' . $filename);
            $abcd = $request['flag']->move($location, $filename);
            $path = $location1 . '/' . $filename;
            $formInput['path'] = $path;
            $formInput['flag'] = $filename;
        }
        Country::create($formInput);
        return redirect()->route('country.index')->with('success', 'Country Created Successfuly.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('country::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Country $country)
    {
        return $this->showForm($country);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|max:255',
            'flag' => 'nullable',
            'publish' => 'nullable'
        ]);

        $country_info = $country;
        $module = Module::find('country');
        if ($request->hasFile('flag')) {
            $this->unlinkImage($country_info->flag);
        }
        $formInput = $request->except(['flag', 'publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $image_title = $request->name;
        if ($request->hasFile('flag')) {
            $location = public_path('/uploads/' . $module->getName() . '');
            $location1 = 'uploads/' . $module->getName() . '';
            if (!file_exists($location)) {
                mkdir(public_path('/uploads/' . $module->getName() . ''), 0777, true);
            }
            $filename = $image_title . '.' . date('Ymdhis') . rand(0, 1234) . "." . $request['flag']->getClientOriginalName();
            $useImage = Image::make($request['flag']->getRealPath());
            $useImage->save($location . '/' . $filename);
            $abcd = $request['flag']->move($location, $filename);
            $path = $location1 . '/' . $filename;
            $formInput['path'] = $path;
            $formInput['flag'] = $filename;
        }
        $country_info->update($formInput);
        return redirect()->route('country.index')->with('success', 'Country Updated Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $country_info = Country::findOrFail($id);
        if ($country_info->flag) {
            $this->unlinkImage($country_info->flag);
        }
        $country_info->delete();
        return redirect()->route('country.index')->with('success', 'Country Deleted Successfuly.');
    }

    public function showForm(Country $country)
    {
        $updateMode = false;

        if ($country->exists) {
            $updateMode = true;
        }

        return view('country::form', compact(['country', 'updateMode']));
    }

    public function unlinkImage($flag)
    {
        $module = Module::find('country');
        $usersImage = public_path("uploads/{$module->getName()}/{$flag}");
        if (File::exists($usersImage)) { // unlink or remove previous image from folder
            unlink($usersImage);
        }
    }
}
