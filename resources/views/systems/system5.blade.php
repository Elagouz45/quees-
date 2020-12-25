@include("temp.header")



<div class="panel panel-default">
    <div class="panel-body">
        <h4>System Model M/M/C/K</h4>
        <p>L  = {{round($system->L,3)}}</p>
        <p>Lq = {{round($system->Lq,3)}}</p>
        <p>W  = {{round($system->W,3)}}</p>
        <p>Wq = {{round($system->Wq,3)}}</p>
        <p>Po = {{round($system->Po,3)}}</p>
    </div>
    <div class="panel-body">
        <form action="calculatePnSFive" method="POST">
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
                <p>Pn = {{round($Pn,3)}}</p>
            @endif

        </div>
    </div>
</div>




@include("temp.footer")





