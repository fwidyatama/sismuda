@extends('layouts.app',['activePage'=>'buspermit'])
@section('title','Izin Surat Keluar')
@section('content')


@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Bukti Selesai perbaikan</h1>
</div>
<div class="my-3">

    @if(session('error'))
    <div class="alert alert-danger">
      {{session('error')}}
    </div>
    @endif
    <form action="{{route('permits.store')}}" class="bg-white shadow-sm p-3" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Kode Lambung</label><br>
           <select name="hull_code"  id="hull_code" class="form-control"></select>
       </div>

        <div class="form-group {{ $errors->has('workshopnumber') ? ' has-danger' : '' }}"> 
            <label>Nomor Surat Tugas</label>
            <br> 
            <select name="workshopnumber" id="workshopnumber" class="form-control"> 
                <option value="">Pilih Surat Tugas</option>
                 @foreach ($workshopsNumber as $number) 
                 <option value="{{$number->workshop_number}}">
                    {{$number->workshop_number}}
                </option>
                @endforeach
            </select>
            @include('layouts.alerts', ['field' => 'workshopnumber'])
        </div>


        <div class="form-group  {{ $errors->has('note') ? ' has-danger' : '' }}">
            <label for="note">Catatan</label>
            <textarea name="note" id="note"
                class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}"> {{old('note')}}</textarea>
            @include('layouts.alerts', ['field' => 'note'])
        </div>



        <div class="form-group">
            <input type="checkbox" id="checkbox"/>
            <label class="form-check-label">Saya menyatakan bahwa kendaraan telah diperbaiki sesuai dengan laporan surat tugas</label>
        </div>
        
        <input class="btn btn-primary" type="submit" id="acceptbutton" value="Simpan" disabled="disabled"/>
    </form>
</div>


@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
var checker = document.getElementById('checkbox');
var sendbtn = document.getElementById('acceptbutton');
 // when unchecked or checked, run the function
 checker.onchange = function(){
if(this.checked){
    sendbtn.disabled = false;
} else {
    sendbtn.disabled = true;
}

}


    $(hull_code).ready(function () {
        $('#hull_code').select2({
            ajax: {
                url: 'http://localhost:8000/bus',
                delay: 500,
                processResults: function (data) {
                    return {
                        results: data.map((item) => {
                            return {
                                id: item.hull_code,
                                text: item.hull_code
                            }
                        })
                    }
                }
            }
        });
    });

</script>
@endpush