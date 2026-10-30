<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- inputs hidden para mantener el valor incluso si despues de hace submit del formulario -->
                    <input type="hidden" name="page" value="<?php echo $page  ?>" />
                    <input type="hidden" name="itemsPerPage" value="<?php echo $itemsPerPage  ?>" />


                    <input type="hidden" name="order" value="<?php echo $order; ?>" />
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $input['username'] ?? ''; ?>" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control select2">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) {
                                    ?>
                                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo (isset($input['id_rol']) && $rol['id_rol'] == $input['id_rol']) ? 'selected' : ''; ?>><?php echo ucfirst($rol['nombre_rol']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-error small"><?php echo $errors['id_rol'] ?? ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="min_salarioBruto">Salario Bruto:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_salarioBruto" id="min_salarioBruto" value="<?php echo $input['min_salarioBruto'] ?? '' ?>" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salarioBruto" id="max_SalarioBruto" value="<?php echo $input['max_salarioBruto'] ?? '' ?>" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="min_retencionIRPF">Rentención:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_retencionIRPF" id="min_retencionIRPF" value="<?php echo $input['min_retencionIRPF'] ?? '' ?>" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_retencionIRPF" id="max_retencionIRPF" value="<?php echo $input['max_retencionIRPF'] ?? '' ?>" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_country">País:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2" multiple>
                                    <?php foreach ($countries as $country) {
                                    ?>
                                        <option value="<?php echo $country['id_country'] ?>" <?php echo (isset($input['id_country']) && in_array($country['id_country'], $input['id_country'])) ? 'selected' : ''; ?>><?php echo ucfirst($country['country_name']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-error small"><?php echo $errors['id_country'] ?? ''; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?>" value="" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2" />
                    </div>
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
    </style>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Trabajadores</h6>


            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>

                <table id="tabladatos" class="table table-striped">
                    <thead>
                        <tr>
                            <?php




                            $columnsHeaders = [
                                0 => [
                                    'display' => 'Username',
                                    'multiplier' => 1
                                ],
                                1 => [
                                    'display' => 'Salario Bruto',
                                    'multiplier' => 1
                                ],
                                2 => [
                                    'display' => 'Retención',
                                    'multiplier' => 1
                                ],
                                3 => [
                                    'display' => 'Rol',
                                    'multiplier' => 1
                                ],
                                4 => [
                                    'display' => 'Pais',
                                    'multiplier' => 1
                                ]
                            ];

                            $currentOrder = $order;

                            // si existe un $order en el url, entonces usar ese numero para buscar dentro del array array[numero de order -1]
                            //cambiar su multiplier * -1;
                            // if ($order && $columnsHeaders[abs($order - 1)]) {
                            //     // var_dump($order);
                            //     // var_dump($columnsHeaders[abs($order - 1)]);
                            //     $columnsHeaders[abs($order - 1)]['multiplier'] *= -1;
                            //     // var_dump($columnsHeaders[abs($order - 1)]);
                            // };


                            // foreach ($columnsHeaders as $headerIndex => $value) {
                            //     //cosa rara que no recuerdo.
                            //     $orderToDisplay = $value['multiplier'] * ($order / abs($order))  * ($headerIndex + 1);


                            // http://localhost:8080/trabajadores?itemsPerPage=3&order=-4&username=carlos&id_rol=&min_salarioBruto=&max_salarioBruto=&min_retencionIRPF=&max_retencionIRPF=&enviar=Aplicar+filtros

                            foreach ($columnsHeaders as $headerIndex => $value) {

                                $columnOrder = $headerIndex + 1;

                                // Si selecciona la columna actual, cambia ASC/DESC
                                if (abs($currentOrder) === $columnOrder) {

                                    $orderToDisplay = $currentOrder * -1;
                                } else {

                                    // Si selecciona otra columna, empieza en ASC
                                    $orderToDisplay = $columnOrder;
                                }

                                // Copia los parámetros actuales
                                $params = $_GET;

                                // Actualiza order: sustituye el anterior si existe
                                $params['order'] = $orderToDisplay;


                                // Al cambiar de columna, vuelve a la primera página
                                // unset($params['page']);


                                // Genera la query string
                                $queryParams = http_build_query($params);
                            ?>

                                <th>
                                    <a href="/trabajadores?<?= $queryParams ?>">
                                        <?= $value['display']; ?>
                                    </a>
                                    <?php if (abs($currentOrder) === $columnOrder): ?>
                                        <i class="fas fa-sort-amount-<?= $order < 0 ? 'down' : 'up' ?>-alt"></i>
                                    <?php endif; ?>
                                </th>
                            <?php

                            } //fin del foreach columnheaders

                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($trabajadores as $trabajador) {
                        ?>
                            <tr class="<?php echo $trabajador['activo'] ? '' : 'table-danger'; ?>">
                                <td><?php echo $trabajador['username'] ?></td>
                                <td><?php echo $trabajador['salarioBruto'] ?></td>
                                <td><?php echo $trabajador['retencionIRPF'] ?>%</td>
                                <td><?php echo $trabajador['nombre_rol'] ?></td>
                                <td><?php echo $trabajador['country_name'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>



                <nav>
                    <ul class="d-flex">
                        <?php

                        $numbers = [1, 2, 3, 4];
                        $queryParams = $_GET;


                        //para comparar el current full url con cada link de la navegacion
                        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
                        // $fullUrl = $base_url . $_SERVER["REQUEST_URI"];
                        $fullUrl =  $_SERVER["REQUEST_URI"];
                        // var_dump($fullUrl);



                        foreach ($numbers as $number) {

                            // Mantiene los filtros, cambiando solo el numero de pagina
                            $params = array_merge($queryParams, [
                                'page' => $number
                            ]);

                            $url = '/trabajadores?' . http_build_query($params); //tipo: http://localhost:8080/trabajadores?page=3&itemsPerPage=3&order=2&username=ma&id_rol=&min_salarioBruto=&max_salarioBruto=&min_retencionIRPF=&max_retencionIRPF=&enviar=Aplicar+filtros

                            $isActive = $fullUrl == $url;

                        ?>
                            <li><a class="btn btn-light <?= $isActive ? 'bg-pink' : '' ?>" href="<?= htmlspecialchars($url) ?>">
                                    <?= $number; ?>
                                </a>
                            </li>

                        <?php

                        } //fin del foreach paginacion 

                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->