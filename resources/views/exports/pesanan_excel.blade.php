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
            vertical-align: middle;
            text-align: center;
        }

        td {
            word-wrap: break-word;
            white-space: normal;
        }

        th {
            background-color: #d9ead3;
            font-weight: 700;
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
                <th>Nomor Order</th>
                <th>Nama Akun</th>
                <th>Penerima Pesanan</th>
                <th>Daftar Produk</th>
                <th>Total Item</th>
                <th>Total Belanja Produk</th>
                <th>Ongkir</th>
                <th>Total Akhir</th>
                <th>Nomor Telepon</th>
                <th>Alamat Lengkap</th>
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
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ $order->recipient_name ?? '-' }}</td>
                    <td>{{ $daftarProduk ?: '-' }}</td>
                    <td>{{ $order->items->sum('qty') }}</td>
                    <td>{{ (int) round($order->product_subtotal) }}</td>
                    <td>{{ (int) round($order->shipping_cost) }}</td>
                    <td>{{ (int) round($order->computed_grand_total) }}</td>
                    <td>{{ $order->recipient_phone ?? '-' }}</td>
                    <td>{{ preg_replace('/\s+/', ' ', $order->shipping_address ?? '-') }}</td>
                    <td>{{ strtoupper($order->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
