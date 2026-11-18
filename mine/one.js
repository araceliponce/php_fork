
//si el segundo param es === 0 entonces repite la misma operacion infinitamente hasta que segundo param deje de ser === 0, 
// cuando deje de ser ===0 , res = 1er param
const gcd = (a, b) => (b === 0 ? a : gcd(b, a % b));

console.log(gcd(24, 48))

//si te pasan un array de 2 numeros, los ordenas y luego obtienes el menor multiplo de los numeros. por ejm [5,1] debe encontrar el menor multiplo comun de 1,2,3,4,5
function smallestCommons(array) {
  if (!array.length == 2) return;

  const [min, max] = array.sort((a, b) => (a - b))
  // console.log(array)

  // greatest common divisor
  const gcd = (a, b) => (b === 0 ? a : gcd(b, a % b));

  //menor mutliplo de dos numeros /se divide continuamente entre si
  const lcm = (a, b) => (a * b) / gcd(a, b);
  // Start with the smallest number and find the running LCM up to the max
  let multiple = min;
  for (let i = min + 1; i <= max; i++) {
    multiple = lcm(multiple, i);
  }

  return multiple ?? 0;

}



console.log(smallestCommons([1, 5]))




let array = [
  [1, 2, 3],
  [4, 5, 6],
  [7, 8, 9],
  [8, 8, 9]
];

let arrayCombinado = []


//combina en un array plano
array = array.reduce((a, b) => a.concat(b), []);


//ordena desc
array.sort((a, b) => b - a)



console.log(array[0])


// console.log({ bigger })
