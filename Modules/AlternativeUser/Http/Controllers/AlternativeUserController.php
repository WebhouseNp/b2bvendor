<?php

namespace Modules\AlternativeUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AlternativeUserController extends Controller
{
    public function index()
    {
        return view('alternativeuser::index');
    }

    public function create()
    {
        return view('alternativeuser::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('alternativeuser::show');
    }

    public function edit($id)
    {
        return view('alternativeuser::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
