    @extends('layouts.app')
      
      @section('title')
    @lang('messages.modif')
      @endsection
      
      @section('content')
      <div class="container-fluid py-5">
      
        <div class="tabs">
          <div class="tab-item active">{{ __('Modifier un examen') }}</div>
        </div>
        <div class="tab-content">
          <div class="tab-pane active">
              <div class="modal-content">
                    <!-- Formulaire de remplissage -->
                    <form action="/update/examens" method="POST">
                        @csrf
             
                        @foreach ($errors->all() as $error)
                          <h1 class="alert alert-danger"> {{ $error }} </h1>
                        @endforeach

                        <input type="text" name="id" style="display: none;" value="{{ $examens->id }}">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="type">{{ __('Type') }}</label>
                            <select class="form-control" id="type" name="type_examen">
                              <x-options-liste liste="types_examen" :selection="$examens->type" />
                            </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="description">{{ __('Description') }}</label>
                          <textarea class="form-control" name="description_examen" id="description">{{ $examens->description }}</textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="cout">{{ __('Coût') }}</label>
                          <input type="number" class="form-control" value="{{ $examens->cout }}" name="cout" id="cout">
                        </div>
                    </div>
                    <div class="modal-footer">
                            <a href="/listesexamens" class="btn btn-secondary">{{ __('Annuler') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
                    </div>
                        </form>
              </div>
          </div>
        </div>
      
      </div>
        @endsection