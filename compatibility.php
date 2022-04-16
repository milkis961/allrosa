<?php
function compatibility($myid, $otherid, $connect){
    $command = "select que_id, answer from empl_quest where empl_id='$myid' order by que_id";
    $query = pg_query($connect, $command);
    $myanswers = pg_fetch_all( $query);
    $command = "select que_id, answer from empl_quest where empl_id='$otherid' order by que_id";
    $query = pg_query($connect, $command);
    $otheranswers =  pg_fetch_all( $query);
    
    // foreach ($myanswers as $my)
    //     echo $my['que_id']."-".$my['answer'];
    // foreach ($otheranswers as $my)
    //     echo $my['que_id']."-".$my['answer'];

    $common = array();
    $compatibility = 0;
    $_i = 0;
    $_j = 0;
    while ($_i < sizeof($myanswers)){
        if($myanswers[$_i]['que_id'] == $otheranswers[$_j]['que_id']){
            array_push($common, $myanswers[$_i]['que_id']);
            $_j++;
            $_i++;
        } 
        elseif ($myanswers[$_i]['que_id'] > $otheranswers[$_j]['que_id']) 
            $_j++;
        else 
        $_i++;
    }
    if(sizeof($common) == 0)
        return 0;
    $compatibility = 0;
    foreach ($common as $c){
//                echo "<p>".$myanswers[$c]['answer']." - ".$otheranswers[$c]['answer']."</p>";
        if($myanswers[$c]['answer'] == $otheranswers[$c]['answer'])
            $compatibility += 1.0;
    }
//            echo "<p>$compatibility</p>";

    $compatibility /= sizeof($common);
    return $compatibility;
}