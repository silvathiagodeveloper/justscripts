CONST MAX_DAY = 5;
CONST SHIFTS  = 2;

function week_validate($a) {
    return $a != SHIFTS;
}

function employee_validate($a) {
    return $a < MAX_DAY;
}

function CreatePossibilities($matrix, $week, $employees, $worker = 0) {
    $possibilities = [];
    $weekK = array_keys($week);
    $employeesK = array_keys($employees);
    foreach($week as $day => $status) {
       for($e = 0; $e < count($employees); $e++) {
           if($matrix[$day][$employeesK[$e]]) {
             for($e2 = $e+1; $e2 < count($employees); $e2++) {
                 if($matrix[$day][$employeesK[$e2]]) {
                     $possibilities[$day][] = [
                       'day' => $day,
                       'employee1' => $employeesK[$e],
                       'employee2' => $employeesK[$e2],
                     ];
                 }
             }
           }
       }
    }

    return $possibilities;
}

function AnalizePossibility($possibilities, $week, $employees) {
    for($p = 0; $p < count($possibilities); $p++) {
        if($employees[$possibilities[$p]['employee1']] < MAX_DAY && 
           $employees[$possibilities[$p]['employee2']] < MAX_DAY) {
            $employees[$possibilities[$p]['employee1']]++;
            $employees[$possibilities[$p]['employee2']]++;
            $week[$possibilities[$p]['day']] = SHIFTS;
            if(array_sum($week) == count($week)*SHIFTS) {
                return true;
            }
        }
    }

    return false;
}

function AnalizePossibilities($possibilities, $week, $employees, $weekIndex) {
    $weekK = array_keys($week);
    $employeesK = array_keys($employees);
    $possibility = [];
    foreach($week as $day => $status) {
        $possibility[] = $possibilities[$day][$weekIndex[$day]];
    }

    $result = AnalizePossibility($possibility, $week, $employees);
    if($result) {
        return true;
    } else {
        $dayIndex = count($week)-1;
        $weekIndex[$weekK[$dayIndex]]++;
        while($weekIndex[$weekK[$dayIndex]] >= count($possibilities[$weekK[$dayIndex]])) {
            $weekIndex[$weekK[$dayIndex]] = 0;
            $dayIndex--;
            if($dayIndex < 0) {
                return false;
            }
            $weekIndex[$weekK[$dayIndex]]++;
        }
        return AnalizePossibilities($possibilities, $week, $employees, $weekIndex);
    }
}

function schedulable(array $requests): bool {
    if(empty($requests)) {
        return false;
    }
    $week = ["mon" => 0, "tue" => 0, "wed" => 0, "thu" => 0, "fri" => 0, "sat" => 0, "sun" => 0];
    $weekIndex = [];
    $employees = [];
    $matrix = [];
  
    //Create a relationship Matrix
    foreach($requests as $employee => $days) {
        $employees[$employee] = 0;
        foreach($week as $day => $nothing) {
            if(empty($days)) {
                $matrix[$day][$employee] = 1;
            } else {
                $matrix[$day][$employee] = !in_array($day,$days) ? 1 : 0;
            }
        }
    }

   //Reduce array of possibilities for analize removing simple conditions
    foreach($matrix as $day => $available) {
        $workers = array_sum($available);
        if($workers < SHIFTS) {
            return false;
        } else {
            if($workers == SHIFTS) {
                foreach($available as $worker => $workAvailable) {
                    if($workAvailable) {
                        $week[$day] = $week[$day] + 1;
                        $employees[$worker] = $employees[$worker]+1;
                        if($employees[$worker]  > MAX_DAY) {
                            return false;
                        }
                    }
                }
            }
        }
    }
    if(array_sum($week) == count($week)*SHIFTS) {
        return true;
    } else {
        $weekFiltered = array_filter($week,'week_validate');
        foreach($weekFiltered as $day => $status) {  
            $weekIndex[$day] = 0;
        }
        $employeesFiltered = array_filter($employees,'employee_validate');
        $possibilities = CreatePossibilities($matrix, $weekFiltered, $employeesFiltered);
        return AnalizePossibilities($possibilities, $weekFiltered, $employeesFiltered, $weekIndex);
    }
}

function decode(string $roman): int {
    $roman_to_decimal = [
        'I' => 1,
        'V' => 5,
        'X' => 10,
        'L' => 50,
        'C' => 100,
        'D' => 500,
        'M' => 1000,
    ];

	$digits = str_split($roman);
	$lastIndex = count($digits)-1;
	$sum = 0;
    $index = 0;
	while($index < count($digits)) {
        $digit = $digits[$index];
		if(isset($roman_to_decimal[$digit])) {
            if($index < $lastIndex) {
                $left = $roman_to_decimal[$digits[$index]];
				$right = $roman_to_decimal[$digits[$index+1]];
				if($left < $right) {
					$sum += ($right - $left);
					$index = $index+2;
					continue;
				}
			}
		}
		$sum += $roman_to_decimal[$digit];
        $index++;
	}

	return $sum;
}

function int_to_numeral(int $num): string {
	$integers = [1000, 900, 500,  400, 100,  90,  50,   40,  10,    9,   5,    4,   1];
	$romans =   ['M', 'CM', 'D', 'CD', 'C', 'XC', 'L', 'XL', 'X', 'IX', 'V', 'IV', 'I'];
    $roman_number = '';
    $tmpNum = $num;
    $index = 0;
    while($tmpNum > 0) {
      $roman_number .= str_repeat($romans[$index], (int)floor($tmpNum / $integers[$index]));
      $tmpNum = (int)($tmpNum % $integers[$index]);
      $index++;
    }
    return $roman_number;
}