@extends('layouts.app',['activePage'=>'bus'])
@section('title','Dashboard Bus')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Bus</h1>

</div>
<div class="d-sm-flex float-right  ">
  <a href="{{route('bus.addbus')}}" class="btn btn-primary">Tambah Bus</a>
</div>

<div class="card shadow my-5">

  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr>
            <th>Merek</th>
            <th>Jenis</th>
            <th>Nomor Polisi</th>
            <th>Kode Lambung</th>
            <th>Tanggal Berakhir STNK</th>
            <th>Action</th>
          </tr>
        </thead>
        @if ($buses->count()==0)
        <tbody>
          <td colspan="6" style="text-align: center;padding-top: 3%">Belum ada data bus</td>
          @else
          @foreach ($buses as $bus)
          <tr>
            <td>{{$bus->brand}}</td>
            <td>{{$bus->type}}</td>
            <td>{{$bus->police_number}}</td>
            <td>{{$bus->hull_code}}</td>
            <td>{{date('d-m-Y', strtotime($bus->license_date))}}</td>
            <td>
              <a class="btn btn-info text-white btn-sm" href="{{route('bus.editbus',[$bus->hull_code])}}">Edit</a>
              <a href="#" hullcode="{{$bus->hull_code}}" id="delete-bus" class="btn btn-danger btn-sm delete-bus">Hapus</a>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>

      </table>
      {{$buses->links()}}
    </div>
  </div>
</div>



@endsection

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  $('.delete-bus').click(function () {
    var idTag = document.getElementById('delete-bus');
    var busHullcode = idTag.getAttribute('hullcode');
    event.preventDefault();
    swal({
      title: 'Yakin ingin menghapus data?',
      text: 'Data yang sudah dihapus tidak akan bisa dikembalikan',
      icon: 'warning',
      buttons: ["Tidak", "Ya"],
    }).then(function (value) {
      if (value) {
        window.location.href = "deletebus/" + busHullcode;
      }
    });
  });
</script>
@endpush