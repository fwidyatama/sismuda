<table>
  <thead>
  <tr>
    <th>Nomor</th>
    <th>Kode</th>
    <th>Nama</th>
    <th>Merk</th>
    <th>Jumlah</th>
    <th>Satuan</th>
    <th>Harga Satuan</th>
  </tr>
  </thead>
  <tbody>
  @foreach($spareparts as $number=> $sparepart)

      <tr>
          <td>{{++$number}}</td>
          <td>{{$sparepart->code}}</td>
          <td>{{$sparepart->name}}</td>
          <td>{{$sparepart->brand}}</td>
          <td>{{$sparepart->quantity}}</td>
          <td>{{$sparepart->unit_name}}</td>
          <td>{{$sparepart->price}}</td>
      </tr>
  @endforeach
  </tbody>
</table>
