@include("temp.header")

    @if(!isset($pattern)) {{-- Start Page  --}}
        <form action="direct" method="POST">
            @csrf

            <div class="form-group">
                <label for="exampleFormControlSelect1">Please Select your System Pattern</label>
                <select class="form-control form-control-lg" name="pattern">
                    <option value="random">Random</option>
                    <option value="deterministic">Deterministic</option>
                </select>
            </div>
            @if(isset($msg))
                <div class="alert alert-danger" role="alert">
                    invalid input
                </div>
            @endif

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif($pattern == 'deterministic' && !isset($M)) {{-- if system is deterministic open next form--}}
        <form action="systemOne/store" method="POST">
            @csrf

            <div class="form-group">
                <label for="formGroupExampleInput">Service Time</label>
                <input type="number" step="0.001"  name="sercive-time" class="form-control" id="formGroupExampleInput" placeholder="input value of 1/µ" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Arrival Time</label>
                <input type="number" step="0.001" name="interarrivale-time" class="form-control" id="formGroupExampleInput2" placeholder="Enter value of 1/λ" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Capacity of System</label>
                <input type="number" step="0.001" name="capacity" class="form-control" id="formGroupExampleInput2" placeholder="Enter Value of K-1" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>

        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif(isset($M) && $pattern =='deterministic') {{--Case Two--}}
    <form action="storeM" method="POST">
            @csrf

            <div class="form-group">
                <label for="formGroupExampleInput2">Number of customer that system would start with</label>
                <input type="number" step="0.001" name="M" class="form-control" id="formGroupExampleInput2" placeholder="Enter Value of M" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif($pattern == 'random' && !isset($system)){{---Random Models forms---}}
        <form action="directRandom" method="POST">
            @csrf
            <div class="form-group">
                <label for="formGroupExampleInput2">Number Of parallel servers </label>
                <input type="number" name="servers" class="form-control" id="formGroupExampleInput2" placeholder="for Example 1,2,3,4,5,...." required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">System Capacity</label>
                <input type="text" name="capacity" class="form-control" id="formGroupExampleInput2" placeholder="Enter Value of K" value="infinit" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif($pattern == 'random' && $system == 'M/M/1'){{--  Model1 M/M/1  --}}
        <form action="systemTwo/store" method="POST">
            @csrf

            <div class="form-group">
                <label for="formGroupExampleInput2">Arrive Rate</label>
                <input type="number" step="0.001" name="arrive-rate" class="form-control" id="formGroupExampleInput2" placeholder="Enter value of λ" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Service Rate</label>
                <input type="number" step="0.001" name="service-rate" class="form-control" id="formGroupExampleInput2" placeholder="input value of µ" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif($pattern == 'random' && $system == 'M/M/1/C'){{--  Model1 M/M/1/C  --}}
        <form action="systemThree/store" method="POST">
            @csrf

            <div class="form-group">
                <label for="formGroupExampleInput2">Arrive Rate</label>
                <input type="number" step="0.001" name="arrive-rate" class="form-control" id="formGroupExampleInput2" placeholder="Enter value of λ" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Service Rate</label>
                <input type="number" step="0.001" name="service-rate" class="form-control" id="formGroupExampleInput2" placeholder="input value of µ" required>
            </div>
                <input type="hidden" name="capacity" value="{{$capacity}}">
            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif($pattern == 'random' && $system == 'M/M/C'){{--  Model1 M/M/C  --}}
        <form action="systemFour/store" method="POST">
            @csrf

            <div class="form-group">
                <input type="hidden" name="servers" value="{{$servers}}">
                <label for="formGroupExampleInput2">Arrive Rate</label>
                <input type="number" step="0.001" name="arrive-rate" class="form-control" id="formGroupExampleInput2" placeholder="Enter value of λ" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Service Rate</label>
                <input type="number" step="0.001" name="service-rate" class="form-control" id="formGroupExampleInput2" placeholder="input value of µ" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>
{{----------------------------------------------------------------------------------------------------------------------}}
{{----------------------------------------------------------------------------------------------------------------------}}
    @elseif($pattern == 'random' && $system == 'M/M/C/K'){{--  Model1 M/M/C/K  --}}
        <form action="systemFive/store" method="POST">
            @csrf
            M/M/C/K
            <div class="form-group">
                <label for="formGroupExampleInput2">Arrive Rate</label>
                <input type="number" step="0.001" name="arrive-rate" class="form-control" id="formGroupExampleInput2" placeholder="Enter value of λ" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Service Rate</label>
                <input type="number" step="0.001" name="service-rate" class="form-control" id="formGroupExampleInput2" placeholder="input value of µ" required>
            </div>
            <input type="hidden" name="servers" value="{{$servers}}">
            <input type="hidden" name="capacity" value="{{$capacity}}">
            <div class="form-group">
                <button class="btn btn-primary " type="submit" style="width: 100%;">Submit </button>
            </div>
        </form>

    @endif
@include("temp.footer")






