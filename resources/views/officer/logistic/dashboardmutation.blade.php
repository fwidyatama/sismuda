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


<div style="margin-top:8%" class="card shadow">
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
                <td  style="text-align: center">{{$mutation->stock}}</td>
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
