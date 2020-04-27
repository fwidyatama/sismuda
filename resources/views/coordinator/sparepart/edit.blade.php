@extends('layouts.app',['activePage'=>'sparepart'])
@section('title','Tambah Sparepart')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Edit</h1>
</div>
<div class="my-3">

    
    <form action="{{ route('sparepart.updatesparepart',[$sparepart->id]) }}" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group {{ $errors->has('code') ? ' has-danger' : '' }}" >
            <label for="name">Kode Barang</label>
            <input class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" value="{{ $sparepart->code }}"  placeholder="Kode Barang" type="text" name="code" id="code" />
            @include('layouts.alerts', ['field' => 'code'])
        </div>

        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
            <label for="name">Nama Barang</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="name" type="text" name="name" id="name" value ="{{$sparepart->name}}"/>
            @include('layouts.alerts', ['field' => 'name'])
        </div>

        <div class="form-group {{ $errors->has('brand') ? ' has-danger' : '' }}">
            <label for="brand">Merek</label>
            <input class="form-control {{ $errors->has('brand') ? ' is-invalid' : '' }}" placeholder="Merek" type="text" name="brand" id="brand" value ="{{$sparepart->brand}}"/>
            @include('layouts.alerts', ['field' => 'brand'])
        </div>

        <div class="form-group {{ $errors->has('quantity') ? ' has-danger' : '' }}">
            <label for="quantity">Jumlah</label>
            <input type="number" name="quantity" placeholder="Jumlah" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value ="{{$sparepart->quantity}}" />
            @include('layouts.alerts', ['field' => 'quantity'])
        </div>

        
        <div class="form-group {{ $errors->has('unit_name') ? ' has-danger' : '' }}">
            <label for="unit_name">Satuan</label>
            <input class="form-control {{ $errors->has('unit_name') ? ' is-invalid' : '' }}" value ="{{$sparepart->unit_name}}" placeholder="Nama Satuan" type="text" name="unit_name" id="unit_name" />
            @include('layouts.alerts', ['field' => 'unit_name'])
        </div>

        <div class="form-group {{ $errors->has('price') ? ' has-danger' : '' }}">
            <label for="price">Harga Satuan</label>
            <input class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="Harga" value ="{{$sparepart->price}}" type="text" name="price" id="price" />
            @include('layouts.alerts', ['field' => 'price'])
        </div>
       

        <br />
        <input class="btn btn-primary" type="submit" value="Save" />
    </form>
</div>

@endsection