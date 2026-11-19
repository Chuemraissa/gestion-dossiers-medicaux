@extends('layouts.app')
      
      @section('title')
    @lang('messages.aide')
      @endsection
      
      @section('content')
      <div class="container-fluid py-5">
      
        <p>{{ __('Pour tout problème, veuillez contacter le numéro suivant :') }}</p>
        <h6>{{ \App\Models\Parametre::valeur('support_telephone') }}</h6>
      
      </div>
        @endsection