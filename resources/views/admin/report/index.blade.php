@extends('admin.layouts.main')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
  </div>
  <div class="row">
    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissable fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
      </div>
    @endif
    
    <div class="col-10 me-auto">
      <form method="GET" action="/admin/report">
        
        <div class="form-group row">
          <div class="col-12">
            <div class="input-group">
              
            <input type="date" value="{{ Request::get('start') }}" name="start" class="form-control" title="start Date">        

            <input type="date" value="{{ Request::get('end') }}" name="end" class="form-control" title="End Date">
            
            <select class="form-control form-select" name="kategori">
              <option value="">All</option>
              @foreach($kategori as $k)
              <option value="{{ $k->id }}" {{ (Request::get('kategori') == $k->id) ? 'selected' : ''  }}>{{ $k->name }}</option>
              @endforeach
            </select>

            <input type="text" name="keyword" class="form-control" placeholder="keyword pencarian" value="{{ Request::get('keyword') }}">
          
            <button type="submit" class="btn btn-sm btn-dark form-control"><span data-feather="search"></span> Search</button>
            <a href="/admin/report" class="btn btn-sm btn-dark form-control"><span data-feather="x-circle"></span> Reset</a>         
          </div>
        </div>
      </form>
    </div>
    
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Date Paid</th>
          <th scope="col">Kategori</th>
          <th scope="col">Nominal(IDR)</th>

        </tr>
      </thead>
      <tbody>
        @if($data->total() == '0')
        <tr>
          <td colspan="11">
            <label class="alert alert-danger alert-dismissable fade show" role="alert">
              Data not found.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </label>
            
          </td>
        </tr>
        @endif
        @foreach($data as $k => $d)
        <tr>
          <td>{{ $k+1 }}</td>
          <td>{{ Carbon\Carbon::parse($d->date_paid)->format('d M Y') }}</td>
          <td>{{ $d->kategori }}</td>
          <td>{{ $d->value_idr }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="d-flex flex-row">
      <span class="pt-3">Menampilkan {{ $data->lastPage() == '1' ? $data->total() : $data->perPage()*$data->currentPage()  }} dari {{ $data->total() }} Data</span>
    </div>
    <div class="d-flex flex-row-reverse">
      {{ $data->links() }}
    </div>
  </div>
@endsection()