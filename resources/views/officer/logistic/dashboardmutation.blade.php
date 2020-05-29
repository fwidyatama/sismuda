@extends('layouts.app',['activePage'=>'mutation'])
@section('title','Dashboard Mutasi')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif


<div class="d-sm-flex align-items-center justify-content-between ">
  <h1 class="h3 mb-0 text-gray-800">Dashboard Mutasi</h1>
</div>



<div class="d-sm-flex float-right  ">
  <a href="{{route('mutation.add')}}" style="padding-bottom: 2%" class="btn btn-info mx-2">Tambah Data</a>
 
</div>


<form action="{{route('mutation.show')}}" class="form-row my-2 ">   
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
        <button class="btn btn-success" name="action" value="download">Unduh Mutasi</button> 
         {{-- <a href="{{route('mutation.download')}}" style="padding-bottom: 2%" class="btn btn-info mx-2">Unduh Laporan</a> --}}
      
      
    </div>
</form>


<div style="margin-top:5%" class="card shadow">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr >
            <th  style="text-align: center">Nomor</th>
            <th>Nama Sparepart</th>
            <th>Keluar/Masuk</th>
            <th  style="text-align: center">Tanggal</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Jenis</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
          </tr>
        </thead>
        @if ($mutations->count()==0)
       
        <tbody>
          <td colspan="9" style="text-align: center;padding-top: 3%">Tidak ada data mutasi suku cadang</td>
              @else
              @foreach ($mutations as $number => $mutation)
              <tr>
                <td  style="text-align: center">{{++$number}}</td>
                <td>{{$mutation->sparepart_name}}</td>
                @if ($mutation->status=='entry')
                    <td>Masuk</td>
                    @else
                    <td>Keluar</td>
                @endif
                <td>{{$mutation->date}}</td>
                <td  style="text-align: center">{{$mutation->quantity}}</td>
                <td  style="text-align: center">{{$mutation->total}}</td>
                @if ($mutation->type=='new')
                    <td>Baru</td>
                @else
                    <td>Bekas</td>
                @endif
                <td>{{$mutation->sparepart_price}}</td>
                <td>{{$mutation->quantity*$mutation->sparepart_price}}</td>
             
          
             
          </tr>
          @endforeach
          @endif
         
        </tbody>
        
      </table>
      {{$mutations->links()}}
    </div>
  </div>
</div>



@endsection
