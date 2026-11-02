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
                    <input type="hidden" name="order" value="<?php echo $order; ?>"/>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value="<?php echo $input['username'] ?? ''; ?>"/>
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
                                        <input type="text" class="form-control" name="min_salarioBruto"
                                               id="min_salarioBruto"
                                               value="<?php echo $input['min_salarioBruto'] ?? '' ?>"
                                               placeholder="Mínimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salarioBruto"
                                               id="max_SalarioBruto"
                                               value="<?php echo $input['max_salarioBruto'] ?? '' ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="min_retencionIRPF">Rentención:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_retencionIRPF"
                                               id="min_retencionIRPF"
                                               value="<?php echo $input['min_retencionIRPF'] ?? '' ?>"
                                               placeholder="Mínimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_retencionIRPF"
                                               id="max_retencionIRPF"
                                               value="<?php echo $input['max_retencionIRPF'] ?? '' ?>"
                                               placeholder="Máximo"/>
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
                        <a href="<?php echo strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?>" value=""
                           class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
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
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <tr>
                        <?php
                        require_once '../app/Helpers/form_helper.php';
                        echo printTableHeader(
                            ['Username', 'Salario Bruto', 'Retención', 'Rol', 'País'],
                            $order,
                            $input['sentido'] ?? null,
                            $queryParams
                        );
                        ?>
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
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <?php
                        if ($currentPage !== 1):
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $baseUrl ?>?page=1 <?php echo ($queryParamsPage !== '' ? "&$queryParamsPage" : '') ?>" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $baseUrl ?>?page=<?php echo ($currentPage - 1) . ($queryParamsPage !== '' ? "&$queryParamsPage" : '')?>" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php
                        endif;
                        ?>
                        <li class="page-item active"><a class="page-link" href="#"><?php echo $currentPage ?></a></li>
                        <?php
                        if ($maxPage > $currentPage):
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $baseUrl ?>?page=<?php echo ($currentPage + 1) . ($queryParamsPage !== '' ? "&$queryParamsPage" : '')?>" aria-label="Next">
                                <span aria-hidden="true">&gt;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $baseUrl ?>?page=<?php echo $maxPage . ($queryParamsPage !== '' ? "&$queryParamsPage" : '')?>" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                        <?php
                        endif;
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->