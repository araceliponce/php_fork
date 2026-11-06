<?php
// var_dump($input);
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

<style>
  .form-group {
    display: grid;
    align-content: start;
  }
</style>

<form method="get" class="row col-12">
  <input type="hidden" name="" value="<?= $input['order'] ?? '' ?>">
  <input type="hidden" name="" value="<?= $input['currentPage'] ?? '' ?>">


  <div class="form-group col-6">
    <label for="nombre">nombre de producto:</label>
    <input name="nombre" type="text" value="<?= $input['nombre'] ?? '' ?>">
  </div>
  <div class="form-group col-6">
    <label for="codigo">codigo de producto:</label>
    <input name="codigo" type="text" value="<?= $input['codigo'] ?? '' ?>">
  </div>

  <div class="form-group col-6">

    <!-- <select id="select2" data-placeholder="Select an option" tabindex="-1" aria-hidden="true"> -->
    <!-- necesito colocar a losq ue no tienen id_padre como el label del optgroup 
     
    <optgroup label="CATEGORIA">
    <option value="ID_SUBCATEGORIA">SUBCATEGORIA</option>
    <option value="ID_SUBCATEGORIA">SUBCATEGORIA</option>
  </optgroup>
  <option value="D_SUBCATEGORIA">SUBACTEGORIA_SINPADRE</option>
      
      
      -->


    <?php

    // var_dump($supercategorias);
    // var_dump($_GET);

    ?>
    <label for="categorias">escoge categorias:</label>
    <select name="categorias[]" id="" multiple class="select2">
      <option value="">--</option>
      <?php foreach ($supercategorias as $super) {
      ?>
        <optgroup label="<?= $super['supercategoria_nombre'] ?>">
          <!-- <option value="x">equis</option> -->
          <?php foreach ($subcategorias as $sub) {

            $pertenece = $sub['subcategoria_padre'] === $super['supercategoria_id'];
            $estaDentroDeArray = in_array($sub['subcategoria_id'], $input['categorias'] ?? []);

            if ($pertenece) {
          ?>
              <option value="<?= $sub['subcategoria_id'] ?>" <?= $estaDentroDeArray ? 'selected' : ''; ?>>
                <?= ucfirst($sub['subcategoria_nombre']); ?>
              </option>
          <?php }
          } ?>
        </optgroup>
      <?php } ?>
    </select>

  </div>





  <div class="form-group col-4">
    <label for="min_coste">min coste:</label>
    <input name="min_coste" type="text" value="<?= $input['min_coste'] ?? '' ?>">
  </div>
  <div class="form-group col-4">
    <label for="max_coste">max coste:</label>
    <input name="max_coste" type="text" value="<?= $input['max_coste'] ?? '' ?>">
  </div>

  <div class="form-group col-4">
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

  <div class="row col-12">
    <input type="submit" value="enviar">
  </div>
</form>

<?php
// var_dump($productos);

echo (count($productos) == 0); ?>

<table id="tabladatos" class="table table-striped">
  <tr>
    <?php
    require_once '../app/Helpers/form_helper.php';
    echo printTableHeader(
      ['id', 'codigo', 'nombre', 'coste', 'margen', 'stock', 'iva', 'proveedor'],
      $order,
      $queryParams
    );
    ?>
    <tbody>
      <?php if (empty($productos)): ?>
        <tr>
          <td colspan="8" style="text-align: center;">no se encontro</td>
        </tr>

      <?php else: ?>

        <?php
        foreach ($productos as $item) :
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
        <?php endforeach; ?>

      <?php endif; ?>
    </tbody>

</table>


<nav style="padding-bottom: 3rem;">
  <?php
  queryParams = queryParamsPage !== '' ? "&queryParamsPage" : '';

  firstPage = "baseUrl?page=1queryParams";
  prevPage  = "baseUrl?page=" . (currentPage - 1) . queryParams;
  nextPage  = "baseUrl?page=" . (currentPage + 1) . queryParams;
  lastPage  = "baseUrl?page=maxPagequeryParams";
  ?>

  <ul class="pagination justify-content-center">
    <?php if (currentPage !== 1): ?>
      <li class="page-item">
        <a class="page-link" href="<?= firstPage ?>" aria-label="First">&laquo;</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="<?= prevPage ?>" aria-label="Previous">&lt;</a>
      </li>
    <?php endif; ?>
    <li class="page-item active">
      <a class="page-link" href="#"><?php echo currentPage ?></a>
    </li>
    <?php if (currentPage < maxPage): ?>
      <li class="page-item">
        <a class="page-link" href="<?= nextPage ?>" aria-label="Next">&gt;</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="<?= lastPage ?>" aria-label="Last">&raquo;</a>
      </li>
    <?php endif; ?>
  </ul>
</nav>