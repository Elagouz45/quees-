<?php

namespace App\Http\Controllers;

use App\SystemTwo;
use Illuminate\Http\Request;

class SystemFiveController extends Controller
{

    public function fact($num){
        $factorial = 1;
        for ($x=$num; $x>=1; $x--)
        {
            $factorial = $factorial * $x;
        }
        return $factorial;
    }

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
            'servers'      => $request->get('servers'),
            'capacity'     => $request->get('capacity')
        ]);
        return redirect()->route('PoSystemFive');
    }



    /**
     * calculate value of Po
     * store it in db
     * direct to Matrics
     */
    public function PoSystemFive(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;
        $k = $system->capacity;

        $r = $λ/$µ;
        $p = $r/$c;

        $Po = 0;

        if($p == 1){
            $po = 0;//this equal to 1/Po
            $ft = 0;//first term of equation
            $st = 0;//second term of equation
            //for loop to find summation of first term
            for($i = 0;$i < $c ;$i++){
                $ft += pow($r,$i) / $this->fact($i);
            }

            //second term of equation
            $st = ( pow($r,$c) / $this->fact($c) ) * ($k-$c+1);

            //result if equation
            $po = $ft + $st;
            //value of Po
            $Po = 1/$po;

        }elseif($p != 1){
            $po = 0;    //this equal to 1/Po
            $ft = 0;    //first term of equation
            $st = 0;    //second term of equation
            //for loop to find summation of first term
            for($i = 0;$i < $c ;$i++){
                $ft += pow($r,$i) / $this->fact($i);
            }
            //second term of equation
            $st = ( pow($r,$c) / $this->fact($c) ) * ((1-pow($p,$k-$c+1))/(1-$p));

            //result if equation
            $po = $ft + $st;
            //value of Po
            $Po = 1/$po;

        }
        $system->Po = $Po;
        $system->save();

        return redirect()->route('calculateLqSFive');

    }


    public function calculateLqSFive(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;
        $k = $system->capacity;
        $Po = $system->Po;

        $r = $λ/$µ;
        $p = $r/$c;

        $lq1 = ($p*pow($r,$c)*$Po)/($this->fact($c)*pow(1-$p,2));
        $lq1 = round($lq1,3);

        $lq2 = 1-pow($p,$k-$c+1)-(1-$p)*($k-$c+1)*pow($p,$k-$c);
        $Lq  = $lq1 * $lq2;

        $summation =0;
        //find the summation term of L
        for($i = 0;$i < $c ;$i++){
            $summation += ($c - $i)*(pow($r,$i)/$this->fact($i));
        }


        $L = $Lq + $c - $Po * $summation;

        $W = $L / $this->lamdaprim();

        $Wq = $Lq / $this->lamdaprim();

        $system->L = $L;
        $system->Lq = $Lq;
        $system->W = $W;
        $system->Wq = $Wq;
        $system->save();


        return view('systems.system5',compact('system'));
    }




    /**
     * Calculate value of lamda prim that used to calculate value of Lq ,W ,Wq
     *
     */
    public function lamdaprim(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;
        $k = $system->capacity;
        $Po = $system->Po;
        $λ՝ =0;
        $Pk=0;

        //first calculate Pk to calculate

        $Pk = ( pow($λ,$k) / ( pow($c,$k-$c)*$this->fact($c)*pow($µ,$k) ) ) * $Po;


        $λ՝ = $λ *(1-$Pk);


        return $λ՝;
    }


    /**
     * calculate Pn
     */
    public function calculatePnSFive(Request $request){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;
        $Po= $system->Po;
        $K = $system->capacity;


        $n = $request->get('n');

        if($n >=0 && $n < $c){
            $Pn = ( pow($λ,$n) / ( $this->fact($n)*pow($µ,$n) ) ) * $Po;
        }elseif($n>=$c && $n<=$K){
            $Pn = ( pow($λ,$n) / ( pow($c,$n-$c)*$this->fact($c)*pow($µ,$n) ) ) * $Po;
        }


        return view('systems.system5',compact('system'))->with(['Pn'=>$Pn]);
    }


}
