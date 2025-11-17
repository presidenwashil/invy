<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            font-family: sans-serif; font-size: 12pt;
        }
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; }
        .logo { width: 80px; position: absolute; top: 10px; left: 10px; }
        .kop { width: 100%;}
        .title { text-align: center; font-weight: bold; margin-top: 20px; text-decoration: underline; }
        .table, .table th, .table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        .signature { margin-top: 50px; width: 100%; }
        .signature td { padding: 10px; vertical-align: top; }
    </style>
</head>
<body>

    <img src="{{ asset('images/kop-surat.png') }}" class="kop" alt="Kop Surat">

    <div class="title">
        @if(request('tableFilters.month.value'))
            <h2>
                REKAPAN PENYERAHAN BARANG {{ strtoupper(\Carbon\Carbon::createFromFormat('!m', request('tableFilters.month.value'))->locale('id')->translatedFormat('F')) }} {{ request('tableFilters.year.year') }}
            </h2>
        @endif
    </div>


    <table class="table" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIP</th>
                <th>Diserahkan kepada</th>
                <th>Nomor Penyerahan</th>
                <th>Tanggal Penyerahan</th>
                <th>Jumlah barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($handovers as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->staff->nip }}</td>
                    <td>{{ $item->staff->name }}</td>
                    <td>{{ $item->handover_number }}</td>
                    <td>{{ $item->handover_date }}</td>
                    <td align="center">{{ $item->details->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
