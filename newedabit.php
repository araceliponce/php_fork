<?php


//tetraedron 
// de 2 = 2+1
//de 5 (contiene dentro uno de 3 y 1)
// de 6 (contiene dentro uno de 4 y uno de 2)


// tetra(2) ➞ 4
tetra(5); // 35;
// tetra(6) ➞ 56

function tetra($n)
{

  $totalExterior = 0;

  for ($i = $n; $i >= 0; $i--) {
    $totalExterior += $i;
  }

  if ($n > 3) {
  }
  echo $totalExterior;
}
