class DelimitatorChecker {   
    #stackLimit = 50;

    constructor(stackLimit) {
        this.#stackLimit = stackLimit;
    }

    check(input) {
        let stack = new Stack(this.#stackLimit);
        let topo = '';
        if(input == '') {
            return false;
        }
        for(let indexInput = 0; indexInput < input.length; indexInput++ ) {
            let element = input[indexInput];
            //----remove to validate equations
            if(!'{}[]()'.includes(element)) {
                return false;
            }
            //----remove until here
            if('}])'.includes(element)) {
                if(stack.isEmpty()) {
                    return false;
                }
                topo = stack.peek();
                if(element == '}' && topo != '{') {
                    return false;
                }
                if(element == ')' && topo != '(') {
                    return false;
                }
                if(element == ']' && topo != '[') {
                    return false;
                }
            }
            if('{[('.includes(element)) {
                stack.push(element);
            } else {
                //if('}])'.includes(element)) { //---uncomment to validate equations
                stack.pop();
                //}  //---uncomment to validate equations
            }
        }
        return stack.isEmpty();
    }
}