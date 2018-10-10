@guest
@else
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li>

                        <button type="button" class="btn btn-info active" id="intranet_nd" onclick="intrand()">ND</button>
                        <button type="button" class="btn btn-info" id="intranet_lp" onclick="intralp()">LP</button>
                        <button type="button" class="btn btn-info" id="intranet_lg" onclick="intralg()">LG</button>

                    </li>
                </ul>
                <ul id="couleur_menu" class="nav justify-content-center">
                    <li class="nav-item">
                        <a id="couleur_menu" class="nav-link" href="https://www.google.com/" target="_blank">Google</a>
                    </li>
                    <li class="nav-item">
                        <a id="couleur_menu" class="nav-link" href="#" target="_blank">Wiki</a>
                    </li>
                    <li class="nav-item">
                        <a id="couleur_menu" class="nav-link" href="#" target="_blank">Office 365</a>
                    </li>
                    <li class="nav-item">
                        <a id="couleur_menu" class="nav-link" href="#" target="_blank">École Directe</a>
                    </li>
                    <li class="nav-item">
                        <a id="couleur_menu" class="nav-link" href="#" target="_blank">Folios</a>
                    </li>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Livres
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a href="#" class="dropdown-item">CNS</a>
                            <a href="#" class="dropdown-item">Educhadoc</a>
                        </div>
                    </div>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Bonjour, {{ Auth::user()->firstname }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->isSuperAdmin())
                                <a href="/dashboard" class="dropdown-item">Dashboard</a>
                                <a href="/files" class="dropdown-item">Logiciels</a>
                                <a href="/news" class="dropdown-item">Liste d'informations</a>
                                <a href="/users" class="dropdown-item">Utilisateurs</a>
                                <a href="/classes" class="dropdown-item">Classes</a>
                                <a href="/agenda" class="dropdown-item">Agenda</a>
                            @elseif(Auth::user()->isAdmin())
                                <a href="/dashboard" class="dropdown-item">Ajout d'informations</a>
                                <a href="/news" class="dropdown-item">Gestion des informations</a>
                                <a href="/files" class="dropdown-item">Gestion des logiciels</a>
                                <a href="/agenda" class="dropdown-item">Agenda</a>
                            @else

                                <a href="/files" class="dropdown-item">Logiciels</a>
                                <a href="/agenda" class="dropdown-item">Agenda</a>
                                <a href="#" class="dropdown-item" target="_blank">Cerise Pro</a>
                                <a href="#" class="dropdown-item">Pré-convention de stage</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Déconnexion') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endguest