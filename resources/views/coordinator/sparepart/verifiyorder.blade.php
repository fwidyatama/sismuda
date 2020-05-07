@extends('layouts.app',['activePage'=>'order'])
@section('title','Tambah Sparepart')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Verifikasi Sparepart</h1>
</div>
<div class="my-3">

    
    <form action="{{route('order.verifyorder',$sparepart->id)}}" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group " >
            <label for="name">Kode Lambung</label>
            <input class="form-control " value="{{$sparepart->hull_code}}" disabled  placeholder="Kode Barang" type="text" name="code" id="code" />
        </div>

        <div class="form-group ">
            <label for="name">Nama Barang</label>
            <input class="form-control" placeholder="name" type="text" name="name" id="name"  disabled value ="{{$sparepart->sparepart_name}}"/>
        </div>
        <div class="form-group ">
            <label for="name">Nama petugas</label>
            <input class="form-control" placeholder="name" type="text" name="name" id="name"  disabled value ="{{$sparepart->user_name}}"/>
        </div>
        <div class="form-group ">
            <label for="name">Jumlah</label>
            <input class="form-control" placeholder="name" type="number" name="name" id="name"  disabled value ="{{$sparepart->quantity}}"/>
        </div>
        
        <div class="form-group ">
            <label for="name">Nama Satuan</label>
            <input class="form-control" placeholder="name" type="text" name="name" id="name"  disabled value ="{{$sparepart->unit_name}}"/>
        </div>

        <div class="form-group ">
            <label for="name">Tanggal Pengajuan</label>
            <input class="form-control" placeholder="date" type="text" name="name" id="name"  disabled value ="{{$sparepart->date}}"/>
        </div>
        <div class="form-group ">
            <label for="name">Jenis Suku Cadang</label>
            <input class="form-control" placeholder="name" type="text" name="name" id="name"  disabled value = @if ($sparepart->type=='new') Baru @else Bekas @endif/>
        </div>

      
       

        <br />
        <button class="btn btn-primary" name="action" value="approve">Setuju</button> 
        <button class="btn btn-danger"  name="action"" value="reject">Tolak</button> 
    </form>
</div>

@endsection