<?php
#systemy.net <3

header('Content-Type: application/json');

$player = $_GET['player'] ? $_GET['player'] : exit();

if (!preg_match("/^[A-Za-z0-9_-]{3,16}$/", $player)) {
	exit(json_encode(array('status' => 'errorUsername')));
}

for ($i = 1; $i < 10; $i++) :

	$proxies = array(
		0 => array(
			'ip' => '77.252.26.69:36006',
			'country' => 'Poland',
		),
		1 => array(
			'ip' => '185.16.34.190:55105',
			'country' => 'Poland',
		),
		2 => array(
			'ip' => '81.190.208.52:59881',
			'country' => 'Poland',
		),
		3 => array(
			'ip' => '77.252.26.69:36006',
			'country' => 'Poland',
		),
		4 => array(
			'ip' => '109.87.193.112:55924',
			'country' => 'Ukraine',
		),
		5 => array(
			'ip' => '188.191.31.135:41258',
			'country' => 'Ukraine',
		),
		6 => array(
			'ip' => '212.1.109.155:55248',
			'country' => 'Ukraine',
		),
		7 => array(
			'ip' => '212.1.109.155:55248',
			'country' => 'Ukraine',
		),
	);

	if (isset($proxies)) {
		$proxy = $proxies[array_rand($proxies)];
	}

	$ch = curl_init();

	if (isset($proxy)) {
		curl_setopt($ch, CURLOPT_PROXY, $proxy['ip']);
	}

	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_URL, 'https://api.mojang.com/users/profiles/minecraft/' . $player);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	
	$result = json_decode(curl_exec($ch));
	
	if (curl_exec($ch) != false) {
		$array = array(
			'status' => 'success',
			'id' => $result->id,
			'name' => $result->name,
			'try' => $i,
			'tryMax' => 10,
			'country' => $proxy['country'],
		);
		
		$i = 10;
		exit(json_encode($array));
	} else {
		if ($i == 10) {
			exit(json_encode(array('status' => 'errorRequests')));
		}
	}
	curl_close($ch);
	
endfor;
