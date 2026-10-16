const result = 2 ** 3 ** 2;

console.log(result); // 512

First, JavaScript evaluates 3 ** 2, which equals 9,
then, it evaluates 2 ** 9, which equals 512.

---

usa ++ o -- al inicio del valor para ejecutar el +1 o -1 de forma inmediata

let x = 5;
console.log(--x); // 4
console.log(x); // 4

let y = 5;
console.log(y--); // 5
console.log(y); // 4

---

Which two operators in JavaScript avoid type coercion? === and !==

---

A truthy value is a value that evaluates to true in a boolean context. Examples of truthy values are:

- Non-empty strings
- Non-zero numbers
- The boolean true

You can use the Boolean() function to check the truthiness of a value.
Boolean("Hello World!") will return true

---

Bitwise operators are often used in low-level programming and cryptography.
Bits and Binary

Bitwise operators in JavaScript are special operators that work on the binary representations of numbers. To understand bitwise operators, we first need to grasp the concept of bits and binary numbers. In computing, a bit is the most basic unit of information. It can have only two values: 0 or 1. Binary is a number system that uses only these two digits to represent all numbers.
Binary Example

For example, the binary representation of the decimal number 10 is 1010. In this system, each digit represents a power of 2, starting from the rightmost digit and increasing as we move left.
1 0 1 0
1 · 23 0 · 22 1 · 21 0 · 20
8 0 2 0

In the table above, the first row shows the binary number 1010, the second row shows the power of 2 represented by each binary position, and the third row shows the result of each multiplication. If you add all the values in the third row, they total 10.
Bitwise Operators Overview

Now, let's dive into bitwise operators. These operators perform operations on the binary representations of numbers. JavaScript provides several bitwise operators, including AND (&), OR (|), XOR (^), NOT (~), left shift (<<), and right shift (>>).
Bitwise AND

The bitwise AND (&) operator returns a 1 in each bit position for which the corresponding bits of both operands are 1. Here's an example:

let a = 5; // Binary: 101
let b = 3; // Binary: 011
console.log(a & b); // 1 (Binary: 001)

In this example, we perform a bitwise AND operation on 5 (101 in binary) and 3 (011 in binary). The result is 1 (001 in binary) because only the rightmost bit is 1 in both numbers.
Bitwise OR

The bitwise OR (|) operator returns a 1 in each bit position for which the corresponding bits of either or both operands are 1. For example:

let a = 5; // Binary: 101
let b = 3; // Binary: 011
console.log(a | b); // 7 (Binary: 111)

Here, the result is 7 (111 in binary) because at least one of the bits is 1 in each position.
Bitwise XOR

The bitwise XOR (^) operator returns a 1 in each bit position for which the corresponding bits of either, but not both, operands are 1. For instance:

let a = 5; // Binary: 101
let b = 3; // Binary: 011
console.log(a ^ b); // 6 (Binary: 110)

The result is 6 (110 in binary) because the first and second bits from the right are different in the two numbers.
Bitwise NOT

The bitwise NOT (~) operator inverts all the bits of its operand. For example:

let a = 5; // Binary: 101
console.log(~a); // -6

This might seem surprising, but it's because of how negative numbers are represented in binary using two's complement.
Left Shift

The left shift (<<) operator shifts all bits to the left by a specified number of positions. For example:

let a = 5; // Binary: 101
console.log(a << 1); // 10 (Binary: 1010)

Here, all bits are shifted one position to the left, effectively multiplying the number by 2.
Right Shift

The right shift (>>) operator shifts all bits to the right. For example:

let a = 5; // Binary: 101
console.log(a >> 1); // 2 (Binary: 10)

Here, all bits are shifted one position to the right, effectively dividing the number by 2 and rounding down.
