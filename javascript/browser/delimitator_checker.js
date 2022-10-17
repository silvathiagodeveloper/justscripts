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