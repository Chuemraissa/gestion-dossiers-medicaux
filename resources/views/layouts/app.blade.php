<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    
    <title>@yield('title')</title>
    <!-- Bibliothèques livrées avec l'application (public/vendor) : fonctionnent sans Internet -->
    <link href="{{ asset('vendor/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/locales-all.min.js') }}"></script>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />


    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
  </head>


<body class="g-sidenav-show  bg-gray-100" data-confirmer-suppression="@lang('messages.confirmer_suppression')">  
    @if(auth()->user()?->aAcces('tableau_de_bord')) 
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="/">
            <img src="{{ asset('images/logo.jpg') }}" class="navbar-brand-img h-100" alt="main_logo"> 
            <span class="ms-1 font-weight-bold text-white">{{ __(auth()->user()?->roleModel?->libelle ?? session('role') ?? '') }}</span>
            </a>
        </div>

        <hr class="horizontal light mt-0 mb-2">

        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav"> 
                    @if(auth()->user()?->aAcces('tableau_de_bord')) 
                <li class="nav-item">
                    <a class="nav-link text-white " href="/">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-house-door"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold text-white">@lang('messages.acceuil')</span>
                    </a>
                </li>
                    @if(auth()->user()?->aAcces('patients'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listespatients">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10 bi bi-person-fill"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.patients')</span>
                    </a>
                </li>
                    @endif
                    @endif
                    @if(auth()->user()?->aAcces('consultations'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesconsultations">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-clipboard-data"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.consultation')</span>
                    </a>
                </li>
                    @endif
            @if(auth()->user()?->aAcces('ordonnances')) 
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesordonnances">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-file-text"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.ordonnance')</span>
                    </a>
                </li>
            @endif
                    @if(auth()->user()?->aAcces('rendez_vous'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesRDV">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-calendar-check"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.rendez-vous')</span>
                    </a>
                </li>
                    @endif
                @if(auth()->user()?->aAcces('examens'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesexamens">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-clipboard-data"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.examens')</span>
                    </a>
                </li>
                @endif
                    @if(auth()->user()?->aAcces('medicaments'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listemedicaments">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-capsule"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.medicaments')</span>
                    </a>
                </li>
                    @endif
                    @if(auth()->user()?->aAcces('rendez_vous'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/planing">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-calendar-check"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.planing')</span>
                    </a>
                </li>
                    @endif
                @if(auth()->user()?->aAcces('gestion_personnel'))
                <li class="nav-item">
                    <a class="nav-link text-white " href="/personnel">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-people-fill"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.resources')</span>
                    </a>
                </li>
                @endif
            @if(auth()->user()?->aAcces('tableau_de_bord')) 
                <li class="nav-item">
                    <a class="nav-link text-white " href="/aide">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-question-circle"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.aide')</span>
                    </a>
                </li>
            @endif
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3 text-dark font-weight-bold">
                <a class="btn bg-gradient-primary w-100" href="#" type="button">@lang('messages.connecte') <br/> {{ session('nomuser') }} </a>
            </div>   
        </div> 
    </aside>
    @endif
    
    <main class="main-content border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <nav aria-label="breadcrumb">
                        <i class="material-icons opacity-10 bi bi-list"></i>
                    </nav>
                    <nav aria-label="breadcrumb" class="mx-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('messages.langue')
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach (\App\Http\Controllers\LocalizationController::langues() as $code => $nom)
                                <a class="dropdown-item {{ app()->getLocale() === $code ? 'active' : '' }}" href="/locale/{{ $code }}">{{ $nom }}</a>
                                @endforeach
                            </div>
                        </div>
                    </nav>
                    <nav aria-label="breadcrumb">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0"><i class="material-icons opacity-10 bi bi-box-arrow-right"></i>@lang('messages.deconnect')</button>
                    </form>
                    </nav>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        {{-- Messages pour toutes les pages : action réussie, ou erreurs d'un formulaire --}}
        <div class="container-fluid">
            @if (session('status'))
                <div class="alert alert-info mt-3 mb-0">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mt-3 mb-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $erreur)
                            <li>{{ $erreur }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @yield('content')
    </main>
    
    <!-- Bootstrap 4 (fenêtres modales, onglets, menus déroulants) : jQuery doit être chargé en premier -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>

    <!-- Scripts de l'application : recherche dans les tableaux, confirmation des suppressions -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
