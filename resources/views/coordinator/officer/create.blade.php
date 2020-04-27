@extends('layouts.app',['activePage'=>'user'])
@section('title','Tambah karyawan')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Tambah Karyawan</h1>
</div>
<div class="my-3">

    
    <form action="{{ route('user.storeofficer') }}" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}" >
            <label for="name">Nama Lengkap</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"  placeholder="Nama" type="text" name="name" id="name" />
            @include('layouts.alerts', ['field' => 'name'])
        </div>

        <div class="form-group {{ $errors->has('username') ? ' has-danger' : '' }}">
            <label for="username">Username</label>
            <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" type="text" name="username" id="username" value ="{{old('username')}}"/>
            @include('layouts.alerts', ['field' => 'username'])
        </div>

        <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email">Email</label>
            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="mail@mail.com" type="email" name="email" id="username" value ="{{old('email')}}"/>
            @include('layouts.alerts', ['field' => 'email'])
        </div>

        <div class="form-group  {{ $errors->has('role') ? ' has-danger' : '' }}">
            <label for="role">Role</label>
            <br />
            <input type="radio" name="role" id="koordinator" value="1" />
            <label for="Koordinator Produksi">Koordinator Produksi</label>
            <br />
            <input type="radio" name="role" id="mekanik" value="2" />
            <label for="Petugas Mekanik">Petugas Mekanik</label>
            <br />
            <input type="radio" name="role" id="logistik" value="3" />
            <label for="Petugas Logistik">Petugas Logistik</label>
            <br />
            <input type="radio" name="role" id="kru" value="4" />
            <label for="kru bus">Kru Bus</label>
            @include('layouts.alerts', ['field' => 'role'])
        </div>

        <div class="form-group {{ $errors->has('phone') ? ' has-danger' : '' }}">
            <label for="phone">Nomor Telefon</label>
            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value ="{{old('phone')}}" />
            @include('layouts.alerts', ['field' => 'phone'])
        </div>

        <div class="form-group  {{ $errors->has('address') ? ' has-danger' : '' }}">
            <label for="address">Alamat</label>
            <textarea name="address" id="address"  class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"> {{old('address')}}</textarea>
            @include('layouts.alerts', ['field' => 'address'])
        </div>

        <div class="form-group">
            <label for="address">Keahlian(jika ada)</label><br />
            <small>Isi dengan - jika tidak ada</small>
            <input name="expertness" id="expertness" class="form-control" />
        </div>

        <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
            <label for="password">Password</label>
            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="password" type="password" name="password" id="password" />
            @include('layouts.alerts', ['field' => 'password'])
        </div>

        <br />
        <input class="btn btn-primary" type="submit" value="Save" />
    </form>
</div>

@endsection