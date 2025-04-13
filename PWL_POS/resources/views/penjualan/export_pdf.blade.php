<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ $logoSrc }}" width="100" height="100">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN DATA PENJUALAN</h3>
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th>Petugas</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $p->penjualan_kode }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->penjualan_tanggal)) }}</td>
                    <td>{{ $p->pembeli }}</td>
                    <td>{{ $p->user->nama }}</td>
                    <td class="text-right">{{ number_format($p->total_penjualan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h3 class="text-center">DETAIL TRANSAKSI PENJUALAN</h3>
    
    @foreach($penjualan as $p)
        <h4>Kode Transaksi: {{ $p->penjualan_kode }}</h4>
        <p>
            <strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($p->penjualan_tanggal)) }}<br>
            <strong>Pembeli:</strong> {{ $p->pembeli }}<br>
            <strong>Petugas:</strong> {{ $p->user->nama }}
        </p>
        
        <table class="border-all">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($p->detail as $detail)
                    @php 
                        $subtotal = $detail->harga * $detail->jumlah;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang->barang_kode }}</td>
                        <td>{{ $detail->barang->barang_nama }}</td>
                        <td class="text-right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $detail->jumlah }}</td>
                        <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right font-bold">Total</td>
                    <td class="text-right font-bold">{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        
        @if(!$loop->last)
            <div style="margin-bottom: 30px;"></div>
        @endif
    @endforeach
</body>

</html>