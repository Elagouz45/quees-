<?php

namespace App\Http\Controllers;

use App\SystemTwo;
use Illuminate\Http\Request;

class SystemFourController extends Controller
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
            'servers'      => $request->get('servers')
        ]);
        return redirect()->route('PoSystemFour');
    }
    /**
     * calculate value of Po
     * store it in db
     * direct to Matrics
     */
    public function PoSystemFour(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;

        $r = $λ/$µ;
        $p = $r/$c;

        $Po = 0;

        if($p < 1){
            $po = 0;//this equal to 1/Po
            $ft = 0;//first term of equation
            $st = 0;//second term of equation
            //for loop to find summation of first term
            for($i = 0;$i < $c ;$i++){
                $ft_numerator   = pow($r,$i);
                $ft_denominator = $this->fact($i);
                $ft += $ft_numerator/$ft_denominator;
            }
            //find second term
            $st_numerator = $c * pow($r,$c);
            $st_denominator = $this->fact($c) * ($c-$r);
            $st = $st_numerator/$st_denominator;
            //result if equation
            $po = $ft + $st;
            //value of Po
            $Po = 1/$po;

        }elseif($p >= 1){
            $po = 0;//this equal to 1/Po
            $ft = 0;//first term of equation
            $st = 0;//second term of equation
            //for loop to find summation of first term
            for($i = 0;$i < $c ;$i++){
                $ft += (1/$this->fact($i))*(pow($p,$i));
            }
            //second term of equation
            $st = ( 1/$this->fact($c) ) * ( pow($r,$c) ) * ( ($c*$µ) / ( ($c*$µ) - $λ ));

            //result if equation
            $po = $ft + $st;
            //value of Po
            $Po = 1/$po;

        }
        $system->Po = $Po;
        $system->save();

        return redirect()->route('calculateLqSFour');

    }

    public function calculateLqSFour(){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;
        $Po= $system->Po;

        $r = $λ/$µ;

        $Lq = (   (pow($r,$c+1)/$c) / ($this->fact($c) * pow((1-$r/$c),2) )  ) * $Po ;

        $Wq = $Lq/$λ;
        $W = $Wq + 1/$µ;
        $L = $Lq + $r;

        $system->Lq = $Lq;
        $system->L  = $L;
        $system->Wq = $Wq;
        $system->W  = $W;
        $Ci = $c - $r;
        $system->save();

        return view('systems.system4',compact('system'))->with('Ci',$Ci);
    }


    public function calculatePnSFour(Request $request){
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;
        $c = $system->servers;
        $Po= $system->Po;

        $n = $request->get('n');

        if($n >=0 && $n < $c){
            $Pn = ( pow($λ,$n) / ( $this->fact($n)*pow($µ,$n) ) ) * $Po;
        }elseif($n>=$c){
            $Pn = ( pow($λ,$n) / ( pow($c,$n-$c)*$this->fact($c)*pow($µ,$n) ) ) * $Po;
        }
        $r = $λ/$µ;
        $Ci = $c - $r;
        return view('systems.system4',compact('system'))->with(['Pn'=>$Pn,'Ci'=>$Ci]);
    }


}
