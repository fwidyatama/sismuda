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
  
  
  
  <div style="margin-top:6%" class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-items-center table-flush" id="officer-table" width="100%" cellspacing="10">
          <thead class="thead-light">
            <tr >
              <th style="text-align: center">No.</th>
              <th style="text-align: center">No. Surat</th>
              <th style="text-align: center">Kode HT</th>
              <th>Pekerjaan</th>
              <th>Keluhan</th>
              <th>Tanggal</th>
              <th>Status</th>
            
            
            </tr>
          </thead>
          @if (count($workshops) == 0)
    
          <tbody>
            <td colspan="8" style="text-align: center;padding-top: 3%">Belum ada surat tugas yang dibuat</td>
                @else
  
                @foreach ($workshops as $index => $workshop)
                <tr >
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td style="text-align: center">{{ $workshop['workshopnumber'] }}</td>
                        <td style="text-align: center">{{ $workshop['hull_code'] }}</td>
                        <td>{{ $workshop['work_type'] }}</td>
                        <td> {{ $workshop['detail'] }}</td>
                        <td>{{ $workshop['order_date'] }}</td>
                        @if ($workshop['status']==0)
                        <td style="font-weight: bold">Belum Selesai</td>
                    @else
                        <td>Selesai</td>
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
