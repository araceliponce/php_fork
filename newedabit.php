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
