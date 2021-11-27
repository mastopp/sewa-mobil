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
    <div class="col-2"><a href="/admin/mscategory/create" class="btn btn-dark"><span data-feather="plus"></span> Add New</a></div>
    <div class="col-10 me-auto">
      <form method="GET" action="/admin/mscategory">
        
        <div class="form-group">
          <div class="col-12">
            <div class="btn-group d-flex">
              <div class="col-6">
                <input type="text" name="keyword" class="form-control" placeholder="keyword pencarian" value="{{ Request::get('keyword') }}">                
              </div>
              <div class="col-6 me-auto">
                <button type="submit" class="btn btn-dark"><span data-feather="search"></span> Search</button>
                @if(Request::input())
                <a href="/admin/mscategory" class="btn btn-dark"><span data-feather="x-circle"></span> Reset</a>
                @endif
              </div>
          
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
          <th scope="col">Name</th>
          <th scope="col">Aksi</th>
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
          <td>{{ $d->name }}</td>
          <td>
            <a class="btn btn-sm btn-success" href="/admin/mscategory/{{ $d->id }}"><span data-feather="edit"></span> Edit</a>

            <form style="display:inline-block" onsubmit="return confirm('Are you Sure ?');" action="/admin/mscategory/{{ $d->id }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-sm btn-danger"><span data-feather="x-circle"></span>  Delete</button>
            </form>
          </td>
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