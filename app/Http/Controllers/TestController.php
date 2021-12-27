<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestEvent;

class TestController extends Controller
{
    public function broadcast(){
    	 broadcast(new TestEvent("Check Testing"))->toOthers();
    }
}
