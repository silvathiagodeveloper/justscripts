<?php
$image = [  'w','s','w','w','w','w',
			's','s','s','w','w','w',
			'w','w','w','w','s','w',
			'w','s','w','w','s','w',
			'w','s','s','w','w','w',
			'w','s','w','w','w','s'];
			
function normalize(array $source, int $height, int $width) {
	$graph = [];
	$line = [];
	if(count($source) != $height * $width) {
		throw new Exception('Invalid Source Size');
	}

	foreach($source as $key => $node) {
		$line[] = [
			'node' => $node,
			'visited' => false
		];
		if(($key+1)%$width == 0) {
			$graph[] = $line;
			$line = [];
		}
	}
	return $graph;
}

function printGraph($graph){
	foreach($graph as $line) {
		foreach($line as $node) {
			echo "{$node['node']} ";
		}
		echo "\n";
	}
}

function depthSearch(&$graph, $y, $x){
	$stack[] = ['y' => $y, 'x' => $x];
	$size = 0;
	while(!empty($stack)) {
		$node = array_pop($stack);
		if(!isset($graph[$node['y']][$node['x']]) || $graph[$node['y']][$node['x']]['visited']) {
			continue;
		}
		if($graph[$node['y']][$node['x']]['node'] == 's') {
			$size++;
			$graph[$node['y']][$node['x']]['visited'] = true;
			array_push($stack,['y' => $node['y']+1, 'x' => $node['x']]);
			array_push($stack,['y' => $node['y']-1, 'x' => $node['x']]);
			array_push($stack,['y' => $node['y'],   'x' => $node['x']+1]);
			array_push($stack,['y' => $node['y'],   'x' => $node['x']-1]);
		}
	}
	return $size;
}

function breadthSearch(&$graph, $y, $x){
	$queue[] = ['y' => $y, 'x' => $x];
	$size = 0;
	while(!empty($queue)) {
		$node = array_shift($queue);
		if(!isset($graph[$node['y']][$node['x']]) || $graph[$node['y']][$node['x']]['visited']) {
			continue;
		}
		if($graph[$node['y']][$node['x']]['node'] == 's') {
			$size++;
			$graph[$node['y']][$node['x']]['visited'] = true;
			array_push($queue,['y' => $node['y']+1, 'x' => $node['x']]);
			array_push($queue,['y' => $node['y']-1, 'x' => $node['x']]);
			array_push($queue,['y' => $node['y'],   'x' => $node['x']+1]);
			array_push($queue,['y' => $node['y'],   'x' => $node['x']-1]);
		}
	}
	return $size;
}


$graph = normalize($image,6,6);
printGraph($graph);
$islands = [];
$timeStart = microtime(true);
foreach($graph as $y => $line) {
	foreach($line as $x => $node) {
		$size = depthSearch($graph, $y, $x);
		if($size > 0) {
			$islands[] = $size;
		}
	}
}
print_r($islands);
echo number_format((microtime(true) - $timeStart) *10000,5)."\n";
$graph = normalize($image,6,6);
$islands = [];
$timeStart = microtime(true);
foreach($graph as $y => $line) {
	foreach($line as $x => $node) {
		$size = breadthSearch($graph, $y, $x);
		if($size > 0) {
			$islands[] = $size;
		}
	}
}
print_r($islands);
echo number_format((microtime(true) - $timeStart) *10000,5)."\n";