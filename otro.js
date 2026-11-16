//dentro de .findIndex se coloca una function, no un valor solo

//order un array 
// luego indica el index que ocuparia ese numero en el array ordenado
function getIndexToIns(array, number) {
  //coloca el numero
  array.push(number)
  //ordena asc
  let ordered = array.sort((a, b) => a - b);
  console.log(ordered)
  return ordered.findIndex((item) => item === number) //porque?


}


getIndexToIns([1, 2, 3, 4], 1.5) //should return 1 because 1.5 is greater than 1 (index 0) and less than 2 (index 1).
getIndexToIns([20, 3, 5], 19) //should return 2 because after sorting to [3, 5, 20], 19 is less than 20 (index 2) and greater than 5 (index 1).



function isPrime(element, index, array) {
  var start = 2;
  while (start <= Math.sqrt(element)) {
    if (element % start < 1) {
      return false;
    } else {
      start++;
    }
  }
  return element > 1;
}

console.log([4, 6, 8, 12].findIndex(isPrime)); // -1, no encontrado
console.log([4, 6, 7, 12].findIndex(isPrime)); // 2





// you should have a smallestCommons function that accepts an array of two numbers as an argument.
// The smallestCommons function should return the smallest common multiple that is evenly divisible by both numbers and all sequential numbers in the range between them.
// The function should handle input where the two numbers are not in numerical order.

// si es [1,5] returna el menor numero que sea multiplo tanto de 1, como de 2,3 y 4 y 5.
//multiplico todo 
//luego intento dividirlo entre numeros no primos (2,3,)
function smallestCommons(items) {
  if (!Array.isArray(items) || items.length !== 2) {
    return
  }


  let ordered = items.sort((a, b) => a - b);
  let res = 1;

  let numeros = [];
  let aMultiplicar = []

  for (let i = ordered[0]; i <= ordered[1]; i++) {
    numeros.push(i)
  }


  aMultiplicar = numeros.filter((num, index, arr) => {
    // Verificamos si existe algún otro número (en distinta posición) que sea divisor de 'num'
    const esDivisorDeOtro = arr.some((otroNum, otroIndex) => {
      return index !== otroIndex && otroNum % num === 0;
    });

    // Conservamos el número solo si NO es DIVISOR de otro
    return !esDivisorDeOtro;
  });



  console.log({ aMultiplicar })


  aMultiplicar.forEach(item => {
    res *= item
    console.log({ res })

  });


  console.log({ res })
  return res;
}

smallestCommons([2, 10]) //should return 2520.
smallestCommons([1, 13]) //should return 360360.
smallestCommons([23, 18]) //should return 6056820.

// algoritmo de Euclides