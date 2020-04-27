@extends('layouts.app',['activePage'=>'user'])
@section('title','Dashboard karyawan')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Karyawan</h1>
  <div class="form-group float-right">
    <a href="{{route('user.addofficer')}}" class="btn btn-primary">Tambah Data</a>
  </div>
</div>



<div class="card shadow my-5">

  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Keahlian</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        @if ($users->count()==0)
        <tbody>
          <td colspan="6" style="text-align: center;padding-top: 3%">Tidak ada suku cadang</td>
          @else
          @foreach ($users as $user)
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->username}}</td>
            @switch($user->id_role)
            @case(1)
            <td>Koordinator Produksi</td>
            @break
            @case(2)
            <td>Petugas Mekanik</td>
            @break
            @case(3)
            <td>Petugas Logistik</td>
            @break
            @case(4)
            <td>Kru Bus</td>
            @break
            @endswitch
            <td>{{$user->expertness}}</td>
            <td>{{$user->email}}</td>
            <td>
              <a class="btn btn-info text-white btn-sm" href="{{route('user.editofficer',[$user->id])}}">Edit</a>
              <a href="{{route('user.detailofficer',$user->id)}}" class="btn btn-primary btn-sm">Detail</a>
              <a href="#" data-id="{{$user->id}}" class="btn btn-danger btn-sm delete-officer">Hapus</a>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>

      </table>
      {{$users->links()}}
    </div>
  </div>
</div>



@endsection

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  $('.delete-officer').click(function () {
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
        window.location.href = "deleteofficer/" + userId;
      }
    });
  });
</script>
@endpush