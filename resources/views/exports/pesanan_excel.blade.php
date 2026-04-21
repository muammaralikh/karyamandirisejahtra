<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #d9ead3;
            font-weight: 700;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pemesan</th>
                <th>Alamat Lengkap</th>
                <th>Daftar Produk</th>
                <th>Total Item</th>
                <th>Total Belanja Produk</th>
                <th>Ongkir</th>
                <th>Total Akhir</th>
                <th>Status Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @php
                    $daftarProduk = $order->items->map(function ($item) {
                        return $item->product_name . ' x' . $item->qty;
                    })->implode(', ');
                @endphp
                <tr>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ preg_replace('/\s+/', ' ', $order->shipping_address ?? '-') }}</td>
                    <td>{{ $daftarProduk ?: '-' }}</td>
                    <td>{{ $order->items->sum('qty') }}</td>
                    <td class="text-right">{{ $order->subtotal }}</td>
                    <td class="text-right">{{ $order->shipping_cost }}</td>
                    <td class="text-right">{{ $order->total }}</td>
                    <td>{{ strtoupper($order->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
