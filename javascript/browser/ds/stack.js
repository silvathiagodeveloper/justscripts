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