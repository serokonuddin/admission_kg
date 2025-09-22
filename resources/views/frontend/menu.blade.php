<style>
   .dropdown-submenu {
  position: relative;
}

.dropdown-submenu>.dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -6px;
  margin-left: -1px;
  -webkit-border-radius: 0 6px 6px 6px;
  -moz-border-radius: 0 6px 6px;
  border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
  display: block;
}

.dropdown-submenu>a:after {
  display: block;
  content: " ";
  float: right;
  width: 0;
  height: 0;
  border-color: transparent;
  border-style: solid;
  border-width: 5px 0 5px 5px;
  border-left-color: #ccc;
  margin-top: 5px;
  margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
  border-left-color: #fff;
}

.dropdown-submenu.pull-left {
  float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
  left: -100%;
  margin-left: 10px;
  -webkit-border-radius: 6px 0 6px 6px;
  -moz-border-radius: 6px 0 6px 6px;
  border-radius: 6px 0 6px 6px;
}
</style>
<div class="navborder">
               <div class="container">
                  <div class="row">
                     <nav class="navbar">
                        <div class="navbar-header">
                           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
                           <span class="sr-only">Toggle Navigation</span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           </button>
                        </div>
                        <div class="collapse navbar-collapse" id="navbar-collapse-3">
                           <ul class="nav navbar-nav">
                           @foreach($pages as $ke=>$page)
                            <li class="{{($ke==0)?'active':''}}">
                                @if(isset($page['tree']))
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$page['title']}} <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        @foreach($page['tree'] as $key=>$childpage)
                                       
                                        
                                        @if(isset($childpage['tree']) && !empty($childpage['tree']))
                                        <li class="dropdown-submenu">
                                        <a href="#">{{$childpage['title']}}</a>
                                             <ul class="dropdown-menu">
                                             @foreach($childpage['tree'] as $key1=>$subchildpage)
                                                <li><a href="{{url('page/'.$subchildpage['slug'])}}">{{$subchildpage['title']}}</a></li>
                                             @endforeach
                                                
                                             </ul>
                                        </li>
                                        @else 
                                          <li>
                                             <a href="{{url('page/'.$childpage['slug'])}}"  >{{$childpage['title']}}</a>
                                          </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                @else
                                 @if($page['title']=='Home')
                                 <a href="{{url('/')}}" >{{$page['title']}}</a>
                                 @else 
                                 <a href="{{url('page/'.$page['slug'])}}" >{{$page['title']}}</a>
                                 @endif
                                @endif
                            </li>
                            @endforeach
                              
                           </ul>
                        </div>
                     
                     </nav>
                  </div>
               </div>
            </div>