<form method="post">

  <h1>crear</h1>
  <div class="form-group">
    <label for="nombre">nombre:</label>
    <input name="nombre" id="nombre" type="text" value="<?= $input['nombre'] ?? '' ?>">
    <?php if (isset($_GET['nombre']) && !empty($errores['nombre'])): ?>
      <p class="text-danger mt-2"> <?= $errores['nombre'] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label for="id_rol">Rol:</label>
    <select name="id_rol" id="id_rol" class="form-control select2">
      <option value="">-</option>
      <?php foreach ($roles as $rol) {
        $estaDentroDeArray = ($input['id_rol'] ?? '') == $rol['id_rol'];
      ?>
        <option value="<?= $rol['id_rol'] ?>" <?= $estaDentroDeArray ? 'selected' : ''; ?>>
          <?= ucfirst($rol['nombre_rol']); ?>
        </option>
      <?php } ?>
    </select>
    <?php if (isset($_GET['id_rol']) && !empty($errores['id_rol'])): ?>
      <p class="text-danger mt-2"> <?= $errores['id_rol'] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label for="email">email:</label>
    <input name="email" id="email" type="text" value="<?= $input['email'] ?? '' ?>">
    <?php if (isset($_GET['email']) && !empty($errores['email'])): ?>
      <p class="text-danger mt-2"> <?= $errores['email'] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label for="pass">password:</label>
    <input name="pass" id="pass" type="password" minlength="2" maxlength="50" value="<?= $input['pass'] ?? '' ?>">
    <?php if (isset($_GET['pass']) && !empty($errores['pass'])): ?>
      <p class="text-danger mt-2"> <?= $errores['pass'] ?> </p>
    <?php endif; ?>
  </div>

</form>