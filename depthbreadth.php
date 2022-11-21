<?php
$data = [
		['A', 'B'],
		['A', 'D'],
		['B', 'C'],
		['B', 'D'],
		['D', 'E']
	];
	
/*$data = [
		['A', 'B'],
		['A', 'C'],
		['B', 'D'],
		['C', 'E'],
		['D', 'F']
	];*/

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

function createVisited($graph) {
	foreach ($graph as $index => $elements) {
		$visited[$index] = false;
		foreach ($elements as $element) {
			$visited[$element] = false;
		}
	}
	return $visited;
}

function depthPrint($graph, $start){
	$visited = createVisited($graph);
	$stack = [$start];
	while(!empty($stack)) {
		$current = array_pop($stack);
		if(!$visited[$current]) {
			$visited[$current] = true;
			echo $current;
			if(!empty($graph[$current])) {
				foreach($graph[$current] as $neighbor) {
					array_push($stack, $neighbor);
				}
			}
		}
	}
}

function depthSearch($graph, $start, $find) : bool {
	$visited = createVisited($graph);
	$count = 0;
	$stack = [$start];
	while(!empty($stack)) {
		$current = array_pop($stack);
		if($current == $find) {
			return true;
		}
		if(!$visited[$current]) {
			echo '.';
			$visited[$current] = true;
			if(!empty($graph[$current])) {
				foreach($graph[$current] as $neighbor) {
					array_push($stack, $neighbor);
				}
			}
		}
	}
	return [false];
}

function breadthPrint($graph, $start){
	$visited = createVisited($graph);
	$queue = [$start];
	while(!empty($queue)) {
		$current = array_shift($queue);
		if(!$visited[$current]) {
			$visited[$current] = true;
			echo $current;
			if(!empty($graph[$current])) {
				foreach($graph[$current] as $neighbor) {
					array_push($queue, $neighbor);
				}
			}
		}
	}
}

function breadthSearch($graph, $start, $find) : bool {
	$visited = createVisited($graph);
	$queue = [$start];
	while(!empty($queue)) {
		$current = array_shift($queue);
		if($current == $find) {
			return true;
		}
		if(!$visited[$current]) {
			echo '.';
			$visited[$current] = true;
			if(!empty($graph[$current])) {
				foreach($graph[$current] as $neighbor) {
					array_push($queue, $neighbor);
				}
			}
		}
	}
	return false;
}

$graph = normalize($data);

depthPrint($graph, 'A');
echo "\n";
breadthPrint($graph, 'A');
echo "\n";
if(depthSearch($graph, 'A', 'E'))
{
	echo 'E Found';
} else {
	echo ':(';
}
if(breadthSearch($graph, 'A', 'E'))
{
	echo 'E Found';
} else {
	echo ':(';
}





$image = [  'w','s','w','w','w','w',
			's','s','s','w','w','w',
			'w','w','w','w','s','w',
			'w','s','w','w','s','w',
			'w','s','s','w','w','w',
			'w','s','w','w','w','s'];
			
function normalize2($image) : array
{
	$graph = [];
	$line = [];
	$count = 0;
	foreach($image as $index => $node) {
		$line[] = $node;
		if(($index+1)%6 == 0) {
			$graph[] = $line;
			$line = [];
		}
	}
	return $graph;
}

function initVisited($count) : array
{
	$visited = [];
	for($y = 0; $y < $count; $y++) {
		for($x = 0; $x < $count; $x++) {
			$visited["{$y}_{$x}"] = false;
		}
	}
	return $visited;
}

function breadthCount($matrix, $position, &$visited) {
	$queue = [$position];
	$count = 0;	
	while(!empty($queue)) {
		$pos = array_shift($queue);
		if($pos['y'] >= 0 && $pos['y'] < count($matrix)) {
			if($pos['x'] >= 0 && $pos['x'] < count($matrix[$pos['y']])) {
				if(!$visited[$pos['y'].'_'.$pos['x']]) {
					if($matrix[$pos['y']][$pos['x']] == 's') {
						array_push($queue, ['x' => $pos['x'], 'y' => $pos['y']-1]);
						array_push($queue, ['x' => $pos['x'], 'y' => $pos['y']+1]);
						array_push($queue, ['x' => $pos['x']-1, 'y' => $pos['y']]);
						array_push($queue, ['x' => $pos['x']+1, 'y' => $pos['y']]);
						$count++;
						$visited[$pos['y'].'_'.$pos['x']] = true;
					}
				}
			}
		}
	}
	return $count;
}

function depthCount($matrix, $position, &$visited) {
	$stack = [$position];
	$count = 0;	
	while(!empty($stack)) {
		$pos = array_pop($stack);
		if($pos['y'] >= 0 && $pos['y'] < count($matrix)) {
			if($pos['x'] >= 0 && $pos['x'] < count($matrix[$pos['y']])) {
				if(!$visited[$pos['y'].'_'.$pos['x']]) {
					if($matrix[$pos['y']][$pos['x']] == 's') {
						array_push($stack, ['x' => $pos['x'], 'y' => $pos['y']-1]);
						array_push($stack, ['x' => $pos['x'], 'y' => $pos['y']+1]);
						array_push($stack, ['x' => $pos['x']-1, 'y' => $pos['y']]);
						array_push($stack, ['x' => $pos['x']+1, 'y' => $pos['y']]);
						$count++;
						$visited[$pos['y'].'_'.$pos['x']] = true;
					}
				}
			}
		}
	}
	return $count;
}

$graph = normalize2($image);

$visited = initVisited(count($graph[0])); //y_x
$islands = [];
$timeStart = microtime(true);
for($y = 0; $y < count($graph); $y++) {
	for($x = 0; $x < count($graph[$y]); $x++) {
		$count = depthCount($graph, ['x' => $x, 'y' => $y], $visited);
		if($count > 0) {
			$islands[] = $count;
		}
	}
}
print_r($islands);
echo number_format((microtime(true) - $timeStart) *10000,5);

$visited = initVisited(count($graph[0])); //y_x
$islands = [];
$timeStart = microtime(true);
for($y = 0; $y < count($graph); $y++) {
	for($x = 0; $x < count($graph[$y]); $x++) {
		$count = breadthCount($graph, ['x' => $x, 'y' => $y], $visited);
		if($count > 0) {
			$islands[] = $count;
		}
	}
}
print_r($islands);
echo number_format((microtime(true) - $timeStart) *10000,5);