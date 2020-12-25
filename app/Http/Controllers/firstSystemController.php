<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System;
use Illuminate\Support\Facades\DB;
class firstSystemController extends Controller
{


    /**
     * Store a new created resource in storage.
     *
     * get data from form and insert it into db
     *
     * redirect to ti
     */
    public function store(Request $request)
    {
//        integer
            System::create([
                'service_time'      => $request->get('sercive-time'),
                'interarrival_time' => $request->get('interarrivale-time'),
                'capacity'          => $request->get('capacity'),
            ]);
            return redirect()->route('tiCaseOne');//redirect to route which collect value of ti

    }


    /**
     * Store M value in db
     *
     * get data from form and insert it into db
     *
     * redirect to tiCaseTwo
     */
    public function storeM(Request $request){
        $system = System::Latest()->first(); //get the current system data from db
        $system->M = $request->get('M'); //update M column to it's value
        $system->save(); //save changes
        return redirect()->route('tiCaseTwo');
    }
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//=================================Case One System One==================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================


    /**
     * collect ti with using vakue of K ,  lamda , mue
     * lamda = 1/interarrival-time
     * mue = 1/service-time
     * ti = (K-mue/lamda)/(lamda-mue)
     * store value of ti in db
     * $customer = floor($lamda*$ti) - floor(($mue*$ti) - ($mue/$lamda));
     * save ti in db
     * redirect to collect n(t)
     */
    public function tiCaseOne(){

        $system = System::latest()->first();//get the last db record as object $system

        //sat db values in simple variables
        $K      = $system->capacity + 1;
        $intert = $system->interarrival_time;
        $st     = $system->service_time;
        $µ      = 1/$st;
        $λ      = 1/$intert;

        if($λ > $µ){ //check if system is in case1
            //collect ti
            $ti = ($K-$µ/$λ)/($λ-$µ);
            $capacity = $K-1;
            //this loop use to find the minimum value of ti
            while (true){
                $customer = floor($λ*$ti+0.00001) - floor(0.00001 + $µ*$ti - $µ/$λ);//numbers of customers in the system
                if(round($customer) == round($K)){
                    $ti -= $system->interarrival_time;
                }else{
                    $ti += $system->interarrival_time;
                    break;
                }
            }
            //save ti and K values in db
            $system->ti = $ti;
            $system->K  = $K;
            $system->save();
            //redirect to collect n(t) as generall form of it
            return redirect()->route('collectnGenerallyCaseOne');
        }else{ //if system in case2 user should enter value of M first
            return view('queues')->with(['pattern'=>'deterministic','M'=>0]);//redirect to form to allow user to enter M
        }
    }

    /**
     * collect n(t)
     * µ λ"
     * save values of n(t) in db
     * redirect to collectWq
     */
    public function collectnGenerallyCaseOne()
    {
        $system = System::latest()->first();

        $K      = $system->capacity + 1;
        $st     = $system->service_time;
        $intert = $system->interarrival_time;
        $µ      = 1/$st;
        $λ      = 1/$intert;
        $ti     = $system->ti;

        //find n(t) generally
        $n1 = 0;
        $n2 = "[t/". $intert ."] - [t/".$st ." - " . $intert."/". $st . "]";
        //we know if  µ=mλ it is special case so we check this condition to find ne
        if($st%$intert == 0){
            $n3 = $K-1;
        }else{
            $n31= $K -1;
            $n32= $K-2;
            $n3 =  $n31 . " or " . $n32;
        }

        //save values in db
        $system->n1 = $n1;
        $system->n2 = $n2;
        $system->n3 = $n3;
        $system->save();

        //redirect to collect Wq
        return redirect()->route('collectWqGenerallyCaseOne');


    }


    /**
     * collect values of Wq generally
     *
     *
     *
     */
    public function collectWqGenerallyCaseOne()
    {
        $system = System::latest()->first();

        $K      = $system->capacity + 1;
        $st     = $system->service_time;
        $intert = $system->interarrival_time;
        $µ      = 1/$st;
        $λ      = 1/$intert;
        $ti     = $system->ti;

        $wq1 = 0;
        $wq2 = $st-$intert."(n-1)";
        //we know if  µ=mλ it is special case so we check this condition to find ne
        if($st%$intert == 0){
            $wq3 = ($st-$intert)*($λ*$ti-2);
        }else{
            $wq31= ($st-$intert)*($λ*$ti-3);
            $wq32= ($st-$intert)*($λ*$ti-2);
            $wq3 =  $wq31 . " or " . $wq32;
        }


        $system->wq1 = $wq1;
        $system->wq2 = $wq2;
        $system->wq3 = $wq3;
        $system->save();

        return redirect()->route('show','one');



    }

//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//=================================Case two System One==================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================


    /**
     * collect ti in case two of system one
     *  ti = M/(µ - λ)
     *  store ti in db
     *  redirect to collect n(t)
     *
     */
    public function tiCaseTwo()
    {
        $system = System::latest()->first();

        $M = $system->M;
        $µ = 1/$system->service_time;
        $λ = 1/$system->interarrival_time;

        $ti = floor($M/($µ - $λ));

        $system->ti = $ti;
        $system->save();
        return redirect()->route('collectnGenarallyCaseTwo');

    }



    /**
     * collect general form of values of n(t)
     *
     *
     * redirect to collect Wq(n)
     */
    public function collectnGenarallyCaseTwo()
    {
        $system = System::latest()->first();

        $M = $system->M;

        $n1 = $M . "+[t/".$system->interarrival_time."]-[t/".$system->service_time."]";
        $n2 = "0 or 1";

        $system->n1 = $n1;
        $system->n2 = $n2;
        $system->save();

        return redirect()->route('collectWqGenerallyCaseTwo');

    }

    /**
     * Collect general form of Wq(n)
     **/
    public function collectWqGenerallyCaseTwo(){
        $system = System::latest()->first();

        $M = $system->M;
        $system->service_time;
        $system->interarrival_time;
        $µ = 1/$system->service_time;

        $wq1 = ($M-1)/2*$µ;
        $wq2 = "(".$M."-1+n)*(".$system->service_time.")-n*".$system->interarrival_time;
        $wq3 = 0;

        $system->wq1 = $wq1;
        $system->wq2 = $wq2;
        $system->wq3 = $wq3;
        $system->save();

        return redirect()->route('show','two');



    }


    /**
     * Display the specified resource.
     *
     * return view with results of system one
     *
     */
    public function show($case)
    {
        $system = System::latest()->first();
        return view('systems.system1',compact('system'))->with('case',$case);


    }

    /**
     * calculate n(t) using value of t
     * and view it
     * return view syste1 with n(t)
     */
    public function calculateNt(Request $request){
        $system = System::latest()->first();

        $t= $request->get('t');

        $µ = 1/$system->service_time;
        $λ = 1/$system->interarrival_time;
        $n=0;

        if($t == 0){
            $n = 0 ;
        }elseif($t > 0 && $t<$system->ti) {
            $n = floor($t * $λ) - floor($µ * $t - ($µ / $λ));
        }elseif($t >= $system->ti){
            //check if special Case
            if($system->service_time%$system->interarrival_time == 0){
                $n = $system->K-1;
            }else{
                $n1 = $system->K - 1;
                $n2 = $system->K - 2;
                $n = $n2 ." or " . $n1;
            }
        }

        return view('systems.system1',compact('system') )->with(['n'=>$n , 'case'=>'one']);
    }

    /**
     * calculate Wq(n) using value of n
     * and view it
     * return view syste1 with Wq(n)
     */
    public function calculateWqn(Request $request){
        $system = System::latest()->first();

        $n= $request->get('n');

        $µ = 1/$system->service_time;
        $λ = 1/$system->interarrival_time;

        $Wq = 0;
        if($n == 0){
            $Wq = 0 ;
        }elseif($n > 0 && $n<(floor($system->ti*$λ))) {
            $Wq =($system->service_time - $system->interarrival_time)*($n-1) ;
        }elseif($n >= (floor($system->ti*$λ))){

            //we know if  µ=mλ it is special case so we check this condition to find ne
            if($system->service_time%$system->interarrival_time == 0){
                $Wq= ($system->service_time-$system->interarrival_time)*($λ*$system->ti-2);
            }else{
                $wq1= ($system->service_time-$system->interarrival_time)*($λ*$system->ti-3);
                $wq2= ($system->service_time-$system->interarrival_time)*($λ*$system->ti-2);
                $Wq = $wq1 ." or " . $wq2;
            }



        }
        return view('systems.system1',compact('system') )->with(['Wq'=>$Wq , 'case'=>'one']);

    }

    /**
     * calculate n(t) using value of t
     * and view it
     * return view syste1 with n(t)
     */
    public function calculateNtCaseTwo(Request $request){
        $system = System::latest()->first();
        $t= $request->get('t');
        $M = $system->M;
        $n =0;
        if($t == 0){
            $n = $M ;
        }elseif($t > 0 && $t < $system->ti) {
            $n = $M + floor($t/$system->interarrival_time) - floor($t/$system->service_time);
        }elseif($t >= $system->ti){
            $n = 0 ." or " . 1;
        }
        return view('systems.system1',compact('system') )->with(['n'=>$n , 'case'=>'two']);
    }

    /**
     * calculate Wq(n) using value of n
     * and view it
     * return view syste1 with Wq(n)
     */
    public function calculateWqnCaseTwo(Request $request){
        $system = System::latest()->first();
        $n= $request->get('n');
        $M = $system->M;

        $system->service_time;
        $system->interarrival_time;

        $µ = 1/$system->service_time;
        $λ = 1/$system->interarrival_time;

        $Wq =0 ;
        $wq1 = ($M-1)/2*$µ;
        $wq2 = "(".$M."-1+n)*(".$system->service_time.")-n*".$system->interarrival_time;
        $wq3 = 0;

        if($n == 0){
            $Wq = ($M-1)/2*$µ ;
        }elseif($n > 0 && $n<(floor($system->ti*$λ))) {
            $Wq =($M-1+$n)*($system->service_time)-$n*$system->interarrival_time ;
        }elseif($n >= (floor($system->ti*$λ))){
            $Wq =0;
        }
        return view('systems.system1',compact('system') )->with(['Wq'=>$Wq , 'case'=>'two']);
    }
}

















