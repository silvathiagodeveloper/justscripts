<?php
$image = [  'w','s','w','w','w','w',
			's','s','s','w','w','w',
			'w','w','w','w','s','w',
			'w','s','w','w','s','w',
			'w','s','s','w','w','w',
			'w','s','w','w','w','s'];
			
function normalize($image) : array
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
	$queue = [$position];
	$count = 0;	
	while(!empty($queue)) {
		$pos = array_pop($queue);
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

$graph = normalize($image);

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