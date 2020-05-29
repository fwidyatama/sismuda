@extends('layouts.app',['activePage'=>'sparepartverif'])
@section('title','Dashboard Sparepart')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Sparepart Terverifikasi</h1>
</div>



<div style="margin-top:8%" class="card shadow">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr >
            <th  style="text-align: center">Nomor</th>
            <th>Kode Lambung</th>
            <th>Nama Barang</th>
            <th>Nama Petugas</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Tanggal</th>
            <th>Jenis</th>
          </tr>
        </thead>
        @if ($spareparts->count()==0)
       
        <tbody>
          <td colspan="8" style="text-align: center;padding-top: 3%">Tidak ada suku cadang yang disetujui</td>
              @else
              @foreach ($spareparts as $number => $sparepart)
              <tr>
                <td  style="text-align: center">{{++$number}}</td>
                <td>{{$sparepart->hull_code}}</td>
                <td>{{$sparepart->sparepart_name}}</td>
                <td>{{$sparepart->user_name}}</td>
                <td  style="text-align: center">{{$sparepart->quantity}}</td>
                <td>{{$sparepart->unit_name}}</td>
                <td>{{$sparepart->date}}</td>
                @if ($sparepart->type=='new')
                <td>Baru</td>
            @else
                <td>Bekas</td>
            @endif
             
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