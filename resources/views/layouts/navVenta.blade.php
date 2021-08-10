<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fa fa-bar-chart"></i>Ventas<span class="caret"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" onclick="location.href='/gestion_venta/1'" method="POST">{{ __('Todo') }}</a>
         <a class="dropdown-item" onclick="location.href='/gestion_venta/2'" method="POST">{{ __('Pagados') }}</a>
          <a class="dropdown-item" onclick="location.href='/gestion_venta/0'" method="POST">{{ __('Pendiente') }}</a>
</div>
</li>
