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
                                <div class="dropdown-mega-content class-{{ $item['code'] }}">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="header-mega">
                                                    <h2 class="title-tam">{{ $item['name'] }} </h2>
                                                </div>   
                                                <div class="row-mega">
                                                    @foreach ($item['submenu'] as $submenu)
                                                    
                                                        @if ($submenu['submenu'] == [])
                                                        <div class="columna columna-{{ $item['code'] }}"><a href="/category/{{ str_replace(" ", "-", $item['name']) }}/{{ $item['id'] }}/{{ str_replace(" ", "-",$submenu['name']) }}/{{ $submenu['id'] }}"><h3 class="title-tam2">{{ $submenu['name'] }}</h3></a></div>
                                                        @else
                                                       
                                                            <div class="columna columna-{{ $item['code'] }}">
                                                                <a href="/category/{{ str_replace(" ", "-", $item['name']) }}/{{ $item['id'] }}/{{ str_replace(" ", "-",$submenu['name']) }}/{{ $submenu['id'] }}"><h3 class="title-tam2">{{$submenu['name']}}</h3></a>
                                                                @foreach ($submenu['submenu'] as $submenu2)
                                                                    @if ($submenu['submenu'] != [])
                                                                        <a href="/products/{{ str_replace(" ", "-",$item['name']) }}/{{str_replace(" ", "-",$submenu['name'])}}/{{str_replace(" ", "-",$submenu2['name'])}}_{{$submenu2['id']}}">{{$submenu2['name']}}</a>
                                                                    @endif
                                                                    
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-3 align-self-center">
                                                <div class="row">
                                                    <div class="col-md-12 columna-img text-center line-left">
                                                        <img src="/img/category_{{ $item['id']}}.png" class="img-responsive" width="120">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                    
                </div>
               
            @endif
            
        @endforeach
                
            </div>  
        </div>    
    </div>    
     
</nav>