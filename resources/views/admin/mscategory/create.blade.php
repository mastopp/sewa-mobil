@extends('admin.layouts.main')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                
                @if(session()->has('error'))
                  <div class="alert alert-danger alert-dismissable fade show" role="alert">
                    {{ $session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                  </div>
                @endif
                <form action="/admin/mscategory" method="POST" class="row">
                    @csrf
                  <div class="col-12">
                    <div class="form-group row mb-3">
                      <div class="col-2">
                        <label class="font-weight-bold">Name</label>
                      </div>
                      <div class="col-10">
                        <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                        @error('name')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>                    
                  </div>

                  <div class="btn-group">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                    <button type="reset" class="btn btn-warning">RESET</button>
                    
                  </div>

                </form> 
            </div>
        </div>
    </div>
</div>
@endsection()
@section('js')
@endsection()