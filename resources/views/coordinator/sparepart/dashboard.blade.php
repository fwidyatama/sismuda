@extends('layouts.app',['activePage'=>'sparepart'])
@section('title','Dashboard Sparepart')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Sparepart</h1>
</div>

<form action="{{route('sparepart.showsparepartlist')}}" class="form-inline my-2">
  <div class="form-group ">
      <input value="{{Request::get('keyword')}}" name="keyword" class="form-control input-lg" type="text"
          placeholder="Cari sukucadang" />
  </div>
  <div class="form-group mx-4 ">
      <input type="submit" value="Filter" class="btn btn-primary">
  </div>

</form>


<div class="d-sm-flex float-right  ">
  <a href="{{route('sparepart.downloadreport')}}" style="padding-bottom: 2%" class="btn btn-info mx-2">Unduh Laporan Stok</a>
  <a href="{{route('sparepart.addsparepart')}}" style="padding-bottom: 2%" class="btn btn-primary">Tambah Sparepart</a>
</div>


<div style="margin-top:8%" class="card shadow">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr >
            <th  style="text-align: center">Nomor</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        @if ($spareparts->count()==0)
       
        <tbody>
          <td colspan="8" style="text-align: center;padding-top: 3%">Tidak ada suku cadang</td>
              @else
              @foreach ($spareparts as $number => $sparepart)
              <tr>
                <td style="text-align: center">{{++$number}}</td>
                <td>{{$sparepart->name}}</td>
                <td>{{$sparepart->quantity}}</td>
                <td>{{$sparepart->unit_name}}</td>
                <td>{{$sparepart->price}}</td>
            <td>
              <a class="btn btn-info text-white btn-sm" href="{{route('sparepart.editsparepart',[$sparepart->id])}}">Edit</a>
              <a href="#" data-id="{{$sparepart->id}}" class="btn btn-danger btn-sm delete-sparepart">Delete</a>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>

      </table>
      {{$spareparts->links()}}
    </div>
  </div>
</div>



@endsection

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  $('.delete-sparepart').click(function () {
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
        window.location.href = "deletesparepart/" + userId;
      }
    });
  });
</script>
@endpush