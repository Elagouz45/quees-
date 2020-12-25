
@include("temp.header")

<div class="panel panel-default">
    <div class="panel-body">


        @if($case == 'one')
            <h4>System model is D/D/1/{{$system->capacity}} Case1</h4>
            Service time is : {{$system->service_time}} <br>
            Interarrival time is :{{$system->interarrival_time}} <br>
            Capacity of System is :{{$system->capacity}} <br>
            <br>
            We will find the first balk will be at (ti) : {{$system->ti}}
            <br>
            <br>
            So n(t) will be one of three values:
            <br>
            1- n(t) = {{$system->n1}} when t < {{$system->interarrival_time}}<br>
            2- n(t) = {{$system->n2}} when  {{$system->interarrival_time}} <= t < {{$system->ti}}<br>
            3- n(t) = {{$system->n3}} when t>= {{$system->ti}} <br>
            <br>
            Therefore:-<br>
            Wq(n) will be :<br>
            1- Wq(n) = {{$system->wq1}} when n=0 <br>
            2- Wq(n) = {{$system->wq2}} when n < {{$system->ti * (1/$system->interarrival_time)}}<br>
            3- Wq(n) = {{$system->wq3}} when n >= {{$system->ti * (1/$system->interarrival_time)}}<br>

            <br>


            <form action="{{url('systemOne/calculateNt')}}" method="POST">
                @csrf
                <div class="form-group form-inline">
                    <label for="exampleInputEmail1" style="margin: 5px;">Value of n(t) at specific tile</label>

                    <input type="number" step="0.001" name="t" class="form-control" placeholder="Enter Value of t" style="margin: 5px;">

                    <button class="btn btn-primary " type="submit" style="margin: 5px;">Submit </button>
                </div>
            </form>

            @if(isset($n))
                <p>n(t) = {{$n}}</p>
            @endif

            <form action="{{url('systemOne/calculateWqn')}}" method="POST">
                @csrf
                <div class="form-group form-inline">
                    <label for="exampleInputEmail1" style="margin: 5px;">Value of Wq(n) </label>
                    <input type="number" step="0.001" name="n" class="form-control" placeholder="Enter Value of n" style="margin: 5px;margin-left:85px">
                    <button class="btn btn-primary " type="submit" style="margin: 5px;">Submit </button>
                </div>
            </form>

            @if(isset($Wq))
                <p>Wq(n) = {{$Wq}}</p>
            @endif





        @else
            <h4>System model is D/D/1/{{$system->capacity}} Case2</h4>
            Service time is : {{$system->service_time}} <br>
            Interarrival time is :{{$system->interarrival_time}} <br>
            Capacity of System is :{{$system->capacity}} <br>
            <br>
            We will find the first balk(ti) will be at : {{$system->ti}}
            <br>
            <br>
            So n(t) will be one of three values:
            <br>
            1- n(t) = {{$system->n1}} when t < {{$system->ti}}<br>
            2- n(t) = {{$system->n2}} when t >= {{$system->ti}}<br>
            <br>
            Therefore:-<br>
            Wq(n) will be :<br>
            1- Wq(n) = {{$system->wq1}} when n=0 <br>
            2- Wq(n) = {{$system->wq2}} when n <= {{floor($system->ti * (1/$system->interarrival_time))}}<br>
            3- Wq(n) = {{$system->wq3}} when n > {{floor($system->ti * (1/$system->interarrival_time))}}<br>

            <br>



            <form action="{{url('systemOne/calculateNtCaseTwo')}}" method="POST">
                @csrf
                <div class="form-group form-inline">
                    <label for="exampleInputEmail1" style="margin: 5px;">Value of n(t) at specific tile</label>
                    <input type="number" step="0.001" name="t" class="form-control" placeholder="Enter Value of t" style="margin: 5px;">
                    <button class="btn btn-primary " type="submit" style="margin: 5px;">Submit </button>

                </div>
            </form>

                @if(isset($n))
                    <p>n(t) = {{$n}}</p>
                @endif

            <form method="POST" action="{{url('systemOne/calculateWqnCaseTwo')}}">
                @csrf
                <div class="form-group form-inline" method="POST">
                    <label for="exampleInputEmail1" style="margin: 5px;">Value of Wq(n) </label>
                    <input type="number" step="0.001" name="n" class="form-control" placeholder="Enter Value of n" style="margin: 5px;margin-left:85px">
                    <button class="btn btn-primary " type="submit" style="margin: 5px;">Submit </button>
                </div>
            </form>
            @if(isset($Wq))
                <p>Wq(n) = {{$Wq}}</p>
            @endif

        @endif




    </div>
</div>



@include("temp.footer")



