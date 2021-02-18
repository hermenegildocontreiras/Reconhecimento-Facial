<?php

$data = json_decode(file_get_contents("php://input"));
	if(!isset($data->base_img)){
		die("{\"error\": \" Flopou. Cadê o base_img?\"}");
	}

	$result = [];
	$name = $data->foto+1; 
	if(!is_dir("reconhecimento/assets/lib/face-api/labels/{$data->nome}")){
		mkdir(__DIR__."/reconhecimento/assets/lib/face-api/labels/{$data->nome}", 0777, true);	
	}
	$path = "reconhecimento/assets/lib/face-api/labels/{$data->nome}/{$name}.jpg";
	
	//Save data
	file_put_contents($path, base64_decode($data->base_img));
	
	//Print Data
	$result['img'] = $path;
	$result['base64'] = $data->base_img;
	echo json_encode($result, JSON_PRETTY_PRINT);
?>


