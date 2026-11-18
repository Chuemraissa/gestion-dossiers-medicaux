@extends('layouts.app')
            
@section('title')
    acceuil
@endsection

@section('content')
<div class="row">
    <div class="col-lg-7 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-5 col-sm-5 mt-4 ml-5">
                <div class="card mb-5">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10 bi bi-person-fill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <h4 class="mb-0">{{ $patientCount }}</h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">

                    <div class="card-footer p-3">
                        <p class="mb-0 text-center">@lang('messages.patients')</p>
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10 bi bi-calendar-check"></i>
                        </div>
                        <div class="text-end pt-1">
                            <h4 class="mb-0">{{ $rdvCount }}</h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0 text-center">@lang('messages.rendez-vous')</p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10 bi bi-person-fill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <h4 class="mb-0">{{ $medCount }}</h4>
                        </div>
                    </div>

                    <hr class="dark horizontal my-0">

                    <div class="card-footer p-3">
                        <p class="mb-0 text-center">@lang('messages.medicaments')</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-sm-5 mt-4 ml-5">
                <div class="card  mb-5">
                    <div class="card-header p-3 pt-2 bg-transparent">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10 bi bi-person-fill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <h4 class="mb-0 ">{{ $medecinCount }}</h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">

                    <div class="card-footer p-3">
                        <p class="mb-0 text-center">@lang('messages.medecin')</p>
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-header p-3 pt-2 bg-transparent">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10 bi bi-person-fill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <h4 class="mb-0 ">{{ $consulterCount }}</h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">

                    <div class="card-footer p-3">
                        <p class="mb-0 text-center">@lang('messages.consultation')</p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header p-3 pt-2 bg-transparent">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10 bi bi-person-fill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <h4 class="mb-0 ">{{ $examenCount }}</h4>
                        </div>
                    </div>

                    <hr class="horizontal my-0 dark">

                    <div class="card-footer p-3">
                        <p class="mb-0 text-center">@lang('messages.examens')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection