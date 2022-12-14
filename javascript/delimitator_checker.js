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

class DelimitatorChecker {   
    #stackLimit = 50;

    constructor(stackLimit) {
        this.#stackLimit = stackLimit;
    }

    check(input) {
        let stack = new Stack(this.#stackLimit);
        let top = '';
        if(input == '') {
            return false;
        }
        for(let indexInput = 0; indexInput < input.length; indexInput++ ) {
            let element = input[indexInput];
            if(!'{}[]()'.includes(element)) {
                return false;
            }
            if('}])'.includes(element)) {
                if(stack.isEmpty()) {
                    return false;
                }
                top = stack.pop();
                if(element == '}' && top != '{') {
                    return false;
                }
                if(element == ')' && top != '(') {
                    return false;
                }
                if(element == ']' && top != '[') {
                    return false;
                }
            }
            if('{[('.includes(element)) {
                stack.push(element);
            }
        }
        return stack.isEmpty();
    }
}

var checker = new DelimitatorChecker(50);
try {
    console.log(checker.check('{[(())]}()()(())()[()()[()(())]]') ? 'Checked' : 'Not Checked'); 
} catch(err) {
    console.log(err);
}