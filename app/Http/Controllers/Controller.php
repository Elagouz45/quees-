<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * direct function take from form pattern of arrive and service
     * if pattern is deterministic view form of deterministic model's inputs
     * if Random view form of random models's inputs
     **/
    public function direct(Request $request){

        $pattern  = $request->get('pattern');

        if($pattern == 'deterministic' ){
            return view('queues')->with('pattern','deterministic'); //return to Deterministic form system
        }elseif($pattern == 'random' ){
            return view('queues')->with('pattern','random'); //return to Deterministic form system
        }
    }


    /**
     * Set which systems on random types we are on
     * return to system that we are in
     **/
    public function directRandom(Request $request){
        $servers = $request->get('servers');
        $capacity = $request->get('capacity');

        if($servers == 1){
            if($capacity == 'infinit'){
                return view('queues')->with(['pattern'=>'random','system'=>'M/M/1']);
            }elseif(is_numeric($capacity)){
                return view('queues')->with(['pattern'=>'random','system'=>'M/M/1/C','capacity'=>$capacity]);
            }else{
                return view('queues')->with('msg','invalid input');
            }
        }elseif(is_numeric($servers) && $servers > 1){
            if($capacity == 'infinit'){
                return view('queues')->with(['pattern'=>'random','system'=>'M/M/C','servers'=>$servers]);
            }elseif(is_numeric($capacity)){
                return view('queues')->with(['pattern'=>'random','system'=>'M/M/C/K','capacity'=>$capacity,'servers'=>$servers]);
            }else{
                return view('queues')->with('msg','invalid input');
            }
        }



    }




}
