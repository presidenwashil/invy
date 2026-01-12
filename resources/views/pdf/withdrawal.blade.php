<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { font-family: sans-serif; font-size: 12pt; }
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; }
        .kop { width: 100%;}
        .title { text-align: center; font-weight: bold; margin-top: 20px; text-decoration: underline; }
        .table, .table th, .table td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
        .signature { margin-top: 50px; width: 100%; }
        .signature td { padding: 10px; vertical-align: top; }
    </style>
</head>
<body>

    <img src="{{ asset('images/kop-surat.png') }}" class="kop" alt="Kop Surat">

    <div class="title">
        BERITA ACARA PENGELUARAN BARANG<br>
        Nomor : {{ $withdrawal->withdrawal_number }}
    </div>

    <p>
        Pada hari ini {{ \Carbon\Carbon::parse($withdrawal->withdrawal_date)->locale('id')->translatedFormat('l') }} tanggal {{ \Carbon\Carbon::parse($withdrawal->withdrawal_date)->translatedFormat('d') }} bulan {{ \Carbon\Carbon::parse($withdrawal->withdrawal_date)->translatedFormat('F') }} tahun {{ \Carbon\Carbon::parse($withdrawal->withdrawal_date)->translatedFormat('Y') }}, yang bertanda tangan di bawah ini :
    </p>

    <table>
        <tr>
            <td>I.</td>
            <td>Nama</td>
            <td>:</td>
            <td>Fadliansyah</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP</td>
            <td>:</td>
            <td>197412142007011010</td>
        </tr>
        <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td>Pengurus Barang Pembantu</td>
        </tr>
    </table>

    <table>
        <tr>
            <td></td>
            <td>
                Yang Selanjutnya disebut <strong>PIHAK PERTAMA</strong>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>II.</td>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $withdrawal->staff->name }}</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $withdrawal->staff->nip }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $withdrawal->staff->position }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td></td>
            <td>
                Dalam hal ini selanjutnya disebut <strong>PIHAK KEDUA</strong>
            </td>
        </tr>
    </table>

    <p>
        Dengan ini <strong>PIHAK PERTAMA</strong> mengeluarkan barang kepada <strong>PIHAK KEDUA</strong> sebagai berikut :
    </p>

    <table class="table" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Spesifikasi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawal->details as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->item->name }} {{ $item->item->brand ?? '' }}</td>
                    <td>{{ $item->item->specification ?? '' }}</td>
                    <td align="center">{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <table class="signature">
        <tr>
            <td align="center">
                PIHAK PERTAMA<br>Pengurus Barang Pembantu<br><br><br><br>
                <u>Fadliansyah</u><br>
                NIP. 197412142007011010
            </td>
            <td align="center">
                PIHAK KEDUA<br>{{ $withdrawal->staff->position }}<br><br><br><br>
                <u>{{ $withdrawal->staff->name }}</u><br>
                NIP. {{ $withdrawal->staff->nip }}
            </td>
        </tr>
    </table>

    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>
