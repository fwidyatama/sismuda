@extends('layouts.app',['activePage'=>'workshop'])
@section('title','Buat Surat Tugas')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Buat Surat Tugas</h1>
</div>
<div class="my-3">

    @if(session('error'))
    <div class="alert alert-danger">
      {{session('error')}}
    </div>
    @endif
    
    <form action="{{route('workshop.storeworkshop')}}" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nomor Surat</label><br>
           <input type="number" name="workshop_number"  id="workshop_number" class="form-control"/>
       </div>
        <div class="form-group">
            <label>Kode Lambung</label><br>
           <select name="hull_code" style="width: 100%" id="hull_code" class="form-control"></select>
       </div>

     
        <div class="form-group  {{ $errors->has('work_type') ? ' has-danger' : '' }}">
            <label for="work_type">Jenis Pekerjaan</label>
            <input type="text" name="work_type" class="form-control {{ $errors->has('work_type') ? ' is-invalid' : '' }}" value ="{{old('work_type')}}" />
            @include('layouts.alerts', ['field' => 'work_type'])
        </div>

        <div class="form-group">
             <label>User</label><br>
            <select style="width: 100%" name="user[]" multiple id="user" class="form-control"></select>
        </div>

        <div class="form-group  {{ $errors->has('note') ? ' has-danger' : '' }}">
            <label for="note">Keluhan</label>
            <textarea name="note" id="note"  class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}"> {{old('note')}}</textarea>
            @include('layouts.alerts', ['field' => 'note'])
        </div>

      

        <br />
        <input class="btn btn-primary" type="submit" value="Simpan" />
    </form>
</div>


@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('#user').select2({
        ajax: {
            url: 'http://localhost:8000/user',
            delay: 500,
            processResults: function (data) {
                return {
                    results: data.map((item)=>{
                        return {
                            id : item.id,
                            text : item.name
                        }
                    })
                }
            }
        }
    });
    });

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

</script>
@endpush