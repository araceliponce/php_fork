<?php

// If a binary string has an odd number of 1's, the parity bit is a 1.
// If a binary string has an even number of 1's, the parity bit is a 0.
// The parity bit is appended to the end of the binary string.

// .fetch(fetch_assoc value o el que tenga por default)
//usar bind value, no tanto bindparam


function validateBinary($b)
{
  $cuantosUnos = 0;
  $ultimoDigito = $b[strlen($b) - 1];
  $todoMenosUltimo = substr($b, 0, 7); // o 0,-1
  $digitos = str_split($todoMenosUltimo); //2do param puede ser cantidad de letras por item


  if (strlen(trim($b)) === 8) {
    //si tiene 8 digittos
    //entonces revisa si la cantidad es par o impar
    foreach ($digitos as $digito) {
      if ($digito == 1) {
        $cuantosUnos++;
      }
    }
  }

  $isOk = ($ultimoDigito == 1 && $cuantosUnos % 2 == 1) || ($ultimoDigito == 0 && $cuantosUnos % 2 == 0);
  return $isOk;
}















// Your task is to correct the errors in the digitized text. You only have to handle the following mistakes:

//     Replace 4 with A.
//     Replace 5 with S.
//     Replace 0 with O.
//     Replace 1 with I.


function keyboard_mistakes(string $text): string
{
  $res = $text;

  $replacing = [
    4 => 'A',
    5 => 'S',
    0 => 'O',
    1 => 'I'
  ];

  foreach ($replacing as $target => $replacement) {
    $res = str_replace($target, $replacement, $res);
  }
  return $res;
}

$aaa = keyboard_mistakes("MUB45H1R");





function space_me_out($text)
{
  // $res = explode('', $text); NO PUEDES EXPLOTAR SIN DELIMITADOR
  $res = str_split($text);

  //   dale espacio entre 2 letras
  $newRes = implode(" ", $res);

  return $newRes;
}


$bbb = space_me_out("space SHIP");

var_dump($bbb);

// foreach ($bbb as $char) {
//   # code...
// }




function wifi_signal($score)
{

  //cumple una y ya no cambia con la sgte, aunque la cumpla
  $res = match (true) {
    $score < 40 => 'Weak',
    $score < 70 => 'Okay',
    $score <= 100 => 'Strong',
    default => ''
  }; //EL PUNTO Y COMA!!!!


  return $res;
}



function drink_potion($health, $healing)
{
  // Write your code here.

  //BIEN
  // $res = $health + $healing;
  // if ($res > 100) {
  //   $res = 100;
  // }
  // return $res;

  //OTRA OPCION. Devuelve el menor de 2 valores
  return min($health + $healing, 100);

  return ($health + $healing) > 100 ? 100 : ($health + $healing);
}





// Create should_retry to decide whether to try a request again. Return true only when the previous attempt failed and attempts is less than limit. Otherwise, return false.
// Examples

// should_retry(true, 2, 3)
// // true

// should_retry(false, 2, 3)
// // false

// should_retry(true, 3, 3)
// // false
function should_retry($failed, $attempts, $limit)
{

  if ($attempts < $limit && $failed === true) {
    return true;
  } else {
    return false;
  }
}





//revisa si $num es dividible entre todos los numeros del array $factors
function checkFactors($factors, $num)
{
  $totalGoodFactors = 0;
  foreach ($factors as $factor) {
    if ($num % $factor == 0) {
      $totalGoodFactors++;
    }
  }
  return $totalGoodFactors == count($factors);
}


function reverse($arr)
{
  return array_reverse($arr);
}




// firstLast([5, 10, 15, 20, 25]) ➞ [5, 25]

// firstLast(["edabit", 13, null, false, true]) ➞ ["edabit", true]

// firstLast(["undefined", 4, "6", "hello", null]) ➞ ["undefined", null]
function firstLast($arr)
{
  return [$arr[0], $arr[count($arr) - 1]];
}



//Si $name es key en el array asociativo $items.
//return "Name is gone..." if the name is a key, otherwise "Name is here!". Capitalize the first letter.
function find_it($items, $name)
{
  $res = ucfirst($name) . " is here!";

  if (array_key_exists($name, $items)) {
    $res = ucfirst($name) . " is gone...";
  }


  return $res;
}




//javascript
// nunca puedes usar this.algo....... dentro de funciones flecha



//  board-game piece advances one through six tiles on one die roll. Return whether a piece at current can land on friend in one roll.
// Examples

// possible_bonus(3, 7) ➞ true

// possible_bonus(1, 9) ➞ false

// possible_bonus(5, 3) ➞ false


// Positions are non-negative integers.
// Moving backward or already sharing a tile returns false.
// /7parece que hay 6 espacios
function possible_bonus($current, $friend)
{

  $res = false;
  if (is_int($current) && is_int($friend)) {

    $diff = $friend - $current;

    $res = $diff >= 1 && $diff <= 6;
  }
  return $res;
}



// 5+4+3 =12
//4+3+2 =9
//3+2+1=6
//2+1=3
//1 

//el tetraedo de 5 tiene dentro uno de 3
//31+4

//el de 6 tiene dentro uno de cuatro
