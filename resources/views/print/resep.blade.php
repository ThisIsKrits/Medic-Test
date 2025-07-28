<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Resep</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        h2, h4 { margin: 0; padding: 0; }
    </style>
</head>
<body>
    <h2>Nota Resep</h2>
    <hr>
    <table>
        <tr>
            <td>No. Resep</td>
            <td>{{ $prescription->no }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>{{ \Carbon\Carbon::parse($prescription->tgl)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Pasien</td>
            <td>{{ $prescription->checkup->patients->name ?? '-' }}</td>
        </tr>
    </table>

    <h4>Daftar Obat</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($prescription->prescriptionItems as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->medicine }}</td>
                    <td>{{ $item->qty }}</td>
                    <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ number_format($prescription->total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p><em>Dicetak pada {{ now()->format('d-m-Y H:i') }}</em></p>
</body>
</html>
