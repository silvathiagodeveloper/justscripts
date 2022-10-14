class Stack {
    #mem = [];
    #capacity = 0;

    constructor(capacity) {
        this.#capacity = capacity;
    }

    push(value) {
        if(this.#mem.length >= this.#capacity) {
            throw 'Stack overflow';
        } else {
            this.#mem.push(value);
        }
    }

    pop() {
        if(this.#mem.length <= 0) {
            throw 'Out of range';
        }
        return this.#mem.pop();
    }

    peek() {
        return this.#mem.at(-1);
    }

    isEmpty() {
        return this.#mem.length <= 0;
    }

    capacity() {
        return this.#capacity;
    }

    count() {
        return this.#mem.length;
    }

    toArray() {
        return this.#mem;
    }
}

class Calculator {   
    #stackLimit = 50;

    constructor(stackLimit) {
        this.#stackLimit = stackLimit;
    }

    #simpleCalculate(a, operator, b) {
        switch(operator) {
            case '+': return parseFloat(a) + parseFloat(b); break;
            case '-': return parseFloat(a) - parseFloat(b); break;
            case '*': return parseFloat(a) * parseFloat(b); break;
            case '/': return (parseFloat(a) / parseFloat(b)).toFixed(4); break;
            default : throw 'Operator unknow';
        }
    }

    #isNumber(str) {
        if (typeof str != "string" && typeof str != "number") {
            return false;
        }
        return !isNaN(str) && !isNaN(parseFloat(str));
    }

    calculate(input) {
        let stack = new Stack(this.#stackLimit);
        let openDelimitetor = ['{','[','('];
        let closeDelimitetor = ['}',']',')'];
        let num = '';
        let a = '';
        let b = '';
        let operator = '';
        for(let indexInput = 0; indexInput < input.length; indexInput++ ) {
            let element = input[indexInput];
            if ("0123456789.".includes(element)) {
                num = "" + num + element;
            } else {
                if ("{[(/*-+".includes(element)) {
                    if(num != '') {
                        if(stack.peek() == '*' || stack.peek() == '/') {
                            operator = stack.pop();
                            stack.push(this.#simpleCalculate(stack.pop(), operator, num));
                        } else {
                            stack.push(num);
                        }
                        num = '';
                    }
                    if((stack.isEmpty() || !this.#isNumber(stack.peek())) && (element == '-' || element == '+')) {
                        num = "" + num + element;
                    } else {
                        stack.push(element);
                    }
                } else {
                    if ("}])".includes(element)) {
                        for(let i =0; i<3; i++) {
                            if (closeDelimitetor[i].includes(element)) {
                                while(stack.peek() != openDelimitetor[i]) {
                                    operator = stack.pop();
                                    num = this.#simpleCalculate(stack.pop(), operator, num);
                                }
                                stack.pop();
                                break;
                            }
                        }
                    } else {
                        console.log(element + ' is a unknow character and was discarted');
                    }
                }
            }
        }
        if(num != '') {
            stack.push(num);
        }
        if(stack.isEmpty()) {
            return 0;
        }
        if(!this.#isNumber(stack.peek())) {
            throw 'Equation unknow';
        }
        while(stack.count() > 1) {
            b = stack.pop();
            operator = stack.pop();
            stack.push(this.#simpleCalculate(
                !stack.isEmpty() ? stack.pop() : 0, 
                operator, 
                b
            ));
        }
        return parseFloat(stack.pop());
    }
}

var calculator = new Calculator(50);
try {
    console.log(calculator.calculate('{-2*[3*(4*(5+1.1-5.3)+3)+1]-10}/2'));
} catch(err) {
    console.log(err);
}