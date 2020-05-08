<table>
    <thead >
      <tr >
        <th >Nomor</th>
        <th>Kode Lambung</th>
        <th>Nama Barang</th>
        <th>Nama Petugas</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
          @foreach ($spareparts as $number => $sparepart)
          <tr>
            <td >{{++$number}}</td>
            <td>{{$sparepart->hull_code}}</td>
            <td>{{$sparepart->sparepart_name}}</td>
            <td>{{$sparepart->user_name}}</td>
            <td >{{$sparepart->quantity}}</td>
            <td>{{$sparepart->unit_name}}</td>
            <td>{{$sparepart->date}}</td>
            @if ($sparepart->type=='new')
                <td>Baru</td>
            @else
                <td>Bekas</td>
            @endif
            @if ($sparepart->status==0)
                <td> Belum Disetujui</td>
            @elseif($sparepart->status==1)
              <td>Sudah Disetujui</td>
              @elseif($sparepart->status==2)
              <td>Ditolak</td>
            @endif
      </tr>
      @endforeach
    </tbody>
  </table>