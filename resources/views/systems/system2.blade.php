@include("temp.header")



<div class="panel panel-default">
    <div class="panel-body">
        <h4>System Model M/M/1</h4>
        <p>L  = {{$system->L}}</p>
        <p>Lq = {{$system->Lq}}</p>
        <p>W  = {{$system->W}}</p>
        <p>Wq = {{$system->Wq}}</p>
        <p>Po = {{$system->Po}}</p>
    </div>
    <div class="panel-body">
        <form action="calculatePn" method="POST">
            @csrf
            <div class="form-group">
                <label for="formGroupExampleInput2">To Calculate Pn</label>
                <input type="number" step="0.001" name="n" class="form-control" id="formGroupExampleInput2" placeholder="Enter Value of n" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
        <div class="panel-body">
            @if(isset($Pn))
                <p>Pn = {{$Pn}}</p>
            @endif

        </div>
    </div>
</div>




    @include("temp.footer")





