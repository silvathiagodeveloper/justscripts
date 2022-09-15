<?php
class Fly {
	public $origin;
	public $destiny;
	
	public function __construct($origin, $destiny) {
		$this->origin = $origin;
		$this->destiny = $destiny;
	}
}

$conections = [
		new Fly('FLS','CAM'),
		new Fly('FLS','GUA'),
		new Fly('PRT','BEL'),
		new Fly('GUA','LIS'),
		new Fly('GUA','PRT'),
		new Fly('CAM','LIS'),
		new Fly('LIS','PRT'),
		new Fly('LIS','MSC'),
		new Fly('MSC','PRT'),
		new Fly('BEL','FLS')
	];
	
function main(array $conections, Fly $search)
{
	$airports = [];
	$flys = [];
	foreach($conections as $fly) {
		if(!empty($airports[$fly->origin])) {
			$airports[$fly->origin][$fly->destiny] = 1;
		}else {
			$airports[$fly->origin] = [$fly->destiny => 1];
		}
	}
	print_r($airports);
	find($airports, $search, $flys, 0, $search->origin);
	print_r($flys);
}

function find(array $airports, Fly $search, array &$flys, int $coustMin, $family) {
	if(!empty($airports[$search->origin]) && !empty($airports[$search->origin][$search->destiny])) {
		if(empty($flys['conections']) || $flys['conections'] > $coustMin) {
			$flys['flys'] = $family.','.$search->destiny;
			$flys['conections'] = $coustMin;
		}
	}else {
		if(!empty($airports[$search->origin])) {
			foreach($airports[$search->origin] as $fly => $ct) {
				find($airports, new Fly($fly, $search->destiny), $flys, $coustMin+1, $family.','.$fly);
			}
		}
	}
}

main($conections, new Fly('FLS','BEL'));
?>
