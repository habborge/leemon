<nav class="navbar navbar-expand-lg navbar-dark bg-mega">
    <div class="container">
        <div class="row-mega">
            
                    
            <div class="navbar-mega">
                @foreach ($menus as $key => $item)
                @if ($item['father_id'] != 0)
                    @break
                @endif
                @if ($item['submenu'] == [])
                    <li>
                        <a href="{{ url($item['name']) }}">{{ $item['name'] }} </a>
                    </li>
                @else
                <div class="dropdown-mega category">
                    <button class="dropbtn">{{ $item['name'] }} 
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="container">
                        <div class="row">
                            <div class="dropdown-mega-content">
                                <div class="header-mega">
                                    <h2 class="title-tam">{{ $item['name'] }} </h2>
                                </div>   
                                <div class="row-mega">
                                    @foreach ($item['submenu'] as $submenu)
                                        @if ($submenu['submenu'] == [])

                                        @else
                                 
                                            <div class="columna">
                                                <h3 class="title-tam2">{{$submenu['name']}}</h3>
                                                @foreach ($submenu['submenu'] as $submenu2)
                                               
                                                <a href="#">{{$submenu2['name']}}</a>
                                                {{-- <a href="#">Vitamina B</a>
                                                <a href="#">Vitamina C</a>
                                                <a href="#">Vitamina D</a>
                                                <a href="#">Vitamina E</a> --}}
                                                
                                                @endforeach
                                            </div>
                                    {{-- @include('partials.menu-item', [ 'item' => $submenu ]) --}}
                                        @endif
                                    @endforeach
                                    {{-- <div class="columna">
                                        <h3 class="title-tam2">MULTIVITAMINAS</h3>
                                        <a href="#">Mujeres</a>
                                        <a href="#">Hombres</a>
                                        <a href="#">Niños</a>
                                        <a href="#">Prenatal</a>
                                        <a href="#">Mayores 50</a>
                                    </div>
                                    <div class="columna">
                                        <h3 class="title-tam2">MINERALES</h3>
                                        <a href="#">Calcium Magnesium Zinc</a>
                                        <a href="#">Iron</a>
                                        <a href="#">Potassium</a>
                                        <a href="#">Chromium</a>
                                        <a href="#">Selenium</a>
                                    </div> --}}
                                    <div class="columna">
                                        <img src="img/Garlic(1).png" class="img-responsive" width="120">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                {{--<li class="dropdown">
                        
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item['name'] }} <span class="caret"></span></a>
                    
                    <ul class="dropdown-menu sub-menu">
                        @foreach ($item['submenu'] as $submenu)
                            @if ($submenu['submenu'] == [])
                                <li><a href="{{ url('menu',['id' => $submenu['id'], 'slug' => $submenu['slug']]) }}">{{ $submenu['name'] }} </a></li>
                            @else
                                 @include('partials.menu-item', [ 'item' => $submenu ])
                            @endif
                        @endforeach
                    </ul> 
                </li>--}}
            @endif
            
        @endforeach
                
            </div>  
        </div>    
    </div>    
     
</nav>