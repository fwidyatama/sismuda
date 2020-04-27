
@extends('layouts.app')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   {{-- Form --}}
   <div class="card mb-12">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary" style="font-size: 17pt">Pengajuan Pengecekan Bus</h6>
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('bus.store')}}">
          @csrf
          <div class="form-group">
            <label for="kodelambung">Kode Lambung Bus</label>
            <select class="form-control" >
                <option>Pilih Kode Lambung Bus</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
              </select>
          </div>
        <div class="form-group">
            <label for="nomorpolisi">Nomor Polisi</label>
            <input type="text" class="form-control" name="nomorpolisi" id="nomorpolisi" placeholder="Masukkan nomor polisi">
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Keluhan</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Masukkan keluhan"></textarea>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Catatan</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Masukkan catatan"></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>




@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
@endsection
