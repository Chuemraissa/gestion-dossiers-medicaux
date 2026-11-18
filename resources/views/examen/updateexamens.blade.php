    @extends('layouts.app')
      
      @section('title')
          update
      @endsection
      
      @section('content')
      <div class="container-fluid py-5">
      
        <div class="tabs">
          <div class="tab-item active">modifier une examen</div>
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
                            <label class="form-label" for="type">Type</label>
                            <select class="form-control" id="type" name="type_examen">
                              <option value="{{ $examens->type }}">{{ $examens->type }}</option>
                            @if ($examens->type == 'biopsies')
                              <option value="neurophysiologiques">neurophysiologiques</option>
                              <option value="echographie">Échographie</option>
                              <option value="bacteriologique">bacteriologique</option>
                              <option value="autres">Autres...</option>
                              @endif
                            @if ($examens->type == 'neurophysiologiques')
                              <option value="biopsies">Biopsies</option>
                              <option value="echographie">Échographie</option>
                              <option value="bacteriologique">bacteriologique</option>
                              <option value="autres">Autres...</option>
                              @endif
                            @if ($examens->type == 'echographie')
                              <option value="biopsies">Biopsies</option>
                              <option value="neurophysiologiques">neurophysiologiques</option>
                              <option value="bacteriologique">bacteriologique</option>
                              <option value="autres">Autres...</option>
                              @endif
                            @if ($examens->type == 'bacteriologique')
                              <option value="biopsies">Biopsies</option>
                              <option value="neurophysiologiques">neurophysiologiques</option>
                              <option value="echographie">Échographie</option>
                              <option value="autres">Autres...</option>
                              @endif
                            @if ($examens->type == 'autres')
                              <option value="biopsies">Biopsies</option>
                              <option value="neurophysiologiques">neurophysiologiques</option>
                              <option value="echographie">Échographie</option>
                              <option value="bacteriologique">bacteriologique</option>
                              @endif
                            </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="description">Description</label>
                          <textarea class="form-control" name="description_examen" id="description">{{ $examens->description }}</textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="cout">Coût</label>
                          <input type="number" class="form-control" value="{{ $examens->cout }}" name="cout" id="cout">
                        </div>
                    </div>
                    <div class="modal-footer">
                            <a href="/listesexamens" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                        </form>
              </div>
          </div>
        </div>
      
      </div>
        @endsection