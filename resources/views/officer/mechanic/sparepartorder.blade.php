@extends('layouts.app',['activePage'=>'sparepartorder'])
@section('title','Order Sparepart')
@section('content')

@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Ajukan Sparepart</h1>
</div>
<div class="my-3">

    
    <form action="{{ route('order.storeorder') }}" id="field" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Kode Lambung</label><br>
           <select name="hull_code"  id="hull_code" class="form-control"></select>
       </div>

       <div class="form-group">
        <label>Barang</label><br>
       <select name="sparepart" id="sparepart" class="form-control"></select>
        </div>

        <div class="form-group {{ $errors->has('quantity') ? ' has-danger' : '' }}">
            <label for="quantity">Jumlah</label>
            <input type="number" name="quantity" placeholder="Jumlah" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value ="{{old('quantity')}}" />
            @include('layouts.alerts', ['field' => 'quantity'])
        </div>

        
        <div class="form-group {{ $errors->has('unit_name') ? ' has-danger' : '' }}">
            <label for="unit_name">Satuan</label>
            <input class="form-control {{ $errors->has('unit_name') ? ' is-invalid' : '' }}" placeholder="Nama Satuan" value ="{{old('unit_name')}}" type="text" name="unit_name" id="unit_name" />
            @include('layouts.alerts', ['field' => 'unit_name'])
        </div>

        
        <div class="form-group  {{ $errors->has('type') ? ' has-danger' : '' }}">
            <label for="jenis">Jenis : </label> <br>
            <input type="radio" name="type" id="new" value="1" />
            <label for="new">Baru</label>
            <br />
            <input type="radio" name="type" id="kru" value="0" />
            <label for="second">Bekas</label>
            @include('layouts.alerts', ['field' => 'type'])
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
            url: 'http://localhost:8000/workshop/bus',
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

         $(sparepart).ready(function(){
        $('#sparepart').select2({
        ajax: {
            url: 'http://localhost:8000/order/getsparepart',
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
   


})

    </script>
@endpush