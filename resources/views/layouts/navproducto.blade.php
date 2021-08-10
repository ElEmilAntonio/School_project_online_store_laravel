<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="fa fa-cubes"></i>Productos<span class="caret"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" onclick="location.href='/productos/todo'" method="POST">
     todo
    </a>
    @if(count($categorias)>0)
    @foreach($categorias as $categoria)
        <a class="dropdown-item" onclick="location.href='/productos/{{$categoria->nombre}}'" method="POST">
      {{$categoria->nombre}}
    </a>
      @endforeach
  @endif
</div>
</li>