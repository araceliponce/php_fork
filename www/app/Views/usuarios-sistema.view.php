<?php

?>


<div class="rojw">
  <div class="col-12no ">
    <div class="card  p-4 mb-4">
      <form method="get" action="">
        <div
          class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
        </div>
        <div>

          <div class="row">
            <div class="col-12 col-lg-4">
              <div class="mb-3">
                <label for="username">Nombre:</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $input['username'] ?? ''; ?>" />
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="form-group">
                <label for="id_roles[]">Rol:</label>
                <select name="id_roles[]" id="id_roles" class="form-control select2" multiple>
                  <option value="">-</option>
                  <?php foreach ($roles as $rol) {
                    $estaDentroDeArray = in_array($rol['id_rol'], $input['id_roles'] ?? []);
                  ?>
                    <option value="<?= $rol['id_rol'] ?>" <?= $estaDentroDeArray ? 'selected' : ''; ?>>
                      <?= ucfirst($rol['nombre_rol']); ?></option>
                  <?php
                  }
                  ?>
                </select>
                <p class="text-error small"><?php echo $errors['id_roles[]'] ?? ''; ?></p>
              </div>
            </div>




          </div>
        </div>
        <div class="col-12 text-right">
          <a href="<?php echo strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?>" value="" class="btn btn-danger">Reiniciar filtros</a>
          <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2" />
        </div>

      </form>
    </div>
  </div>



  <style>
    /* https://getbootstrap.com/docs/4.0/components/buttons/ */
    nav ul {
      list-style: none;
      justify-content: center;
      gap: .5rem;
      padding-top: 1rem;
    }


    .btnbtn {
      display: inline-block;
      border: none;
      background: #e1dada;
      border-radius: .25rem;
      padding: .5rem;
      width: 2.5rem;
      height: 2.2rem;
      display: inline-grid;
      place-content: center;
    }
  </style>
  <div class="col-12">
    <div class="card shadow mb-4">

      <h6 class="m-0 font-weight-bold text-primary">usuarios</h6>
      <!-- <?= var_dump($usuarios) ?> -->




      <div class="card-body" id="card_table">


        <table id="tabladatos" class="table table-striped">
          <thead>
            <tr>
              <?php




              $currentOrder = 1;
              $order = 1;

              // var_dump($columnasNames);
              foreach ($columnasNames as $index => $value) {

              ?>

                <th>


                  <a href="/usuarios-sistema">

                    <?= $value; ?>
                    <?php if (abs($currentOrder) === $index): ?>
                      <i class="fas fa-sort-amount-<?= $order < 0 ? 'down' : 'up' ?>-alt"></i>
                    <?php endif; ?>
                  </a>

                </th>
              <?php

              } //fin del foreach columnheaders

              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($usuarios as $usuario) {
            ?>
              <tr class="<?php echo $usuario['baja'] ? 'table-danger' : ''; ?>">
                <td><?= $usuario['id_usuario'] ?></td>
                <td><?= $usuario['email'] ?></td>
                <td><?= $usuario['username'] ?></td>
                <td><?= $usuario['last_date'] ?></td>
                <td>
                  <button class="btnbtn">
                    <!-- editar -->
                    <i class="fas fa-marker"></i>
                  </button>
                  <button class="btnbtn">
                    <!-- borrar -->
                    <i class="fas fa-backspace"></i>

                  </button>
                  <a class="btnbtn" href="mailto:<?= $usuario['email'] ?>">
                    <i class="fab fa-telegram-plane"></i>
                    <span class="sr-only">escribir email</span>
                  </a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>



        <nav>


          <ul class="d-flex">
            <?php

            $queryParams = $_GET;


            $url = '/usuarios-sistema?' . http_build_query($queryParams); //tipo: http://localhost:8080/trabajadores?page=3&itemsPerPage=3&order=2&username=ma&id_roles[]=&min_salarioBruto=&max_salarioBruto=&min_retencionIRPF=&max_retencionIRPF=&enviar=Aplicar+filtros

            var_dump($url)
            // $isActive = $fullUrl == $url;

            ?>



          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
<!--Fin HTML -->