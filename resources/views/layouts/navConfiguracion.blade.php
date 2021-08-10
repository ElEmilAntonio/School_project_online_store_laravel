<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
       Gestion<span class="caret"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('sucursales') }}"><i class="fa fa-building"></i> {{ __('Sucursales') }}</a>
         <a class="dropdown-item" href="{{ route('empleados_administrador') }}"><i class=" fa fa-address-book-o"></i> {{ __('Empleados') }}</a>
            <a class="dropdown-item" href="{{ route('categorias') }}"><i class="fa fa-reorder"></i> {{ __('Categorias') }}</a>
</div>
</li>
