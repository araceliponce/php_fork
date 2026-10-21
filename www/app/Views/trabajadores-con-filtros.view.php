<?php

// https://centros.edu.xunta.gal/iespazomerce/aulavirtual/mod/book/view.php?id=95335&chapterid=4973
// ejecutar los filtros 1 a uno, si el 0 hay usa ese, si hay 1, usa esey asi

// var_dump($errores);

// var_dump($resultado);

// var_dump($roles);

// var_dump($_GET['rolSelect'])

?>
<div>

  <style>
    [selected],
    [aria-selected="true"] {
      background-color: pink !important;
    }
  </style>



  <form method="GET">

    <div>
      <label for="">escribe el username</label>
      <input name="usernameInput" value="<?= $usernameInput ?? '' ?>">
    </div>

    <div>
      <label for="rolSelect">rol:</label>
      <select name="rolSelect[]" id="rolSelect" class="form-control select2">
        <option value="">selecciona un rol</option>
        <?php foreach ($roles as $rol): ?>
          <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre_rol'] ?></option>
        <?php endforeach;  ?>
      </select>
    </div>


    <!-- <div>
      <label for="">escribe el rango</label>
      <input name="salarioMinInput" value="<?= $salarioMinInput ?? '' ?>">
      <span>-</span>
      <input name="salarioMaxInput" value="<?= $salarioMaxInput ?? '' ?>">
    </div> -->

    <div>
      <label for="countriesSelect">paises:</label>
      <select name="countriesSelect[]" id="countriesSelect" class="form-control select2" multiple>
        <option value="">selecciona paises</option>
        <?php foreach ($countries as $country): ?>
          <option value="<?= $country['id'] ?>" <?= in_array($country['id'], $countriesSelected) ? 'selected' : '' ?> classname='algo'><?= $country['country_name'] ?></option>
        <?php endforeach;  ?>
      </select>
    </div>

    <div class="pt-2 pb-5">

      <button type="submit" class="btn btn-primary btn-default">enviar</button>
      <input type="reset">reset</input>
    </div>
  </form>





  <?php
  if (empty($resultado)):

  ?>
    <p>no se halló</p>

  <?php else: ?>
    <table>
      <thead>

        <th>username</th>
        <th>rol (id)</th>
        <th>salario</th>
        <th>retencion</th>
        <th>pais</th>

      </thead>
      <tbody>
        <?php foreach ($resultado as $trabajador) : ?>
          <tr>
            <td><?php echo $trabajador['username']; ?> </b>
            <td><?php echo $trabajador['id_rol']; ?> </b>
            <td><?php echo $trabajador['salarioBruto']; ?> </b>
            <td><?php echo $trabajador['retencionIRPF']; ?> </b>
            <td><?php echo $trabajador['country_name']; ?> </b>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  <?php endif ?>


</div>