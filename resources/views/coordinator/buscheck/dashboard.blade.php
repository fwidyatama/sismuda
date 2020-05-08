@extends('layouts.app',['activePage'=>'buscheck'])
@section('title','Dashboard Sparepart')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Pengecekan Bus</h1>
</div>



<div style="margin-top:3%" class="card shadow">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr >
            <th  style="text-align: center">Nomor</th>
            <th>Kode Lambung</th>
            <th>Nama Petugas</th>
            <th>Keluhan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        @if ($checkOrders->count()==0)
       
        <tbody>
          <td colspan="6" style="text-align: center;padding-top: 3%">Belum ada permintaan pengecekan</td>
              @else
              @foreach ($checkOrders as $number => $checkOrder)
              <tr>
                <td style="text-align: center">{{++$number}}</td>
                <td>{{$checkOrder->hull_code}}</td>
                <td>{{$checkOrder->user->name}}</td>
                <td>{{$checkOrder->complaint}}</td>
                
                <td>{{$checkOrder->date}}</td>
                @if ($checkOrder->status==0)
                    <td style="font-weight: bold">Belum Disetujui</td>
                @elseif($checkOrder->status==1)
                <td >Ditolak</td>
                @elseif($checkOrder->status==2)
                <td >Disetujui</td>
                @endif
            <td>
                @if ($checkOrder->status==0)
                    
                <a class="btn btn-info text-white btn-sm" href="{{route('buscheck.detailorder',$checkOrder->id)}}">Verifikasi</a>
                @endif
              <a href="#" data-id="{{$checkOrder->id}}" class="btn btn-danger btn-sm delete-checkorder">Hapus</a>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>

      </table>
      {{$checkOrders->links()}}
    </div>
  </div>
</div>



@endsection

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  $('.delete-checkorder').click(function () {
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
        window.location.href = "deleteorder/" + userId;
      }
    });
  });
</script>
@endpush