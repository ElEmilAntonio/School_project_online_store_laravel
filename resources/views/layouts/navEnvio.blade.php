<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fa fa-truck"></i> {{ __('Envios') }}</a><span class="caret"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" onclick="location.href='/gestion_envios/3'" method="POST">{{ __('Todo') }}</a>
         <a class="dropdown-item" onclick="location.href='/gestion_envios/0'" method="POST">{{ __('en preparacion') }}</a>
          <a class="dropdown-item" onclick="location.href='/gestion_envios/1'" method="POST">{{ __('en camino') }}</a>
           <a class="dropdown-item" onclick="location.href='/gestion_envios/2'" method="POST">{{ __('entregados') }}</a>
</div>
</li>
