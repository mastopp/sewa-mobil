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
                <form action="/admin/transaction" method="POST" class="row">
                    @csrf
                  <div class="col-6">
                    <div class="form-group row mb-3">
                      <div class="col-2">
                        <label class="font-weight-bold">Description</label>
                      </div>
                      <div class="col-10">
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>                    
                  </div>
                  <div class="col-6">
                    <div class="form-group row mb-3">
                      <div class="col-2">
                        <label class="font-weight-bold">Code</label>                        
                      </div>
                      <div class="col-10">
                        <select class="form-control form-select @error('code') is-invalid @enderror" name="code">
                          <option value="123456" {{ (old('code') == '123456') ? 'selected' : ''  }}>123456</option>
                          <option value="7890" {{ (old('code') == '7890') ? 'selected' : ''  }}>7890</option>
                        </select>
                        <!-- error message untuk code -->
                        @error('code')
                          <div class="invalid-feedback mt-2">
                              {{ $message }}
                          </div>
                        @enderror                        
                      </div>
                    </div>

                    <div class="form-group row mb-3">
                      <div class="col-2">
                        <label class="font-weight-bold">Rate Euro</label>
                      </div>
                      <div class="col-10">
                        <input type="number" class="form-control @error('rate_euro') is-invalid @enderror" name="rate_euro" value="{{ old('rate_euro') }}" >
                        <!-- error message untuk rate_euro -->
                        @error('rate_euro')
                          <div class="invalid-feedback mt-2">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>                    
                    <div class="form-group row mb-3">
                      <div class="col-2">
                        <label class="font-weight-bold">Date Paid</label>
                      </div>
                      <div class="col-10">
                        <input type="date" class="form-control @error('date_paid') is-invalid @enderror" name="date_paid" value="{{ old('date_paid') }}" >                    
                        <!-- error message untuk rate_euro -->
                        @error('date_paid')
                          <div class="invalid-feedback mt-2">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>                    
                  </div>

                  <div class="container">
                    <div class="card bg-default mb-3">
                      <div class="card-header bg-default">Data Transaksi
                        <!-- <div class="col-2">
                          <a class="btn btn-dark new-trans"><span data-feather="plus"></span> New</a>
                        </div> -->
                      </div>
                      <div class="card-body text-dark">
                        <div class="card container mb-3" id="transaction">
                          <div class="form-group row mt-3 mb-3">
                            <div class="col-3">
                              <label class="">Category</label>
                            </div>
                            <div class="col-7">
                              <select class="form-control form-select mb-3" name="kategori[]">
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                              </select>

                              <table class="table table-striped table-bordered" id="tabel-dt">
                                <tr>
                                  <th>Nama Transaksi</th>
                                  <th>Nominal (IDR)</th>
                                  <th></th>
                                </tr>
                                <tr>
                                  <td>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name[0][]" value="{{ old('name') }}" required> 
                                    @error('name')
                                      <div class="invalid-feedback mt-2">
                                          {{ $message }}
                                      </div>
                                    @enderror
                                  </td>
                                  <td>
                                    <input class="form-control @error('value_idr') is-invalid @enderror" type="number" name="value_idr[0][]" value="{{ old('value_idr') }}" required>
                                    @error('value_idr')
                                      <div class="invalid-feedback mt-2">
                                          {{ $message }}
                                      </div>
                                    @enderror
                                  </td>
                                  <td>
                                    
                                  <a class="btn btn-dark new-dt" data-id="0" onClick="add()"><span data-feather="plus"></span> New</a>
                                  </td>
                                
                                
                                </tr>
                              </table>
                            </div>
                          </div>
                          
                        </div>
                        <div class="card container mb-3">
                          <div class="form-group row mt-3 mb-3">
                            <div class="col-3">
                              <label class="">Category</label>
                            </div>
                            <div class="col-7">
                              <select class="form-control form-select mb-3" name="kategori[]">
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ ($k->id == '2') ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                              </select>

                              <table class="table table-striped table-bordered tabel-dt">
                                <tr>
                                  <th>Nama Transaksi</th>
                                  <th>Nominal (IDR)</th>
                                  <th></th>
                                </tr>
                                <tr>
                                  <td>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name[1][]" value="{{ old('name') }}" required> 
                                    @error('name')
                                      <div class="invalid-feedback mt-2">
                                          {{ $message }}
                                      </div>
                                    @enderror
                                  </td>
                                  <td>
                                    <input class="form-control @error('value_idr') is-invalid @enderror" type="number" name="value_idr[1][]" value="{{ old('value_idr') }}" required>
                                    @error('value_idr')
                                      <div class="invalid-feedback mt-2">
                                          {{ $message }}
                                      </div>
                                    @enderror
                                  </td>
                                  <td>
                                    <a class="btn btn-dark new-dt" data-id="1" onClick="add()"><span data-feather="plus"></span> New</a>
                                  </td>
                                </tr>
                              </table>
                            </div>
                          </div>
                          
                        </div>
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
<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
<script>
    $(document).ready(function () {
        $(".new-trans").click(function() {
          $("div#transaction").clone().insertAfter("div.card:last").append('<a class="btn btn-danger remove" onClick="removeCat()">x</a>');
        });
        $(".new-dt").click(function(e){
          var id = $(this).attr('data-id');
            $(this).closest('tr').parent().append('<tr><td><input class="form-control" type="text" name="name['+id+'][]" required></td><td><input class="form-control" type="number" name="value_idr['+id+'][]" required></td><td><a class="btn btn-danger remove" onClick="remove()">x</a></td></tr>'); 
        });

    });
    function remove() {
      $('td .remove').click(function(e){
          $(this).closest('tr').remove();
      });
    }



</script>
@endsection()