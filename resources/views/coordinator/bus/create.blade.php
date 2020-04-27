@extends('layouts.app',['activePage'=>'bus'])
@section('title','Tambah Bus')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Tambah Bus</h1>
</div>
<div class="my-3">

    
    <form action="{{route('bus.storebus')}}" class="bg-white shadow-sm p-3" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group {{ $errors->has('brand') ? ' has-danger' : '' }}" >
            <label for="name">Merek</label>
            <input class="form-control {{ $errors->has('brand') ? ' is-invalid' : '' }}" value="{{ old('brand') }}"  placeholder="Merek" type="text" name="brand" id="brand" />
            @include('layouts.alerts', ['field' => 'brand'])
        </div>

        <div class="form-group  {{ $errors->has('type') ? ' has-danger' : '' }}">
            <label for="role">Jenis Bus</label>
            <br />
            <input type="radio" name="type" id="koordinator" value="regular" />
            <label for="Regular">Regular</label>
            <br />
            <input type="radio" name="type" id="mekanik" value="pariwisata" />
            <label for="Pariwisata">Pariwisata</label>
            <br />
            @include('layouts.alerts', ['field' => 'type'])
        </div>

        <div class="form-group {{ $errors->has('police_number') ? ' has-danger' : '' }}">
            <label for="police_number">Nomor Polisi</label>
            <input type="text" name="police_number" class="form-control {{ $errors->has('police_number') ? ' is-invalid' : '' }}" value ="{{old('police_number')}}" />
            @include('layouts.alerts', ['field' => 'police_number'])
        </div>

        <div class="form-group  {{ $errors->has('hull_code') ? ' has-danger' : '' }}">
            <label for="hull_code">Kode Lambung</label>
            <input type="text" name="hull_code" class="form-control {{ $errors->has('hull_code') ? ' is-invalid' : '' }}" value ="{{old('hull_code')}}" />
            @include('layouts.alerts', ['field' => 'hull_code'])
        </div>


        <div class="form-group  {{ $errors->has('license_date') ? ' has-danger' : '' }}">
            <label for="address">Tanggal Berakhir STNK</label><br />
          
            <input type='text' class="form-control {{ $errors->has('license_date') ? ' is-invalid' : '' }}" data-date-language="id" id='datepicker' name="license_date"  value ="{{old('license_date')}}">
            @include('layouts.alerts', ['field' => 'license_date'])
          </div>

        <br />
        <input class="btn btn-primary" type="submit" value="Save" />
    </form>
</div>


@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
       $('#datepicker').datepicker({
        "format": "dd-mm-yyyy",
        "keyboardNavigation": false
       }); 
      });
      </script>
@endpush