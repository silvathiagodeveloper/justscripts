<?php
$image = [  'w','s','w','w','w','w',
			's','s','s','w','w','w',
			'w','w','w','w','s','w',
			'w','s','w','w','s','w',
			'w','s','s','w','w','w',
			'w','s','s','w','w','s'];
			
function normalize(array $source, int $height, int $width) {
	$tam = sqrt(count($source));
	if(count($source) != $height*$width) {
		throw new Exception('Invalid Source Size');
	}
	$matrix = [];
	$j = -1;
	$i = -1;
	foreach($source as $index => $value){
		if($index%$height == 0) {
			$j = -1;
			$i++;
		}
		$j++;
		$matrix[$i][$j]['value'] = $value;
		$matrix[$i][$j]['visited'] = false;
	}
	return $matrix;
}

function test(array &$matrix, $posi, $posj){
	if(!isset($matrix[$posi][$posj]['visited']) || $matrix[$posi][$posj]['visited'] || $matrix[$posi][$posj]['value'] == 'w') {
		return 0;
	}
	if($matrix[$posi][$posj]['value'] == 's') {
		$matrix[$posi][$posj]['visited'] = true;
		$tam = 1 + test($matrix, $posi+1, $posj);
		$tam += test($matrix, $posi-1, $posj);
		$tam += test($matrix, $posi, $posj+1);
		$tam += test($matrix, $posi, $posj-1);
	}
	return $tam;
}

function search(array &$matrix){
	$maior = 0;
	$count = 0;
	for($i = 0; $i < count($matrix); $i++) {
		for($j = 0; $j < count($matrix[$i]); $j++) {
			if($matrix[$i][$j]['value'] == 's' && !$matrix[$i][$j]['visited']) {
				$tam = test($matrix, $i, $j);
				if($tam > $maior) {
					$maior = $tam;
				}
				$count++;
			}
			echo $matrix[$i][$j]['value'];
		}
		echo "\n";
	}
	return [$maior, $count];
}

$matrix = normalize($image, 6, 6);
$result = search($matrix);
echo "maior".$result[0];
echo " count".$result[1];
