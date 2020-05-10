@extends('layouts.app',['activePage'=>'workshop'])
@section('title','Dashboard Surat Tugas')

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif



<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Surat Tugas</h1>
  </div>
  
  <form action="{{route('workshop.showworkshop')}}" class="form-inline my-2">
    <div class="form-group ">
        <input value="{{Request::get('keyword')}}" name="keyword" class="form-control input-lg" type="text"
            placeholder="Cari Kode Lambung" />
    </div>
    <div class="form-group mx-4 ">
        <input type="submit" value="Cari" class="btn btn-primary">
    </div>
  
  </form>

  <div class="d-sm-flex float-right  ">
    <a href="{{route('workshop.addworkshop')}}" style="padding-bottom: 2%" class="btn btn-primary">Tambah Surat Tugas</a>
  </div>
  
  
  
  <div style="margin-top:8%" class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr >
              <th  style="text-align: center">No.</th>
              <th >No. Surat</th>
              <th>Kode HT</th>
              <th style="text-align: center">Nama</th>
              <th>Pekerjaan</th>
              <th>Keluhan</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          @if (count($workshops) == 0)
    
          <tbody>
            <td colspan="9" style="text-align: center;padding-top: 3%">Tidak ada surat tugas yang dibuat</td>
                @else
  
                @foreach ($workshops as $index => $workshop)
                <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $workshop['workshopnumber'] }}</td>
                        <td>{{ $workshop['hull_code'] }}</td>
                        <td>
                            <ul>
                                @foreach ($workshop['name'] as $name)
                                    <li>{{$name}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $workshop['work_type'] }}</td>
                        <td>{{ $workshop['detail'] }}</td>
                        <td>{{ $workshop['order_date'] }}</td>
                        {{-- <td>{{ $workshop['status'] }}</td> --}}
                        @if ($workshop['status']==0)
                            <td style="font-weight: bold">Belum Selesai</td>
                        @else
                            <td>Selesai</td>
                        @endif
                        <td>
                          <a href="#" data-id="{{$workshop['workshopnumber']}}" class="btn btn-danger btn-sm delete-workshop">Delete</a>
                          {{-- <a class="btn btn-info text-white btn-sm" href="{{route('workshop.editworkshop',[$workshop['workshopnumber']])}}">Edit</a> --}}
                        </td>
                       
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
    $('.delete-workshop').click(function () {
      var workshopNumber = $(this).data('id');
      console.log(workshopNumber)
      event.preventDefault();
      swal({
        title: 'Yakin ingin menghapus data?',
        text: 'Data yang sudah dihapus tidak akan bisa dikembalikan',
        icon: 'warning',
        buttons: ["Tidak", "Ya"],
      }).then(function (value) {
        if (value) {
          window.location.href = "deleteworkshop/" + workshopNumber;
        }
      });
    });
  </script>
  @endpush