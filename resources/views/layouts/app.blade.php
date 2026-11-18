<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />

    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
  </head>


<body class="g-sidenav-show  bg-gray-100">  
    @if(session('role') == 'admin' || session('role') == 'laborantin' || session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere' || session('role') == 'charge_acceuil' || session('role') == 'pharmacien') 
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
            <img src="{{ asset('images/logo.jpg') }}" class="navbar-brand-img h-100" alt="main_logo"> 
            <span class="ms-1 font-weight-bold text-white">{{ session('role') }}</span>
            </a>
        </div>

        <hr class="horizontal light mt-0 mb-2">

        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav"> 
                    @if(session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'pharmacien' || session('role') == 'laborantin' || session('role') == 'infirmiere' || session('role') == 'laborantin' || session('role') == 'charge_acceuil') 
                <li class="nav-item">
                    <a class="nav-link text-white " href="/">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-house-door"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold text-white">@lang('messages.acceuil')</span>
                    </a>
                </li>
                    @if(session('role') == 'charge_acceuil' || session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere')
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
                    @if(session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere')
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesconsultations">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-clipboard-data"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.consultation')</span>
                    </a>
                </li>
                    @endif
            @if(session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere' || session('role') == 'laborantin') 
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesordonnances">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-file-text"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.ordonnance')</span>
                    </a>
                </li>
            @endif
                    @if(session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere')
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesRDV">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-calendar-check"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.rendez-vous')</span>
                    </a>
                </li>
                    @endif
                @if(session('role') == 'laborantin' || session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere')
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesexamens">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-clipboard-data"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.examens')</span>
                    </a>
                </li>
                @endif
                    @if(session('role') == 'laborantin' || session('role') == 'pharmacien' || session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere')
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listemedicaments">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-capsule"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.medicaments')</span>
                    </a>
                </li>
                    @endif
                    @if(session('role') == 'admin' || session('role') == 'medecin' || session('role') == 'infirmiere')
                <li class="nav-item">
                    <a class="nav-link text-white " href="/planing">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-calendar-check"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.planing')</span>
                    </a>
                </li>
                    @endif
                @if(session('role') == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white " href="/listesCAs">
                        
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 bi bi-people-fill"></i>
                        </div>
                        
                        <span class="nav-link-text ms-1 font-weight-bold">@lang('messages.resources')</span>
                    </a>
                </li>
                @endif
            @if(session('role') == 'admin' || session('role') == 'pharmacien' || session('role') == 'laborantin' || session('role') == 'infirmiere' || session('role') == 'charge_acceuil' || session('role') == 'medecin') 
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
                <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">@lang('messages.connecte') <br/> {{ session('nomuser') }} </a>
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
                                Lang
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="locale/fr">Français</a>
                                <a class="dropdown-item" href="locale/en">English</a>
                                <a class="dropdown-item" href="locale/all">Allemand</a>
                                <a class="dropdown-item" href="locale/esp">Espagnol</a>
                                <a class="dropdown-item" href="locale/chin">Chinois</a>
                            </div>
                        </div>
                    </nav>
                    <nav aria-label="breadcrumb">
                    <a href="/login"> <i class="material-icons opacity-10 bi bi-box-arrow-right"></i>@lang('messages.deconnect') </a>
                    </nav>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('content')
    </main>
    
    <!-- <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                <h5 class="mt-3 mb-0">Material UI Configurator</h5>
                <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="material-icons">clear</i>
                </button>
                </div>
                End Toggle Button
            </div>
        </div>
    </div> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
            damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Inclure le fichier CSS Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Inclure le fichier JavaScript Bootstrap (jQuery requis) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
