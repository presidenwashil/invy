<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SURAT PESANAN</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .kop { width: 100%; }
        .center { text-align: center; }
        .underline { text-decoration: underline; }
        .table, .table th, .table td {
            border: 1px solid #222;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 4px 8px;
        }
        .no-border { border: none !important; }
        .signature-table td { vertical-align: top; }
        .mt-30 { margin-top: 30px; }
        .mb-10 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <img src="{{ public_path('images/kop-surat.png') }}" alt="Kop Surat" class="kop">

    <div class="center mb-10">
        <h3 class="underline" style="margin-bottom: 0;">SURAT PESANAN</h3>
    </div>

    <table style="width: 100%; margin-bottom: 10px;">
        <tr>
            <td style="width: 15%;">Nomor</td>
            <td style="width: 35%;">: {{ $order->order_number }}</td>
            <td style="width: 15%;">Kepada</td>
            <td style="width: 35%;">: {{ $order->supplier->name }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td colspan="3">: {{ $order->job_description ?? 'Pengadaan Souvenir/Cinderamata ...' }}</td>
        </tr>
        <tr>
            <td>Waktu Pelaksanaan</td>
            <td colspan="3">
                : {{ $order->duration ?? '2 Hari' }} &nbsp;&nbsp; {{ $order->start_date ?? '15 Mei 2025' }} s/d {{ $order->end_date ?? '16 Mei 2025' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom: 5px;">Barang-barang yang dipesan adalah :</div>
    <table class="table" style="width: 100%;">
        <thead>
            <tr class="center">
                <th style="width: 5%;">No.</th>
                <th>Uraian Pesanan</th>
                <th style="width: 10%;">Volume</th>
                <th style="width: 10%;">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $i => $detail)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $detail->item->name }}</td>
                <td class="center">{{ $detail->quantity }}</td>
                <td class="center">{{ $detail->unit->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="signature-table" style="width: 100%; margin-top: 40px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                Yang Melaksanakan Pekerjaan<br>
                <strong>{{ $order->supplier->name }}</strong><br><br><br><br>
                <u>{{ $order->supplier->director ?? 'ANGGORO SETYO BUDI' }}</u><br>
                DIREKTUR
            </td>
            <td style="width: 50%; text-align: center;">
                Samarinda, {{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}<br>
                Pejabat Pelaksana Teknis Kegiatan<br>
                (PPTK)<br><br><br><br>
                <u>{{ $order->pptk_name ?? 'AWANG FERDIAN KURNIAWAN, S.ST.' }}</u><br>
                {{ $order->pptk_nip ?? '198911092015031003' }}
            </td>
        </tr>
    </table>
</body>
</html>
