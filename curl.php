<?php

	require_once('DbConnection.php');
	$api = new DbConnection;
	$db= $api->connect();
	
	
    $films = json_decode(file_get_contents('https://swapi.co/api/films'), true);
    $actor = json_decode(file_get_contents('https://swapi.co/api/people'), true);
    $sql ="";
    // $data = $films;
    // var_dump($films);die;
    foreach( $films['results'] as $data){
    	$sql = "INSERT INTO film(title, filmdate, opening_crawl) VALUES( '{$db->real_escape_string(htmlspecialchars($data['title']))}' , '{$db->real_escape_string(htmlspecialchars($data['release_date']))}', '{$db->real_escape_string(htmlspecialchars($data['opening_crawl']))}'); ";
    // 	break;
     $api->insert($sql);
    }
    
    foreach( $actor['results'] as $data){
        
	    $sql = "INSERT INTO actors (name, gender, height, mass, hair_color, skin_color, eye_color, birth)
		VALUES ('{$db->real_escape_string($data['name'])}', '{$db->real_escape_string($data['gender'])}', '{$db->real_escape_string($data['height'])}' , '{$db->real_escape_string($data['mass'])}' , '{$db->real_escape_string($data['hair_color'])}', '{$db->real_escape_string($data['skin_color'])}', '{$db->real_escape_string($data['eye_color'])}', '{$db->real_escape_string($data['birth_year'])}');";
		 $api->insert($sql);
    }
   
    
?>