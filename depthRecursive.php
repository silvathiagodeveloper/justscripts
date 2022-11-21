<?php
$data = [
		['A', 'B'],
		['A', 'D'],
		['B', 'C'],
		['B', 'D'],
		['D', 'E']
	];

function normalize($data) {
	$result = [];
	foreach($data as $element) {
		if(!isset($result[$element[0]])) {
			$result[$element[0]] = [];
		}
		$result[$element[0]][] = $element[1];
	}
	print_r($result);
	return $result;
}

function deepPrint($data, $start, &$visited){
	echo $start;
	if(empty($data[$start])) {
		return false;
	}
	foreach($data[$start] as $element) {
		if(!$visited[$element]) {
			$visited[$element] = true;
			deepPrint($data, $element, $visited);
		}
	}
}

function deepSearch($data, $start, $find, &$visited){
	if($start == $find) {
		return true;
	}
	if(empty($data[$start])) {
		return false;
	}
	foreach($data[$start] as $element) {
		if(!$visited[$element]) {
			$visited[$element] = true;
			$result = deepSearch($data, $element, $find, $visited);
			if($result) {
				return true;
			}
		}
	}
	return false;
}

$data_n = normalize($data);
foreach ($data_n as $index => $elements) {
	$visited[$index] = false;
	foreach ($elements as $element) {
		$visited[$element] = false;
	}
}

//foreach ($data_n as $index => $element) {
//print_r(deepPrint($data_n, 'A', $visited));
if(deepSearch($data_n, 'A', 'D', $visited)) {
	echo 'Found!';
} else {
	echo 'Not found';
}
//}