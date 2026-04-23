<!DOCTYPE html>
<html>

<head>
    <title>Risk Register - UIN Syekh Nurjati</title>
    <style>
        @page {
            margin: 1cm 1.5cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 9px;
            color: #333;
            line-height: 1.4;
        }

        /* Kop Surat */
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }

        .kop-text {
            text-align: center;
            padding-top: 5px;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 9px;
            line-height: 1.2;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title h3 {
            margin: 0;
            text-decoration: underline;
            font-size: 12px;
            text-transform: uppercase;
        }

        .report-title p {
            margin: 5px 0 0;
            font-size: 10px;
            font-weight: bold;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        table.data-table th {
            background-color: #f3f4f6;
            color: #1f2937;
            padding: 10px 5px;
            text-align: center;
            border: 1px solid #000;
            text-transform: uppercase;
            font-size: 8px;
            font-weight: bold;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 8px 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            color: #fff;
            display: inline-block;
            text-align: center;
            font-size: 8px;
        }

        .level-low {
            background-color: #10b981;
        }

        .level-medium {
            background-color: #eab308;
        }

        .level-high {
            background-color: #f97316;
        }

        .level-extreme {
            background-color: #ef4444;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            width: 100%;
            text-align: right;
            font-style: italic;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }

        .page-number:before {
            content: "Halaman " counter(page);
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Matrix Styles for PDF */
        .matrix-table {
            border-collapse: separate;
            border-spacing: 1px;
            margin: 0 auto;
        }

        .matrix-table td {
            width: 22px;
            height: 22px;
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .matrix-label {
            font-size: 6px;
            color: #666;
            font-weight: bold;
        }

        .matrix-outer-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .matrix-box {
            text-align: center;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .count-badge {
            background: #000;
            color: #fff;
            width: 12px;
            height: 12px;
            line-height: 12px;
            display: inline-block;
            border-radius: 50%;
            font-size: 7px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <div class="kop-text">
            <h1>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h1>
            <h2>UIN SIBER SYEKH NURJATI CIREBON</h2>
            <h2 style="font-size: 12px; margin-top: -2px;">SATUAN TUGAS (SATGAS) MANAJEMEN RISIKO</h2>
            <p>Jl. Perjuangan, Sunyaragi, Kec. Kesambi, Kota Cirebon, Jawa Barat 45131</p>
            <p>Telepon: (0231) 481264 | Website: www.syekhnurjati.ac.id</p>
        </div>
    </div>

    <div class="report-title">
        <h3>RISK REGISTER (FORMULIR PENETAPAN RISIKO)</h3>
        <p>UNIT KERJA:
            {{ count($risks) > 0 && $risks[0]->unit ? strtoupper($risks[0]->unit->nama_unit) : 'SEMUA UNIT' }}</p>
        <p>PERIODE: {{ $filters['start_date'] ? date('d/m/Y', strtotime($filters['start_date'])) : '-' }} s/d
            {{ $filters['end_date'] ? date('d/m/Y', strtotime($filters['end_date'])) : '-' }}</p>
    </div>

    <!-- Heatmaps Container -->
    <table class="matrix-outer-container">
        <tr>
            <td width="48%" style="border:none; padding-right: 2%;">
                <div class="matrix-box">
                    <div style="font-weight: bold; margin-bottom: 8px; font-size: 9px; color: #1f2937;">PETA RISIKO INHERENT (AWAL)</div>
                    <table class="matrix-table">
                        @for($p = 5; $p >= 1; $p--)
                            <tr>
                                <td class="matrix-label" style="border:none; width: 10px;">{{ $p }}</td>
                                @for($d = 1; $d <= 5; $d++)
                                    @php
                                        $score = $p * $d;
                                        $color = ($score >= 16) ? '#ef4444' : (($score >= 11) ? '#f97316' : (($score >= 6) ? '#eab308' : '#10b981'));
                                        $count = $inherentMatrix[$p][$d] ?? 0;
                                    @endphp
                                    <td style="background-color: {{ $color }}; color: #fff;">
                                        @if($count > 0)
                                            <span class="count-badge">{{ $count }}</span>
                                        @else
                                            <span style="opacity: 0.2;">{{ $score }}</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td style="border:none;"></td>
                            @for($d = 1; $d <= 5; $d++)
                                <td class="matrix-label" style="border:none;">{{ $d }}</td>
                            @endfor
                        </tr>
                    </table>
                    <div style="font-size: 6px; margin-top: 5px; color: #999;">(Y: Probabilitas | X: Dampak)</div>
                </div>
            </td>
            <td width="48%" style="border:none; padding-left: 2%;">
                <div class="matrix-box">
                    <div style="font-weight: bold; margin-bottom: 8px; font-size: 9px; color: #1f2937;">PETA RISIKO RESIDUAL (SISA)</div>
                    <table class="matrix-table">
                        @for($p = 5; $p >= 1; $p--)
                            <tr>
                                <td class="matrix-label" style="border:none; width: 10px;">{{ $p }}</td>
                                @for($d = 1; $d <= 5; $d++)
                                    @php
                                        $score = $p * $d;
                                        $color = ($score >= 16) ? '#ef4444' : (($score >= 11) ? '#f97316' : (($score >= 6) ? '#eab308' : '#10b981'));
                                        $count = $residualMatrix[$p][$d] ?? 0;
                                    @endphp
                                    <td style="background-color: {{ $color }}; color: #fff;">
                                        @if($count > 0)
                                            <span class="count-badge">{{ $count }}</span>
                                        @else
                                            <span style="opacity: 0.2;">{{ $score }}</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td style="border:none;"></td>
                            @for($d = 1; $d <= 5; $d++)
                                <td class="matrix-label" style="border:none;">{{ $d }}</td>
                            @endfor
                        </tr>
                    </table>
                    <div style="font-size: 6px; margin-top: 5px; color: #999;">(Y: Probabilitas | X: Dampak)</div>
                </div>
            </td>
        </tr>
    </table>

    <div style="page-break-before: auto;"></div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 100px;">Pernyataan Risiko & Kategori</th>
                <th style="width: 120px;">Sasaran Strategis & Misi</th>
                <th style="width: 100px;">Akar Penyebab & Dampak</th>
                <th style="width: 60px;">Inherent Risk (P&times;D)</th>
                <th style="width: 120px;">Rencana Mitigasi</th>
                <th style="width: 50px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($risks as $index => $risk)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        @if($risk->kode_risiko)
                            <div style="font-weight: bold; background: #eee; padding: 2px; display: inline-block; margin-bottom: 3px;">[{{ $risk->kode_risiko }}]</div>
                        @endif
                        <div class="font-bold">{{ $risk->nama_risiko }}</div>
                        <div style="font-size: 8px; color: #666; margin-top: 2px;">Kategori:
                            {{ $risk->kategori->nama_kategori ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="font-bold">SS:</div>
                        <div>{{ $risk->sasaran_strategis ?? '-' }}</div>
                        <div class="font-bold" style="margin-top: 4px;">Misi:</div>
                        <div style="font-size: 8px;">{{ $risk->misi_universitas ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="font-bold">Penyebab:</div>
                        <div>{{ $risk->penyebab ?? '-' }}</div>
                        <div class="font-bold" style="margin-top: 4px;">Dampak:</div>
                        <div>{{ $risk->dampak ?? '-' }}</div>
                    </td>
                    <td class="text-center">
                        <div class="font-bold">{{ $risk->probabilitas }} &times; {{ $risk->level_dampak }} =
                            {{ $risk->skor_risiko }}</div>
                        <div class="badge level-{{ strtolower($risk->level_risiko) }}" style="margin-top: 5px;">
                            {{ $risk->level_risiko }}
                        </div>
                    </td>
                    <td style="font-size: 8px;">
                        @foreach($risk->mitigations as $mit)
                            <div style="margin-bottom: 4px;">
                                • <span class="font-bold">{{ $mit->strategi }}:</span> {{ $mit->rencana_aksi }}
                                <span style="color: #666;">(PIC: {{ $mit->penanggung_jawab }})</span>
                            </div>
                        @endforeach
                    </td>
                    <td class="text-center font-bold">
                        {{ strtoupper($risk->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; width: 250px; text-align: center;">
        <p>Cirebon, {{ $date }}</p>
        <p style="margin-top: 60px;">( ............................................ )</p>
        <p>Risk Officer / Risk Manager</p>
    </div>

    <div class="footer">
        <span class="page-number"></span> | Sistem Manajemen Risiko UIN Siber Syekh Nurjati Cirebon | Dicetak pada:
        {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>