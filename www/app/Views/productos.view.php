<?php
var_dump($input);
// array (size=10)
//       'id_producto' => int 11
//       'codigo' => string 'ACE0000189' (length=10)
//       'nombre' => string 'Acer - Series X31' (length=17)
//       'descripcion' => string 'Inserte una descripción' (length=24)
//       'proveedor' => string 'E5000065M' (length=9) es el CIF DEL PROVEEDOR
//       'coste' => string '82.84' (length=5)
//       'margen' => string '2.28' (length=4)
//       'stock' => int 183
//       'iva' => int 21
//       'id_categoria' => int 5


// /7proveedor col
// 1 	cif Primaria 	varchar(9) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 2 	codigo 	varchar(10) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 3 	nombre 	varchar(255) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 4 	direccion 	varchar(255) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 5 	website 	varchar(255) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 6 	email 	varchar(255) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 7 	telefono 	varchar(12) 	utf8mb4_0900_ai_ci 		Sí 	NULL 			Cambiar Cambiar 	Eliminar Eliminar 	
// 8 	id_country Índice 	int 		UNSIGNED 	No 	Ninguna

?>



<form method="get">
  <input type="hidden" name="" value="<?= $input['order'] ?? '' ?>">


  <div class="form-group">
    <label for="nombre">nombre de producto:</label>
    <input name="nombre" type="text" value="<?= $input['nombre'] ?? '' ?>">
  </div>
  <div class="form-group">
    <label for="codigo">codigo de producto:</label>
    <input name="codigo" type="text" value="<?= $input['codigo'] ?? '' ?>">
  </div>
  <div class="form-group">

    <label for="proveedores">proveedores:</label>
    <select name="proveedores[]" id="proveedores" class="form-control select2" multiple>
      <option value="">-</option>
      <?php foreach ($proveedores as $proveedor) {
        $estaDentroDeArray = in_array($proveedor['proveedor_cif'], $input['proveedores'] ?? []);
      ?>
        <option value="<?= $proveedor['proveedor_cif'] ?>" <?= $estaDentroDeArray ? 'selected' : ''; ?>>
          <?= ucfirst($proveedor['proveedor_nombre']); ?>
        </option>
      <?php } ?>
    </select>
    <p class="text-error small"><?php echo $errors['proveedores[]'] ?? ''; ?></p>
  </div>

  <input type="submit" value="enviar">
</form>


<table id="tabladatos" class="table table-striped">
  <tr>
    <?php
    require_once '../app/Helpers/form_helper.php';
    echo printTableHeader(
      ['p.id_producto', 'p.codigo', 'p.nombre', 'p.coste', 'p.margen', 'p.stock', 'p.iva', 'p.proveedor_nombre'],
      (int)($input['order'] ?? 1),
      $queryParams ?? ''
    );
    ?>
    <tbody>
      <?php
      foreach ($productos as $item) {
      ?>
        <tr class="">
          <td><?php echo $item['id_producto'] ?></td>
          <td><?php echo $item['codigo'] ?></td>
          <td><?php echo $item['nombre'] ?></td>
          <td><?php echo $item['coste'] ?></td>
          <td><?php echo $item['margen'] ?></td>
          <td><?php echo $item['stock'] ?></td>
          <td><?php echo $item['iva'] ?>%</td>
          <td><?php echo $item['proveedor_nombre'] ?></td>


        </tr>
      <?php
      }
      ?>
    </tbody>
</table>