<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol[]" id="id_rol" class="form-control select2" multiple="multiple">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $role) {
                                        ?>
                                        <option value="<?php echo $role['id_rol'] ?>" <?php echo (isset($input['id_rol']) && in_array($role['id_rol'], $input['id_rol'])) ? 'selected' : ''; ?>><?php echo ucfirst($role['rol']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-error small"><?php echo $errors['id_rol'] ?? ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control"
                                       name="email" id="email"
                                       value="<?php
                                        echo $input['email'] ?? ''; ?>"
                                       maxlength="255"
                                       placeholder="usuario@email.org"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control"
                                       name="nombre" id="nombre"
                                       value="<?php
                                        echo $input['nombre'] ?? ''; ?>"
                                       maxlength="255"
                                       placeholder="Nombre"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="idioma">Idioma:</label>
                                <select name="idioma" id="idioma" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($idiomas as $idioma) {
                                        ?>
                                        <option value="<?php echo $idioma ?>" <?php echo (isset($input['idioma']) && $idioma == $input['idioma']) ? 'selected' : ''; ?>><?php echo ucfirst($idioma); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-error small"><?php echo $errors['idioma'] ?? ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="last_date_from">Último acceso:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group date" id="last_date_from" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                   name="last_date_from" data-target="#last_date_from" value="<?php echo $input['last_date_from'] ?? ''; ?>"/>
                                            <div class="input-group-append" data-target="#last_date_from"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group date" id="last_date_to" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                   name="last_date_to" data-target="#last_date_to" value="<?php echo $input['last_date_to'] ?? ''; ?>"/>
                                            <div class="input-group-append" data-target="#last_date_to"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <a href="<?php echo strtok($_SERVER['REQUEST_URI'] ?? '/', '?'); ?>" value="" name="reiniciar"
                   class="btn btn-danger">Reiniciar filtros</a>
                <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="col-12">
    <div class="card shadow mb-4">
        <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Usuarios sistema</h6>
        </div>
        <?php
        if ($usuarios !== []) :
            ?>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <?php
                    require_once '../app/Helpers/form_helper.php';
                    echo printTableHeader($cabeceras, $currentOrder, empty($sentido) ? null : $sentido, $queryParams);
                    ?>
                    <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr clas="<?php echo !$usuario['baja'] ? 'bg-danger' : '' ?>">
                            <td><?php echo $usuario['nombre'] ?></td>
                            <td><?php echo $usuario['rol'] ?></td>
                            <td><?php echo $usuario['email'] ?></td>
                            <td><?php echo !empty($usuario['last_date']) ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $usuario['last_date'])->format('d/m/y H:i:s') : '-'?></td>
                            <td><?php echo $usuario['idioma']; ?></td>
                            <td>
                                <a href="mailto: <?php echo $usuario['email'] ?>" target="_blank" class="btn btn-info"
                                   data-toggle="tooltip" data-placement="top" title="<?php echo $usuario['email'] ?>"><i
                                            class="fas fa-envelope"></i></a>
                                <a href="usuarios-sistema/edit/<?php echo $usuario['id_usuario'] ?>"
                                   class="btn btn-success ml-2"><i class="fas fa-edit"></i></a>
                                <a href="usuarios-sistema/delete/<?php echo $usuario['id_usuario'] ?>"
                                   class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <?php
                        if ($currentPage !== 1) :
                            ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="/usuarios-sistema?page=1<?php echo $queryPage !== '' ? "&$queryPage" : ''; ?>"
                                   aria-label="First">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">First</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="/usuarios-sistema?page=<?php echo($currentPage - 1) ?><?php echo $queryPage !== '' ? "&$queryPage" : ''; ?>"
                                   aria-label="Previous">
                                    <span aria-hidden="true">&lt;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php
                        endif;
                        ?>

                        <li class="page-item active"><a class="page-link" href="#"><?php echo $currentPage ?></a></li>
                        <?php
                        if ($currentPage !== $maxPage) :
                            ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="/usuarios-sistema?page=<?php echo($currentPage + 1) ?><?php echo $queryPage !== '' ? "&$queryPage" : ''; ?>"
                                   aria-label="Next">
                                    <span aria-hidden="true">&gt;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="/usuarios-sistema?page=<?php echo $maxPage ?><?php echo $queryPage !== '' ? "&$queryPage" : ''; ?>"
                                   aria-label="Last">
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
        <?php else : ?>
            <div class="card-body">
                <div class="alert alert-warning">No existen usuarios que cumplen los requisitos específicados</div>
            </div>
            <?php
        endif;
        ?>
    </div>
</div>

<!--Fin HTML -->
