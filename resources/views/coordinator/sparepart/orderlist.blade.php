@extends('layouts.app',['activePage'=>'order'])
@section('title','Dashboard Order Sparepart')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Pengajuan Sparepart</h1>
</div>

<form action="{{route('order.download')}}" class="form-row my-2 ">   
  <div class="form-group mx-1">
    <select name="month" class="form-control" id="date" >Bulan
        <option value="" >Bulan</option>
        <option value="01" {{Request::get('month')=="01"?'selected':''}}>Januari</option>
        <option value="02"{{Request::get('month')=="02"?'selected':''}}>Februari</option>
        <option value="03"{{Request::get('month')=="03"?'selected':''}}>Maret</option>
        <option value="04"{{Request::get('month')=="04"?'selected':''}}>April</option>
        <option value="05"{{Request::get('month')=="05"?'selected':''}}>Mei</option>
        <option value="06"{{Request::get('month')=="06"?'selected':''}}>Juni</option>
        <option value="07"{{Request::get('month')=="07"?'selected':''}}>Juli</option>
        <option value="08"{{Request::get('month')=="08"?'selected':''}}>Agustus</option>
        <option value="09"{{Request::get('month')=="09"?'selected':''}}>September</option>
        <option value="10"{{Request::get('month')=="10"?'selected':''}}>Oktober</option>
        <option value="11"{{Request::get('month')=="11"?'selected':''}}>November</option>
        <option value="12"{{Request::get('month')=="10"?'selected':''}}>Desmber</option>
      </select>
  </div>

  <div class="form-group mx-1 ">
  <input value="{{Request::get('year')}}" name="year" class="form-control" type="text"
          placeholder="Tahun" />
  </div>

      <div class="form-group mx-1">
        <button class="btn btn-primary" name="action" value="filter">Filter</button>
        <button class="btn btn-success" name="action" value="download">Unduh Laporan</button> 
      
    </div>
</form>

{{-- <div class="d-sm-flex float-right  ">
  <a href="{{route('order.download')}}" style="padding-bottom: 2%" class="btn btn-info mx-2">Unduh Data</a>
</div> --}}


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
            <th>Status</th>
            <th style="text-align: center">Aksi</th>
          </tr>
        </thead>
        @if ($spareparts->count()==0)
       
        <tbody>
          <td colspan="10" style="text-align: center;padding-top: 3%">Belum ada pengajuan suku cadang</td>
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
                @if ($sparepart->status==0)
                    <td style="font-weight: bold"> Belum Disetujui</td>
                @elseif($sparepart->status==1)
                  <td>Disetujui</td>
                  @elseif($sparepart->status==2)
                  <td>Ditolak</td>
                @endif

               @if ($sparepart->status==0)
               <td>
                <a class="btn btn-info text-white btn-sm" href="{{route('order.detailorder',$sparepart->id)}}">Verifikasi</a>
              </td>
              @else
              <td style="font-weight: bold;text-align: center">-</td>
               @endif
          
             
          </tr>
          @endforeach
          @endif
         
        </tbody>
        
      </table>
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