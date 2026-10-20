<?php

// https://centros.edu.xunta.gal/iespazomerce/aulavirtual/mod/book/view.php?id=95335&chapterid=4973
// ejecutar los filtros 1 a uno, si el 0 hay usa ese, si hay 1, usa esey asi

// var_dump($errores);

// var_dump($resultado);

// var_dump($roles);

var_dump($_GET['rolSelect'])

?>
<div>



  <form method="GET">

    <input name="usernameInput" value="<?= $usernameInput ?? '' ?>">

    <label for="rolSelect">rol:</label>

    <select name="rolSelect[]" id="rolSelect" class="form-control select2">
      <option value="">selecciona algo</option>
      <?php foreach ($roles as $rol): ?>
        <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre_rol'] ?></option>
      <?php endforeach;  ?>
    </select>
    <button type="submit">enviar</button>
  </form>



  <table>
    <thead>
      <th>
      <td>username</td>
      <td>rol (id)</td>
      </th>
    </thead>
    <tbody>
      <?php foreach ($resultado as $trabajador) : ?>
        <tr>
          <td><?php echo $trabajador['username']; ?> </b>
          <td><?php echo $trabajador['id_rol']; ?> </b>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>


</div>