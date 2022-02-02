<?php
function get_user_mail($filename='')
{
    $url='https://sheets.googleapis.com/v4/spreadsheets/14v6C6ZCR3bXf9d_Z_RucL0pmEfM9jrP_W9XVZghIJSg/values/ComplaintsInfo?alt=json&key=AIzaSyBcY9ZjTScoLqYBR0gGuPMA4w_HAGRmZVE';
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    $date=strval(date("d/m/Y"));
    $inct=1;
    $usermail="";
    $splitDate= explode (" ",($json_data["values"][$inct][0]));
    while($splitDate[0]==$date)
    {
        if($json_data["values"][$inct][4]==$filename)
        {
            $user=explode (" ",($json_data["values"][$inct][2]));
            $last=count($user)-1;
            $usermail=$user[$last];
            break;
        }
        
        $inct++;
        $splitDate= explode (" ",($json_data["values"][$inct][0]));
    }
    return $usermail;
}
?>