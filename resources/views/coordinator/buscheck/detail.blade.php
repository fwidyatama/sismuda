@extends('layouts.app',['activePage'=>'buscheck'])
@section('title','Detail Order')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Verifikasi Pengecekan Bus</h1>
</div>
<div class="my-3">

    
    <form action="{{route('buscheck.verifyorder',$checkOrder->id)}}" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group " >
            <label for="name">Kode Lambung</label>
            <input class="form-control " value="{{$checkOrder->hull_code}}" disabled  placeholder="Kode Lambung" type="text" name="code" id="code" />
        </div>
        <div class="form-group ">
            <label for="name">Nama Petugas</label>
            <input class="form-control" placeholder="name" type="text" name="name" id="name"  disabled value ="{{$checkOrder->user->name}}"/>
        </div>

        <div class="form-group">
            <label for="complaint">Keluhan</label>
            <textarea disabled name="address" id="address"  class="form-control"> {{$checkOrder->complaint}}</textarea>
        </div>

        <div class="form-group ">
            <label for="name">Tanggal Pengajuan</label>
            <input class="form-control" placeholder="date" type="text" name="name" id="name"  disabled value ="{{$checkOrder->date}}"/>
        </div>

        <br />
        <button class="btn btn-primary" name="action" value="approve">Setuju</button> 
        <button class="btn btn-danger"  name="action"" value="reject">Tolak</button> 
    </form>
</div>

@endsection