<h1>nuevo usuario</h1>


<!-- 1 	username Primaria 	varchar(50) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
	2 	salarioBruto 	decimal(10,2) 			No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
	3 	retencionIRPF 	decimal(10,2) 			No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
	4 	activo 	tinyint(1) 			No 	0 			Cambiar Cambiar 	Eliminar Eliminar 	
	5 	id_rol Índice 	int 			No 	1 			Cambiar Cambiar 	Eliminar Eliminar 	
	6 	id_country 	int 
   -->

<pre>
    <?= var_dump($input) ?>
   </pre>
<form method="get">
  <!-- http://localhost:8080/trabajadores/new/?username=aaa&salario=&retencion=&salarioBruto=&salario=&id_rol= -->

  <div class="form-group">
    <label for="username">username:</label>
    <input name="username" type="text" minlength="2" maxlength="50" value="<?= $input['username'] ?? '' ?>">
    <?php if ($errores['username'] !== ''): ?>
      <p class="text-danger mt-2"> <?= $errores['username'] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label for="retencionIRPF">retencionIRPF (entre 0 y 100):</label>
    <input name="retencionIRPF" type="text" value="<?= $input['retencionIRPF'] ?? '' ?>">
    <!-- <?php if ($errores['json'] !== []): ?>
      <div class="text-danger mt-2">
        <ul class="mb-0">
          <?php foreach ($errores['json'] as $error): ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?> -->
  </div>
  <div class="form-group">
    <label for="salarioBruto">salarioBruto:</label>
    <input name="salarioBruto" type="text" value="<?= $input['salarioBruto'] ?? '' ?>">
  </div>

  <div class="form-group">
    <label for="activo">activo :</label>
    <input name="activo" type="checkbox" checked="<?= $input['activo'] ?? '' ?>">
  </div>
  <div class="form-group">
    <label for="id_rol">id_rol :</label>
    <input name="id_rol" type="text" value="<?= $input['id_rol'] ?? '' ?>">
    <?php if ($errores['id_rol'] !== ''): ?>
      <p class="text-danger mt-2"> <?= $errores['id_rol'] ?> </p>
    <?php endif; ?>
  </div>
  <div class="form-group">
    <label for="id_country">id_country :</label>
    <input name="id_country" type="text" value="<?= $input['id_country'] ?? '' ?>">
  </div>
  <div>
    <input type="submit" value="crear">
  </div>
</form>