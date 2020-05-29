
@extends('layouts.app',['activePage'=>'mutation'])
@section('title','Mutasi Sparepart')
@section('content')

@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Mutasi</h1>
</div>
<div class="my-3">
    @if(session('error'))
    <div class="alert alert-danger">
      {{session('error')}}
    </div>
    @endif
    
    <form action="{{route('mutation.store')}}" id="field" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf
        

       <div class="form-group">
       <div class="table-responsive" id="form-order">
           <table class="table table-bordered table-striped" id="user_table">

           <tbody>
            <div class="form-group"> <label>Barang</label><br> <select name="sparepart[]" id="sparepart" class="form-control">
                <option value="">Pilih Suku Cadang</option>
                @foreach ($spareparts as $sparepart) 
                <option value="{{$sparepart->id}}">{{$sparepart->name}}
                </option>
                @endforeach
            </select>

        </div>
            <div class="form-group"><label for="quantity">Jumlah</label><input type="number" name="quantity[]" placeholder="Jumlah" class="form-control"/></div>
            <div class="form-group"> <label>Jenis Mutasi</label><br> <select name="status[]" id="status" class="form-control">
                <option value="">Pilih salah satu</option>
                <option value="entry">Masuk</option>
                <option value="out">Keluar</option>
            </select>
        </div>
           </tbody>

        </table>
       </div>
        <button type="button" name="add" id="add" class="btn btn-info btn-sm my-3">Tambah Data</button>

        
        <div class="form-group  {{ $errors->has('type') ? ' has-danger' : '' }}">
            <label for="jenis">Jenis Barang : </label> <br>
            <input type="radio" name="type" id="new" value="new" />
            <label for="new">Baru</label>
            <br />
            <input type="radio" name="type" id="second" value="second" />
            <label for="second">Bekas</label>
            @include('layouts.alerts', ['field' => 'type'])
        </div>


        <input class="btn btn-primary" type="submit" value="Simpan" />
    </form>
    
</div>



@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
$(document).ready(function(){

    var count = 1;
$(document).on('click', '#add', function(){
  count++;
  $('#form-order').append('<div class="form-group" id="row'+i+'"> <label>Barang</label><br> <select name="sparepart[]" id="sparepart" class="form-control"> @foreach ($spareparts as $sparepart) <option value="{{$sparepart->id}}">{{$sparepart->name}}</option>@endforeach</select></div>')
  $('#form-order').append('<div class="form-group"  id="row'+i+'"><label for="quantity">Jumlah</label><input type="number" name="quantity[]" placeholder="Jumlah" class="form-control"/></div>')
  $('#form-order').append('<div class="form-group"> <label>Jenis Mutasi</label><br> <select name="status[]" id="status" class="form-control"><option value="">Pilih salah satu</option><option value="entry">Masuk</option><option value="out">Keluar</option></select>')
 });

 

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
});

    </script>
@endpush
