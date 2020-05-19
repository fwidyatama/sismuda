@extends('layouts.app',['activePage'=>'permits'])
@section('title','Dashboard Perbaikan')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Kendaraan Selesai</h1>
</div>



<div style="margin-top:3%" class="card shadow">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr >
            <th  style="text-align: center">Nomor</th>
            <th>Kode Lambung</th>
            <th>No. Surat Tugas</th>
            <th>Nama Petugas</th>
            <th>Catatan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        @if ($permits->count()==0)
       
        <tbody>
          <td colspan="7" style="text-align: center;padding-top: 3%">Belum ada kendaraan yang selesai diperbaiki</td>
              @else
              @foreach ($permits as $number => $permit)
              <tr>
                <td style="text-align: center">{{++$number}}</td>
                <td>{{$permit->hull_code}}</td>
                <td>{{$permit->workshop_number}}</td>
                <td>{{$permit->user->name}}</td>
                <td>{{$permit->note}}</td>
                <td>{{$permit->date}}</td>
            <td>
              <a href="#" data-id="{{$permit->id}}" class="btn btn-danger btn-sm delete-permit">Hapus</a>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>

      </table>
      {{$permits->links()}}
    </div>
  </div>
</div>



@endsection

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  $('.delete-permit').click(function () {
    var userId = $(this).data('id');
    console.log(userId)
    event.preventDefault();
    swal({
      title: 'Yakin ingin menghapus data?',
      text: 'Data yang sudah dihapus tidak akan bisa dikembalikan',
      icon: 'warning',
      buttons: ["Tidak", "Ya"],
    }).then(function (value) {
      if (value) {
        window.location.href = "deletelist/" + userId;
      }
    });
  });
</script>
@endpush