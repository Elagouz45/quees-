<?php




        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $service_time = $_POST['service-time'];
            $interarrival_time = $_POST['interarrivale-time'];
            $servers = $_POST['server'];
            $queue = $_POST['queue'];

            
            $k = $queue + 1;
            $lamda = 1/$interarrival_time;
            $mue = 1/$service_time;

            $ti = ($k - ($mue/$lamda))/$lamda-$mue;

            $result = $k
            while($result >= k-1){
                $result = 
            }


        }





    ?>



    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <input type='text' name="service-time">
        <input type='text' name="interarrivale-time">
        <input type='text' name="server">
        <input type='text' name="queue">
        <input type="submit">
    </form>