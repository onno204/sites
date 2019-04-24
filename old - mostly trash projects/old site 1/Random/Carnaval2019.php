<style>
    .Timediv{
        height: 76vh;
    }
    .Time{
        display: inline-block;
        font-size: 20vh;
        padding: 10px;
        padding-top: 0px;
        padding-bottom: 20px;
        background-color: rgba(100,200,100,0.5);
        border-style: none;
        border-width: 2vh;
        margin-right: 10px;
        position: relative;
    }
    .Time::after{
        border-top-style: solid;
        border-top-width: 5px;
        border-top-color: rgba(100, 200, 100, 0.9);
        margin-top: 10px;
        font-size: 5vh;
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
    }
    .Days::after{
        content: "Days";
    }
    .Weeks::after{
        content: "Weeks";
    }
    .Hours::after{
        content: "Hours";
    }
    .Minutes::after{
        content: "min";
    }
    .Seconds::after{
        content: "sec";
    }
</style>
<script>
var end = new Date('2019-03-05 00:00:00');

    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {

            clearInterval(timer);
            document.getElementById('countdown').innerHTML = 'EXPIRED!';

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        //document.getElementById('countdown').innerHTML = days + 'days ';
        //document.getElementById('countdown').innerHTML += hours + 'hrs ';
        //document.getElementById('countdown').innerHTML += minutes + 'mins ';
        console.log(days.toString().length);
        console.log(days.toString().length < 2);
        $(".Days").text((days.toString().length < 2) ? ("0" + days) : days );
        $(".Hours").text((hours.toString().length < 2) ? ("0" + hours) : hours );
        $(".Minutes").text((minutes.toString().length < 2) ? ("0" + minutes) : minutes );
        $(".Seconds").text((seconds.toString().length < 2) ? ("0" + seconds) : seconds );
    }

    timer = setInterval(showRemaining, 1000);
</script>

<?php
$now = new DateTime();
$future_date = new DateTime('2019-03-05 00:00:00');
$interval = $future_date->diff($now);

//echo $interval->format("%a days, %H hours, %I minutes, %S seconds");
?>
<div class="Timediv">
    <div class="Time Days"><?php echo $interval->format("%a"); ?></div>
    <!-- <div class="Time Weeks"><?php echo floor($interval->format("%a")/7); ?></div> -->
    <div class="Time Hours"><?php echo $interval->format("%H"); ?></div>
    <div class="Time Minutes"><?php echo $interval->format("%I"); ?></div>
    <div class="Time Seconds"><?php echo $interval->format("%S")+2; ?></div>
</div>

