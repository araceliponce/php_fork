<?php


//tetraedron 
// de 2 = 2+1
//de 5 (contiene dentro uno de 3 y 1)
// de 6 (contiene dentro uno de 4 y uno de 2)


// tetra(2) ➞ 4
tetra(5); // 35;
// tetra(6) ➞ 56

function atetra($n)
{

  $totalExterior = 0;

  for ($i = $n; $i >= 0; $i--) {
    $totalExterior += $i;
  }

  //si el numero de esferas por lado es mayor que 3, enontrar cuantas pirmaides caben dentro
  $piramidesDentro = 0;
  if ($n > 3) {
    for ($i = $n; $i >= 0; $i - 2) {
      $piramidesDentro += 1;
    }
  }
  echo $totalExterior;
}



echo tetra(5); // debe devolver 35
function tetra($n)
{
  $total = 0;

  for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $i; $j++) {
      // Aquí puedes ir sumando las esferas
      $total += $j;
    }
  }

  return $total;
}




?>



// JAVASCRIPT
// The callback function in forEach can take up to 3 arguments: the current element, the index of the current element, and the array that forEach was called upon.

// Here's an example using all three:

// let numbers = [1, 2, 3, 4, 5];
// numbers.forEach((number, index, array) => {
// console.log(`Element ${number} is at index ${index} in array ${array}`);
// });





// What does a map method return?
// A new array with the same number of elements as the original.


<script>
  const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
  //filter = quiero mantener a los que cumplen cierta condicion
  // si ninguno cumple retorna []
  //it doesnt affect de original array at all
  const evenNumbers = numbers.filter(n => n % 2 === 0);
  console.log({
    evenNumbers
  })
</script>


<script>
  // reduce because it reduces an array to a single output. 2 main params
  // accumulator is where you store the running result of the operations
  // current value is the current array element being processed.


  const minIncomeForDuplex = 60000;
  const minCreditScoreForDuplex = 700;

  const minIncomeForCondo = 45000;
  const minCreditScoreForCondo = 680;

  const minIncomeForCar = 30000;
  const minCreditScoreForCar = 650;

  function getLoanMessage(annualIncome, creditScore) {
    if (creditScore >= minCreditScoreForDuplex && annualIncome >= minIncomeForDuplex) {
      return "You qualify for a duplex, condo, and car loan.";
    } else if (annualIncome >= minIncomeForCondo && creditScore >= minCreditScoreForCondo) {
      return "You qualify for a condo and car loan.";
    } else if (annualIncome >= minIncomeForCar && creditScore >= minCreditScoreForCar) {
      return "You qualify for a car loan.";
    } else {
      return "You don't qualify for any loans."
    }

  }



  const duplexLoanMsg = getLoanMessage(85000, 850)
  const condoLoanMsg = getLoanMessage(65000, 690)
  const carLoanMsg = getLoanMessage(45000, 660)
  const noLoanMsg = getLoanMessage(25000, 550)
  console.log(duplexLoanMsg)
  console.log(condoLoanMsg)
  console.log(carLoanMsg)
  console.log(noLoanMsg)
</script>