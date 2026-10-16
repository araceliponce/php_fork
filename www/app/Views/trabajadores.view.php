<?php

echo "hiiii";
// var_dump($trabajadores);
// array (size=6)
//       'username' => string 'administrador' (length=13)
//       'salarioBruto' => string '5000.00' (length=7)
//       'retencionIRPF' => string '30.00' (length=5)
//       'activo' => int 1
//       'id_rol' => int 1
//       'id_country' => int 143


// if (isset($data['trabajadores'])) {
// foreach ($trabajadores as $trabajador) {
//   echo $trabajador['username'];
// }
// }

?>
<div>
  <?= $algo ?>
  <?= $menosPagado ?>




  <!-- 
    <h2>Todos los trabajadores.</h2>

    <ul>
    <?php foreach ($trabajadores as $trabajador) : ?>
      <li>
        <b><?php echo $trabajador['username']; ?> </b>
      </li>
    <?php endforeach ?>
  </ul>


    <h2>Todos los trabajadores ordenados por salarioBruto de mayor salario a menor.</h2>

  <ul>
    <?php foreach ($arrayUsernameSalario as $trabajador) : ?>
      <li>
        <b><?php echo $trabajador['username']; ?> </b>
        <b><?php echo $trabajador['salario']; ?> </b>

      </li>
    <?php endforeach ?>
  </ul> 

  <h2>con rol == 3</h2>
  <ul>
    <?php foreach ($arrayStandard as $trabajador) : ?>
      <li>
        <b><?php echo $trabajador['username']; ?> </b>
      </li>
    <?php endforeach ?>
  </ul>
  -->
  <h2>Todos los trabajadores cuyo username comience por Carlos.</h2>

  <ul>
    <?php foreach ($carloses as $trabajador) : ?>
      <li>
        <b><?php echo $trabajador['username']; ?> </b>
      </li>
    <?php endforeach ?>
  </ul>


</div>