<?php

// If a binary string has an odd number of 1's, the parity bit is a 1.
// If a binary string has an even number of 1's, the parity bit is a 0.
// The parity bit is appended to the end of the binary string.

// .fetch(fetch_assoc value o el que tenga por default)
//usar bind value, no tanto bindparam


function validateBinary($b)
{
  $cuantosUnos = 0;
  // $ultimoDigito = $b[count($b) - 1];
  $todoMenosUltimo = substr($b, 0, 7); // o 0,-1
  $digitos = str_split($todoMenosUltimo); //2do param puede ser cantidad de letras por item
  var_dump($digitos);

  echo "todo menos ultimo $todoMenosUltimo<br>";
  // echo count($digitos);

  if (strlen(trim($b)) === 8) {
    //si tiene 8 digittos
    //revisa si la cantidad es par o impar
    foreach ($digitos as $digito) {
      if ($digito == 1) {
        $cuantosUnos++;
      }
    }
  }

  // echo $numeroUnos;
}



// validateBinary("00101101"); //➞ true

validateBinary("11000000");
