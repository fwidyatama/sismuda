@extends('layouts.app',['activePage'=>'user'])
@section('title','Edit karyawan')
@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif
<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Karyawan</h1>
</div>
<div class="my-3">
    @if(session('error'))
    <div class="alert alert-danger">
      {{session('error')}}
    </div>
    @endif
    <form action="{{ route('updateprofile',[$user->id]) }}" id="profile" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}" >
            <label for="name">Nama Lengkap</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $user->name }}"  placeholder="Nama" type="text" name="name" id="name" />
            @include('layouts.alerts', ['field' => 'name'])
        </div>

        <div class="form-group {{ $errors->has('username') ? ' has-danger' : '' }}">
            <label for="username">Username</label>
            <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" type="text" name="username" id="username" value ="{{$user->username}}"/>
            @include('layouts.alerts', ['field' => 'username'])
        </div>

        <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email">Email</label>
            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="mail@mail.com" type="email" name="email" id="username" value ="{{$user->email}}"/>
            @include('layouts.alerts', ['field' => 'email'])
        </div>

        <div class="form-group  {{ $errors->has('role') ? ' has-danger' : '' }}">
            <label for="role">Role</label>
            <br />
            <input disabled type="radio" name="role" id="koordinator" value="1"  {{ $user->id_role == 1 ? 'checked' : '' }} />
            <label for="Koordinator Produksi">Koordinator Produksi</label>
            <br />
            <input disabled type="radio" name="role" id="mekanik" value="2"  {{ $user->id_role == 2 ? 'checked' : '' }} />
            <label for="Petugas Mekanik">Petugas Mekanik</label>
            <br />
            <input disabled type="radio" name="role" id="logistik" value="3" {{ $user->id_role == 3 ? 'checked' : '' }}/>
            <label for="Petugas Logistik">Petugas Mekanik</label>
            <br /> 
            <input disabled type="radio" name="role" id="kru" value="4"  {{ $user->id_role == 4 ? 'checked' : '' }}/>
            <label for="kru bus">Kru Bus</label>
            @include('layouts.alerts', ['field' => 'role'])
        </div>

        <div class="form-group {{ $errors->has('phone') ? ' has-danger' : '' }}">
            <label for="phone">Nomor Telefon</label>
            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value ="{{$user->phone_number}}" />
            @include('layouts.alerts', ['field' => 'phone'])
        </div>

        <div class="form-group  {{ $errors->has('address') ? ' has-danger' : '' }}">
            <label for="address">Alamat</label>
            <textarea name="address" id="address"  class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"> {{$user->address}}</textarea>
            @include('layouts.alerts', ['field' => 'address'])
        </div>

        <div class="form-group">
            <label for="address">Keahlian(jika ada)</label>
            <br/>
            <small>Isi dengan - jika tidak ada</small>
            <input type="text" name="expertness" class="form-control {{ $errors->has('expertness') ? ' is-invalid' : '' }}" value ="{{$user->expertness}}" />
        </div>
      

        <br />
        <input class="btn btn-primary"  type="submit" value="Simpan" />
    </form>
</div>

@endsection


