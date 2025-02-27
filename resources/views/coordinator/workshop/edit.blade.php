@extends('layouts.app',['activePage'=>'workshop'])
@section('title','Edit Surat Tugas')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Edit Surat Tugas</h1>
</div>
<div class="my-3">

  
    <form action="{{route('workshop.updateworkshop',4)}}" class="bg-white shadow-sm p-3" method="POST"
    enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="form-group">
            <label>Kode Lambung</label><br>
           <select name="hull_code"  id="hull_code" class="form-control"></select>
       </div>

        <div class="form-group  {{ $errors->has('work_type') ? ' has-danger' : '' }}">
            <label for="work_type">Jenis Pekerjaan</label>
            <input type="text" name="work_type" class="form-control {{ $errors->has('work_type') ? ' is-invalid' : '' }}" value ="{{$workshops[0]['work_type']}}" />
            @include('layouts.alerts', ['field' => 'work_type'])
        </div>

        <div class="form-group">
             <label>User</label><br>
            <select name="user[]" multiple id="user" class="form-control"></select>
        </div>


        <div class="form-group  {{ $errors->has('note') ? ' has-danger' : '' }}">
            <label for="note">Keluhan</label>
            <textarea name="note" id="note"  class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}"> {{$workshops[0]['detail']}}</textarea>
            @include('layouts.alerts', ['field' => 'note'])
        </div>

      

        <br />
        <input class="btn btn-primary" type="submit" value="Save" />
    </form>
</div>


@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('#user').select2({
        ajax: {
            url: 'http://127.0.0.1:8000/workshop/user',
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

    $(hull_code).ready(function(){
        $('#hull_code').select2({
        ajax: {
            url: 'http://127.0.0.1:8000/workshop/bus',
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

    var workshop =   {!! json_encode($workshops) !!};

    workshop.forEach(user=>{
        var option = new Option(user.hull_code,user.hull_code,true,true)
        $('#hull_code').append(option).trigger('change');
    })
    
    workshop.forEach(user=>{
        console.log(user)
        var option = new Option(user.name,user.id,true,true)
        $('#user').append(option).trigger('change');
    })

</script>
@endpush