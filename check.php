<?php
$json = '{
	"title": "PHP",
	"site": "GeeksforGeeks"
}';
$data = json_decode($json);
print_r($data);
echo $data->title;
echo "\n";
echo $data->site;
?>