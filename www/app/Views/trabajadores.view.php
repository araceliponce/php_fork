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
                    <input type="hidden" name="page" value="<?php echo $page ?? ''; ?>" />
                    <input type="hidden" name="itemsPerPage" value="<?php echo $itemsPerPage ?? ''; ?>" />


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
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Trabajadores</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>

                <nav>
                    <ul>
                        <?php

                        $numbers = [];

                        //llena el array de numeros
                        for ($i = 0; $i < count($trabajadores); $i++) {
                            $numbers[] = $i;
                        }



                        foreach ($numbers as $number) {


                        ?>
                            <li><a href="/trabajadores?page=<?php echo $number . '&itemsPerPage=' . $itemsPerPage  . '&' . $queryParams ?>">
                                    <?= $number; ?>
                                </a>
                            </li>

                        <?php

                        } //fin del foreach columnheaders

                        ?>
                    </ul>
                </nav>
                <!--<form action="./?sec=formulario" method="post">                   -->
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



                            // si existe un $order en el url, entonces usar ese numero para buscar dentro del array array[numero de order -1]
                            //cambiar su multiplier * -1;
                            if ($order && $columnsHeaders[abs($order - 1)]) {
                                // var_dump($order);
                                // var_dump($columnsHeaders[abs($order - 1)]);
                                $columnsHeaders[abs($order - 1)]['multiplier'] *= -1;
                                // var_dump($columnsHeaders[abs($order - 1)]);
                            };


                            foreach ($columnsHeaders as $headerIndex => $value) {
                                //cosa rra que no recuerdo.
                                $orderToDisplay = $value['multiplier'] * ($order / abs($order))  * ($headerIndex + 1);

                            ?>

                                <th>
                                    <a href="/trabajadores?order=<?php echo $orderToDisplay . '&' . $queryParams ?>">
                                        <?= $value['display']; ?>
                                    </a>
                                    <?php if (abs($order) === abs($orderToDisplay)): ?> <i class="fas fa-sort-amount-down-alt"></i> <?php endif; ?>
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
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->