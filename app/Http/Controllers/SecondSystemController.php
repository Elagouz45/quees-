<?php
/**            M/M/1               **/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemTwo;

class SecondSystemController extends Controller
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

        ]);
        return redirect()->route('calculateLST');
    }

    /**
     * Calculate L,Lq,W,Wq,p,Po
     *  save results in db
     *  return to view system2
     */
    public function calculateLST(){

        $system = SystemTwo::latest()->first();//get the last db record as object $system

        $λ = $system->arrive_rate;
        $µ = $system->service_rate;

        $p = $λ/$µ;
        $Po = 1-$p;
        $L  = $λ/($µ-$λ);
        $Lq = ($λ*$λ)/($µ*($µ-$λ));
        $W  = 1/($µ-$λ);
        $Wq = $λ/($µ*($µ-$λ));

        $system->L = $L;
        $system->Lq = $Lq;
        $system->Po = $Po;
        $system->W = $W;
        $system->Wq = $Wq;
        $system->save();

//          return view('queues');
        return view('systems.system2',compact('system'));

    }

    /**
     * Calculate Pn using value of n
     *  return value to view
     */
    public function calculatePn(Request $request)
    {
        $system = SystemTwo::latest()->first();//get the last db record as object $system
        $n = $request->get('n');
        $λ = $system->arrive_rate;
        $µ = $system->service_rate;

        $p = $λ/$µ;
        $Pn = round(pow($p,$n) * $system->Po,2);
        $system->Pn = $Pn;
        $system->save();
        return view('systems.system2',compact('system'))->with('Pn',$Pn);
    }



}
