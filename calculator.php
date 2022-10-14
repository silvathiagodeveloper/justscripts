<?php
	class Stack {
		private array $mem = [];
		private int $capacity = 0;

		function __construct($capacity) {
			$this->capacity = $capacity;
		}

		public function push($value) {
			if(count($this->mem) >= $this->capacity) {
				throw new Exception('Stack overflow');
			} else {
				array_push($this->mem, $value);
			}
		}

		public function pop() {
			if(count($this->mem) <= 0) {
				throw 'Out of range';
			}
			return array_pop($this->mem);
		}

		public function peek() {
			return end($this->mem);
		}

		public function isEmpty() {
			return count($this->mem) <= 0;
		}

		public function capacity() {
			return $this->capacity;
		}

		public function count() {
			return count($this->mem);
		}

		public function toArray() {
			return $this->mem;
		}
	}

	class Calculator {   
		private int $stackLimit = 50;

		function __construct($stackLimit) {
			$this->$stackLimit = $stackLimit;
		}

		private function simpleCalculate($a, $operator, $b) {
			switch($operator) {
				case '+': return $a + $b; break;
				case '-': return $a - $b; break;
				case '*': return $a * $b; break;
				case '/': return round($a / $b, 4); break;
				default : throw new Exception('Operator unknow');
			}
		}

		public function calculate($equation) {
			$stack = new Stack($this->stackLimit);
			$openDelimitetor = ['{','[','('];
			$closeDelimitetor = ['}',']',')'];
			$num = '';
			$a = '';
			$b = '';
			$operator = '';
			for($indexInput = 0; $indexInput < strlen($equation); $indexInput++ ) {
				$element = $equation[$indexInput];
				if (!(strpos("0123456789.",$element)===false)) {
					$num = $num . $element;
				} else {
					if (!(strpos("{[(/*-+",$element)===false)) {
						if($num != '') {
							if($stack->peek() == '*' || $stack->peek() == '/') {
								$operator = $stack->pop();
								$stack->push($this->simpleCalculate($stack->pop(), $operator, $num));
							} else {
								$stack->push($num);
							}
							$num = '';
						}
						if(($stack->isEmpty() || !is_numeric($stack->peek())) && ($element == '-' || $element == '+')) {
							$num = $num . $element;
						} else {
							$stack->push($element);
						}
					} else {
						if (!(strpos("}])",$element)===false)) {
							for($i =0; $i<3; $i++) {
								if (!(strpos($closeDelimitetor[$i],$element)===false)) {
									while($stack->peek() != $openDelimitetor[$i]) {
										$operator = $stack->pop();
										$num = $this->simpleCalculate($stack->pop(), $operator, $num);
									}
									$stack->pop();
									break;
								}
							}
						} else {
							print_r($element . " is a unknow character and was discarted\n");
						}
					}
				}
			}
			if($num != '') {
				$stack->push($num);
			}
			if($stack->isEmpty()) {
				return 0;
			}
			if(!is_numeric($stack->peek())) {
				throw new Exception('Equation unknow');
			}
			while($stack->count() > 1) {
				$b = $stack->pop();
				$operator = $stack->pop();
				$stack->push($this->simpleCalculate(
					!$stack->isEmpty() ? $stack->pop() : 0, 
					$operator, 
					$b
				));
			}
			return $stack->pop();
		}
	}

	$calculator = new Calculator(50);
	try {
		print_r($calculator->calculate('{-2*[3*(4*(5+1.1-5.3)+3)+1]-10}/2'));
	} catch(Exception $e) {
		print_r($e->getMessage());
	}
?>