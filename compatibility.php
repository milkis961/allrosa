<?php
function compatibility($myid, $otherid, $connect){
    $command = "select que_id, answer from empl_quest where empl_id='$myid' order by que_id";
    $query = pg_query($connect, $command);
    $myanswers = pg_fetch_all($query);
    $command = "select que_id, answer from empl_quest where empl_id='$otherid' order by que_id";
    $query = pg_query($connect, $command);
    $otheranswers =  pg_fetch_all($query);
    $compatibility = 0;
    $_i = 0;
    $_j = 0;
    $_n = 0;
    while ($_i < sizeof($myanswers) and $_j < sizeof($myanswers)){   
        if($myanswers[$_i]['que_id'] == $otheranswers[$_j]['que_id'])
        {
            $q_id = $myanswers[$_i]['que_id'];
            if($myanswers[$_i]['answer'] == $otheranswers[$_j]['answer'])
                $compatibility += 1.0;
            $_n++;
            $_j++;
            $_i++;
        } 
        elseif ($myanswers[$_i]['que_id'] > $otheranswers[$_j]['que_id']) 
            $_j++;
        else 
            $_i++;
    }
    if($_n == 0)
        return 0;
    $compatibility /= $_n;
    return $compatibility;
}