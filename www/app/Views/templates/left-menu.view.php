<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder'] ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'inicio' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php echo (in_array(strtok($_SERVER['REQUEST_URI'] ?? '/', '?') , [$_ENV['host.folder'] . 'demo-proveedores', $_ENV['host.folder'] . 'trabajadores'])) ? 'menu-open' : '';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>trabajadores" class="nav-link <?php echo strtok($_SERVER['REQUEST_URI'] ?? '/', '?') === $_ENV['host.folder'] . 'trabajadores' ? 'active' : ''; ?>">
                        <i class="fas fa-briefcase nav-icon"></i>
                        <p>Trabajadores</p>
                    </a>
                </li>
              <li class="nav-item">
                <a href="<?php echo $_ENV['host.folder'] ?>demo-proveedores" class="nav-link <?php echo strtok($_SERVER['REQUEST_URI'] ?? '/', '?') === $_ENV['host.folder'] . 'demo-proveedores' ? 'active' : ''; ?>">
                  <i class="fas fa-laptop-code nav-icon"></i>
                  <p>Demo Proveedores</p>
                </a>
              </li>              
            </ul>
          </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-code"></i>
                    <p>
                        Ej. operadores
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <?php
                    for ($i = 1; $i < 11; $i++):
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo $_ENV['host.folder'] ?>ejercicio<?php echo $i; ?>-operadores" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . "ejercicio{$i}-operadores" ? 'active' : ''; ?>">
                            <i class="fas fa-equals nav-icon"></i>
                            <p>Ejercicio <?php echo $i; ?></p>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-infinity"></i>
                    <p>
                        Ej. iterativas
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <?php
                    for ($i = 1; $i < 11; $i++):
                        ?>
                        <li class="nav-item">
                            <a href="<?php echo $_ENV['host.folder'] ?>iterativas<?php echo $i; ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . "iterativas{$i}" ? 'active' : ''; ?>">
                                <i class="fas fa-equals nav-icon"></i>
                                <p>Ejercicio <?php echo $i; ?></p>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->