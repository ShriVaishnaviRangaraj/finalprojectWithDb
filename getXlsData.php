<?php
require "vendor/autoload.php";
require 'getGeocode.php';
require 'getUserId.php';
require 'sendMail.php';
require 'updateDb.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function getXlData()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1','DATE :');
    $sheet->setCellValue('B1',strval(date("d-m-Y")));
    $sheet->setCellValue('B3','LATITUDE , LONGITUDE');
    $sheet->setCellValue('E1','To Get The Best Route to The Location Search With The Latitude & Longitude In Google Map :)');
    $sheet->setCellValue('G3','ADDRESS');

    $directory ="G:/My Drive/Attachments-Trash";
    $images = glob("$directory/*.{jpg,png,bmp,jpeg,mp4}", GLOB_BRACE);
    $SNo=0;
    $CurrVal=5;
    $set = new \Ds\Set();
    foreach($images as $image)
    {
        $myFile = pathinfo($image);
        $filename=$myFile['basename'];
        $filedate=strval(date("d-m-Y",filemtime($image)));
        $currdate=strval(date("d-m-Y"));

        if($filedate==$currdate)
        {
            $usermail=get_user_mail($filename);
            $imgLocation = get_image_location($image);
            if(!empty($imgLocation))
            {
                $imgLat = $imgLocation['latitude'];
                $imgLng = $imgLocation['longitude'];
                //echo $imgLat." ".$imgLng;

                $curl = curl_init('https://us1.locationiq.com/v1/reverse.php?key=pk.a362c2ec6329eebcc272579161eb2750&lat='.$imgLat.'&lon='.$imgLng.'&format=json');

                curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER    =>  true,
                CURLOPT_FOLLOWLOCATION    =>  true,
                CURLOPT_MAXREDIRS         =>  10,
                CURLOPT_TIMEOUT           =>  30,
                CURLOPT_CUSTOMREQUEST     =>  'GET',
                ));

                $response = curl_exec($curl);
                $data=json_decode($response,true);
                $err = curl_error($curl);
                curl_close($curl);

                if($err) 
                {
                    echo '<h5 style="color:Red; font-family:cursive">Address not found for given GeoCodes OR Check your connection properly...</h5> ';
                    //echo "cURL Error #:" . $err;
                }
                $address=$data['display_name'];

                $latLong=$imgLat.','.$imgLng;
                if(!($set->contains($latLong)))
                {
                    $sheet->setCellValue('A'.$CurrVal,++$SNo.'. ');
                    $sheet->setCellValue('B'.$CurrVal,$latLong);
                    $sheet->setCellValue('G'.$CurrVal,$address);
                    $CurrVal++;
                    $set->add($latLong);
                }
                updateToDb($usermail,$imgLat,$imgLng,$address,$image);
            }
            else
            {
                replyMail($usermail,$image);
            }
                
        }
    
        
    }

    if($set->isEmpty())
    {
        echo '<h5 style="color:Blue; font-family:cursive"> No Complaints Today </h5>';
    }
    else
    {
        $writer = new Xlsx($spreadsheet);
        $writer->save(strval(date("d-m-Y")).'.xlsx');
        sendEmail(); 
    }
}
?>