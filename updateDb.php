<?php
function updateToDb($usermail='',$imgLat='',$imgLng='',$address='',$image='')
{
    require 'connection.php';
    $user_id_result = getUserID($usermail);
    if(mysqli_num_rows($user_id_result) == 1)
    {
        $row = $user_id_result->fetch_assoc();
        $user_id=$row["user_id"];
        //$user_id=strval($user_id);
        $time_update="update user_info set lastreceivedtime=now() where user_id=$user_id";
        $time_update_result=mysqli_query($con,$time_update) or die(mysqli_error($con));
        updateUserLocation($row["user_id"], $imgLat, $imgLng, $address, $image);
    }
    else if(mysqli_num_rows($user_id_result) == 0)
    {
        $put_user_info = "insert into user_info(mail_id) values('$usermail')";
        $user_info_result = mysqli_query($con,$put_user_info) or die(mysqli_error($con));
        $user_id_result = getUserID($usermail);
        $row = $user_id_result->fetch_assoc();
        updateUserLocation($row["user_id"], $imgLat, $imgLng, $address, $image);
    }
}

function getUserID($usermail = '')
{
    require 'connection.php';
    $get_user_id = "select user_id from user_info where mail_id='$usermail'";
    $user_id_result=mysqli_query($con,$get_user_id) or die(mysqli_error($con));
    return $user_id_result;
}

function updateUserLocation($user_id, $imgLat = '', $imgLng = '', $address = '', $image = '')
{
    require 'connection.php';
    $get_location_id="select location_id from location_info where latitude='$imgLat' and longitude='$imgLng'";
    $location_id_result=mysqli_query($con,$get_location_id) or die(mysqli_error($con));
    if(mysqli_num_rows($location_id_result) == 1) 
    {
        //echo $user_id;
        $row=$location_id_result->fetch_assoc();
        $location_id=$row["location_id"];
        $sql_update = "update location_info set user_id='$user_id' where location_id='$location_id'";
        //echo $address;
        $update_query=mysqli_query($con,$sql_update) or die(mysqli_error($con));
        doComplain($image,$location_id,$user_id);
    }
    else if(mysqli_num_rows($location_id_result) == 0)
    {
        //echo $user_id;
        // $imgLat=strval($imgLat);
        // $imgLng=strval($imgLng);
        // $address=strval($address);
        // echo $user_id;
        $set_location="insert into location_info(latitude,longitude,address,user_id) values($imgLat,$imgLng,'$address',$user_id)";
        $insert_location=mysqli_query($con,$set_location) or die(mysqli_error($con));
        $last_id = $con->insert_id;
        doComplain($image,$last_id,$user_id);
    }
}

function doComplain($image='',$location_id='',$user_id='')
{
    require 'connection.php';
    $status=0;
    $date=date("Y-m-d");
    // $image=strval($image);
    $complain_query="insert into complaint_status(is_sent,is_cleaned,file_path,date_of_complaint,user_id,location_id) values($status,$status,'$image','$date',$user_id,$location_id)";
    $complain_query_result=mysqli_query($con,$complain_query) or die(mysqli_error($con));
}

?>
