<?php


$numero = 9;
echo gettype($numero);

// 7typeof es javascript

// if (typeof $numero === 'integer') {
//   echo 'es numero';
// }

if (is_int($numero)) {
  echo 'es numero';
}
