

  <!-- navbar -->
     <div class="index-nav">
       <nav class="navbar navbar-expand-lg fixed-top navbar-dark py-1 bg-transparent">
            <div class="container">
                 <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('home_page/img/logo.png')}}" class="w-20"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white" href="{{route('home')}}">HOME</a>
                        </li>
                        <li class="nav-item mx-2 dropdown">
                            <a class="nav-link text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                PROFIL
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                               <a class="dropdown-item" href="{{route('mentor')}}">Pembimbing</a>
                                <a class="dropdown-item" href="{{route('alumni')}}">Alumni</a>
                                <a class="dropdown-item" href="{{route('gallery')}}">Galeri Kegiatan</a>
                            </div>
                        </li>
                         <li class="nav-item mx-2">
                                <a class="nav-link text-white" href="{{route('eskul')}}">EKSTRAKURIKULER</a>
                            </li>
                     
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white" href="{{route('article')}}">BERITA</a>
                        </li>
                        @guest
                        <li class="nav-item mx-2">
                            <a href="{{route('login')}}" class="nav-link btn btn-1 text-white px-4">LOGIN</a>
                        </li>
                        @endguest

                         @auth
                        
                        <li class="nav-item mx-2 dropdown">
                                <a class="nav-link text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fas fa-user mr-2 active"></i></span>{{auth()->user()->name}}</a>
                                 <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{route('dashboard_user')}}">Dashboard</a>
                                <a class="dropdown-item" href="/api/v1/auth/logout">Logout</a>
                               
                            </div>
                        </li>

                        @endauth

                    </ul>
                </div>
            </div>
          </nav>
      </div>
      <!-- navbar -->