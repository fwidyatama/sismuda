@extends('layouts.app',['activePage'=>'buscheck'])
@section('title','Pengecekan Bus')
@section('content')

@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Ajukan pengecekan</h1>
</div>
<div class="my-3">

    
    <form action="{{ route('buscheck.storecheck') }}" id="field" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Kode Lambung</label><br>
           <select name="hull_code"  id="hull_code" class="form-control"></select>
       </div>
        
       <div class="form-group  {{ $errors->has('complaint') ? ' has-danger' : '' }}">
        <label for="complaint">Keluhan</label>
        <textarea name="complaint" id="complaint"  class="form-control {{ $errors->has('complaint') ? ' is-invalid' : '' }}"> {{old('complaint')}}</textarea>
        @include('layouts.alerts', ['field' => 'complaint'])
    </div>

        <input class="btn btn-primary" type="submit" value="Save" />
    </form>
</div>



@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>

$(document).ready(function(){
    var i = 0;
        $(hull_code).ready(function(){
        $('#hull_code').select2({
        ajax: {
            url: 'http://localhost:8000/bus',
            delay: 500,
            processResults: function (data) {
                return {
                    results: data.map((item)=>{
                        return {
                            id : item.hull_code,
                            text : item.hull_code
                        }
                    })
                }
            }
        }
    });
    });

})

    </script>
@endpush