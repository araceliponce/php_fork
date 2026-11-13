<h1>nuevo usuario</h1>


<!-- 1 	username Primaria 	varchar(50) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
	2 	salarioBruto 	decimal(10,2) 			No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
	3 	retencionIRPF 	decimal(10,2) 			No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
	4 	activo 	tinyint(1) 			No 	0 			Cambiar Cambiar 	Eliminar Eliminar 	
	5 	id_rol Índice 	int 			No 	1 			Cambiar Cambiar 	Eliminar Eliminar 	
	6 	id_country 	int 
   -->

<pre>
    <?php var_dump($input) ?>
   </pre>
<form method="get">
  <!-- http://localhost:8080/trabajadores/new/?username=aaa&salario=&retencion=&salarioBruto=&salario=&id_rol= -->



  <div class="form-group">
    <label for="username">username:</label>
    <input name="username" type="text" minlength="2" maxlength="50" value="<?= $input['username'] ?? '' ?>">
    <?php if (isset($_GET['username']) && !empty($errores['username'])): ?>
      <p class="text-danger mt-2"> <?= $errores['username'] ?> </p>
    <?php endif; ?>
  </div>



  <div class="form-group">
    <label for="retencionIRPF">retencionIRPF (entre 0 y 100):</label>
    <input name="retencionIRPF" type="text" value="<?= $input['retencionIRPF'] ?? '' ?>">
    <?php if (isset($_GET['retencionIRPF']) && !empty($errores['retencionIRPF'])): ?>
      <p class="text-danger mt-2"> <?= $errores['retencionIRPF'] ?> </p>
    <?php endif; ?>

  </div>
  <div class="form-group">
    <label for="salarioBruto">salarioBruto:</label>
    <input name="salarioBruto" type="text" value="<?= $input['salarioBruto'] ?? '' ?>">
    <?php if (isset($_GET['salarioBruto']) && !empty($errores['salarioBruto'])): ?>
      <p class="text-danger mt-2"> <?= $errores['salarioBruto'] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label for="activo">activo :</label>
    <input name="activo" type="checkbox" checked="<?= $input['activo'] ?? '' ?>">
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
    <label for="id_country">country:</label>
    <select name="id_country" id="id_country" class="form-control select2">
      <option value="">-</option>
      <?php foreach ($countries as $item) {
        $estaDentroDeArray = ($input['id_country'] ?? '') == $item['id_country'];
      ?>
        <option value="<?= $item['id_country'] ?>" <?= $estaDentroDeArray ? 'selected' : ''; ?>>
          <?= ucfirst($item['country_name']); ?>
        </option>
      <?php } ?>
    </select>
    <?php if (isset($_GET['id_country']) && !empty($errores['id_country'])): ?>
      <p class="text-danger mt-2"> <?= $errores['id_country'] ?> </p>
    <?php endif; ?>
  </div>
  <div>
    <input type="submit" value="crear">
  </div>
</form>