<?php

if(!isset($_SESSION)){
    session_start();
}
function find_with_id($list , $id , $key){
    foreach ($list as $l) {
        if ($l['id'] == $id) {
            return $l[$key];
        }
    }
}
function change_date($input){


    $year = substr($input , 0 , 4);
    $month = (substr($input , 5 , 2)<10)?substr($input , 6 , 1):substr($input , 5 , 2);
    $day =(substr($input , 8 , 2)<10)?substr($input , 9 , 1):substr($input , 8 , 2);
    
    $milady = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);

    $day_at_year =$milady[$month-1]+$day;

    $shamsi = array(21,51,80, 111, 142, 173, 204, 235, 266, 296, 326, 356);

    $shamsi_month = [
        "فروردین" ,
        "اردیبهشت",
        "خرداد",
        "تیر",
        "مرداد",
        "شهریور",
        "مهر",
        "آبان",
        "آذر",
        "دی",
        "بهمن",
        "اسفند"
    ];

    if($day_at_year < 21 or $day_at_year >= 356){
        $shamsi_m = 11;
        if($day_at_year < 20){
            $shamsi_d = 11 +$day_at_year;
        }else{
            $shamsi_d = $day_at_year - 355;
        }
    }else{
        for($j=1 ; $j<12 ;$j++){
            if($day_at_year < $shamsi[$j]){
                
                $shamsi_m =($j<3)?$j+10:$j-2;
                $shamsi_d =   $day_at_year - $shamsi[$j-1] +1;
                break;
                
            }
        }
    }
    $shamsi_m--;

    $shamsi_y =(($month==3 and $day>10)or($month>3))?$year - 621:$year -621;


    return "$shamsi_d $shamsi_month[$shamsi_m] $shamsi_y";
}
function go_back($i = -1){
    ?>
    <script>
        window.history.go(<?php echo $i;?>);
        location.reload();
    </script>
    <?php
}



?>