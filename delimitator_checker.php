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

	class DelimitatorChecker {   
		private int $stackLimit = 50;

		function __construct($stackLimit) {
			$this->$stackLimit = $stackLimit;
		}

		public function check($input) {
			$stack = new Stack($this->stackLimit);
			if($input == '') {
				return false;
			}
			for($indexInput = 0; $indexInput < strlen($input); $indexInput++ ) {
				$element = $input[$indexInput];
				if(strpos('{}[]()',$element) === false) {
					return false;
				}
				if(!(strpos('}])',$element) === false)) {
					if($stack->isEmpty()) {
						return false;
					}
					$top = $stack->pop();
					if($element == '}' && $top != '{') {
						return false;
					}
					if($element == ']' && $top != '[') {
						return false;
					}
					if($element == ')' && $top != '(') {
						return false;
					}
				}
				if(!(strpos('{[(',$element) === false)) {
					$stack->push($element);
				}
			}
			return $stack->isEmpty();
		}
	}

	$delimitator = new DelimitatorChecker(50);
	try {
		print_r($delimitator->check('{[(())]}()()(())()[()()[()(())]]') ? 'Checked' : 'Not Checked');
	} catch(Exception $e) {
		print_r($e->getMessage());
	}
?>