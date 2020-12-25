<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemTwo;

class SystemThreeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * get data from form and save it in db
     *
     * redirect to collect L
     *
     */
    public function store(Request $request)
    {

        SystemTwo::create([
            'arrive_rate'  => $request->get('arrive-rate'),
            'service_rate' => $request->get('service-rate'),
            'capacity'     => $request->get('capacity')

        ]);
        return redirect()->route('calculatep');
    }

    /**
     * Caculate p ro
     *
     * p = λ/µ
     *
     * redirect to calculate Po
     **/
    public function calculatep(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system

        $p = $system->arrive_rate / $system->service_rate ;
        $system->p = $p;
        $system->save();

        return redirect()->route('calculatePo');
    }

    /**
     * Calculate Po
     * redirect to calculate L
     */
    public function calculatePo(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $Po = 0;
        $K = $system->capacity;
        $p = $system->p;
        if($p == 1){
            $Po = 1/($K+1);
        }else{
            $Po = (1-$p)/(1-pow($p,$K+1));
        }
        $system->Po = $Po;
        $system->save();

        return redirect()->route('calculateLSTh');
    }


    /**
     * Calculate L
     * redirect to calculate Lq
    */
    public function calculateLSTh(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $K = $system->capacity;
        $p = $system->p;
        $L =0 ;
        if($p == 1){
            $L = $K/2;
        }else{
            $numerator = 1 - (pow($p,$K) * ($K+1)) + ($K*pow($p,($K+1)));
            $denominator=(1-$p) * (1-pow($p,($K+1)));
            $L = $p*($numerator/$denominator);
        }
        $system->L = $L;
        $system->save();

        return redirect()->route('calculateWqSTh');

    }

    /**
     *
     * Calculate W,Wq,Lq
     *
     * return to view to show System results
     */
    public function calculateWqSTh(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $L = $system->L;
        $lamda = $this->lamdaprim();

        $W = $L/$lamda;
        $Wq = $W - (1/$system->service_rate);
        $Lq = $Wq * $lamda;

        $system->W = $W;
        $system->Wq = $Wq;
        $system->Lq = $Lq;

        $system->save();

        return view('systems.system3',compact('system'));
    }



//==================================Helper function==========================================================================


    /**
     * Calculate value of lamda prim that used to calculate value of Lq ,W ,Wq
     *
     */
    public function lamdaprim(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $λ՝ =0;
        $Pk=0;

        //first calculate Pk to calculate
        $p = $system->p;
        $Po = $system->Po;
        $K = $system->capacity;


        if($p == 1){
            $Pk = $Po;
        }else{
            $Pk = pow($p,$K) * ((1-$p)/(1-pow($p,$K+1)));
        }
        $λ՝ = $λ *(1-$Pk);
//        return $Pk ."       ========================>    ". $λ՝;
        return $λ՝;
    }



    /**
     * Calculate Pn
     * redirect to calculate L
     */
    public function calculatePnSThree(Request $request){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $n = $request->get('n');

        $K  = $system->capacity;
        $p  = $system->p;
        $Po = $system->Po;

        $Pn = 0;

        if($p == 1){
            $Pn = $Po;
        }else{
            $Pn =pow($p,$n) * ((1-$p)/(1-pow($p,$K+1)));
        }
        $system->Pn = $Pn;
        $system->save();

        return view('systems.system3',compact('system'))->with('Pn',$Pn);
//        return redirect()->route('calculateL');
    }
}
