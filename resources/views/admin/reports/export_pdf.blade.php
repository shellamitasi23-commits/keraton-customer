<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Keraton Kasepuhan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h2>LAPORAN PENJUALAN KERATON KASEPUHAN</h2>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>

    <h3>1. Laporan Tiket</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticketTransactions as $key => $trx)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $trx->user->name ?? 'Guest' }}</td>
                <td>{{ $trx->ticketCategory->name ?? '-' }}</td>
                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                <td>{{ $trx->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>2. Laporan Merchandise</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Total Bayar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($merchandiseOrders as $key => $order)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $order->user->name ?? 'Customer' }}</td>
                <td>Rp {{ number_format($order->total_price) }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>