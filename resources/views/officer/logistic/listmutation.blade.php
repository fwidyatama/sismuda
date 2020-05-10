<table>
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Nama Sparepart</th>
        <th>Keluar/Masuk</th>
        <th>Tanggal</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Jenis</th>
        <th>Harga Satuan</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
         @foreach ($mutations as $number => $mutation)
          <tr>
            <td >{{++$number}}</td>
            <td>{{$mutation->sparepart_name}}</td>
            @if ($mutation->status=='entry')
                <td>Masuk</td>
                @else
                <td>Keluar</td>
            @endif
            <td>{{$mutation->date}}</td>
            <td>{{$mutation->quantity}}</td>
            <td>{{$mutation->total}}</td>
            @if ($mutation->type=='new')
                <td>Baru</td>
            @else
                <td>Bekas</td>
            @endif
            <td>{{$mutation->sparepart_price}}</td>
            <td>{{$mutation->quantity*$mutation->sparepart_price}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>