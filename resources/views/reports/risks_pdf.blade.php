<!DOCTYPE html>
<html>

<head>
    <title>Risk Register - UIN Siber Syekh Nurjati</title>
    <style>
        @page {
            margin: 1cm 1cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 8px;
            color: #333;
            line-height: 1.3;
        }

        /* Kop Surat */
        .kop-surat {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text h2 {
            margin: 1px 0;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text p {
            margin: 1px 0;
            font-size: 8px;
            line-height: 1.2;
        }

        .report-title {
            text-align: center;
            margin-bottom: 15px;
        }

        .report-title h3 {
            margin: 0;
            text-decoration: underline;
            font-size: 11px;
            text-transform: uppercase;
        }

        .report-title p {
            margin: 3px 0 0;
            font-size: 9px;
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
            color: #000;
            padding: 8px 3px;
            text-align: center;
            border: 1px solid #000;
            text-transform: uppercase;
            font-size: 7.5px;
            font-weight: bold;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 5px 3px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .badge {
            padding: 2px 4px;
            border-radius: 2px;
            font-weight: bold;
            color: #fff;
            display: inline-block;
            text-align: center;
            font-size: 7px;
        }

        .level-low { background-color: #10b981; }
        .level-medium { background-color: #eab308; }
        .level-high { background-color: #f97316; }
        .level-extreme { background-color: #ef4444; }

        .footer {
            position: fixed;
            bottom: -5px;
            width: 100%;
            text-align: right;
            font-style: italic;
            font-size: 7px;
            color: #666;
            border-top: 0.5px solid #ccc;
            padding-top: 3px;
        }

        .page-number:before { content: "Halaman " counter(page); }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }

        /* Matrix Styles */
        .matrix-table {
            border-collapse: separate;
            border-spacing: 1px;
            margin: 0 auto;
        }
        .matrix-table td {
            width: 20px;
            height: 20px;
            text-align: center;
            font-size: 6px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .matrix-label { font-size: 6px; color: #666; font-weight: bold; }
        .matrix-box {
            text-align: center;
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 6px;
            background-color: #fdfdfd;
        }
        .count-badge {
            background: #000;
            color: #fff;
            width: 11px;
            height: 11px;
            line-height: 11px;
            display: inline-block;
            border-radius: 50%;
            font-size: 6px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <div class="kop-text">
            <h1>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h1>
            <h2>UIN SIBER SYEKH NURJATI CIREBON</h2>
            <h2 style="font-size: 10px; margin-top: -1px;">SATUAN TUGAS (SATGAS) MANAJEMEN RISIKO</h2>
            <p>Jl. Perjuangan, Sunyaragi, Kec. Kesambi, Kota Cirebon, Jawa Barat 45131</p>
            <p>Telepon: (0231) 481264 | Website: https://uinssc.ac.id</p>
        </div>
    </div>

    <div class="report-title">
        <h3>LAPORAN EVALUASI & MONITORING MANAJEMEN RISIKO (RISK REGISTER)</h3>
        <p>UNIT KERJA: {{ $selectedUnit ? strtoupper($selectedUnit->nama_unit) : 'SELURUH UNIT KERJA' }}</p>
        <p>PERIODE: {{ $filters['start_date'] ? date('d/m/Y', strtotime($filters['start_date'])) : '-' }} s/d {{ $filters['end_date'] ? date('d/m/Y', strtotime($filters['end_date'])) : '-' }}</p>
    </div>

    <!-- Heatmaps & Charts Container -->
    <table width="100%" style="margin-bottom: 10px;">
        <tr>
            <td width="25%" style="border:none; padding-right: 10px;">
                <div class="matrix-box">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 7px; color: #111;">PETA INHERENT</div>
                    <table class="matrix-table">
                        @for($p = 5; $p >= 1; $p--)
                            <tr>
                                <td class="matrix-label" style="border:none; width: 6px;">{{ $p }}</td>
                                @for($d = 1; $d <= 5; $d++)
                                    @php
                                        $score = $p * $d;
                                        $color = ($score >= 16) ? '#ef4444' : (($score >= 11) ? '#f97316' : (($score >= 6) ? '#eab308' : '#10b981'));
                                        $count = $inherentMatrix[$p][$d] ?? 0;
                                    @endphp
                                    <td style="background-color: {{ $color }}; color: #fff;">
                                        @if($count > 0) <span class="count-badge">{{ $count }}</span> @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                        <tr><td style="border:none;"></td>@for($d = 1; $d <= 5; $d++)<td class="matrix-label" style="border:none;">{{ $d }}</td>@endfor</tr>
                    </table>
                </div>
            </td>
            <td width="25%" style="border:none; padding-right: 10px;">
                <div class="matrix-box">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 7px; color: #111;">PETA RESIDUAL</div>
                    <table class="matrix-table">
                        @for($p = 5; $p >= 1; $p--)
                            <tr>
                                <td class="matrix-label" style="border:none; width: 6px;">{{ $p }}</td>
                                @for($d = 1; $d <= 5; $d++)
                                    @php
                                        $score = $p * $d;
                                        $color = ($score >= 16) ? '#ef4444' : (($score >= 11) ? '#f97316' : (($score >= 6) ? '#eab308' : '#10b981'));
                                        $count = $residualMatrix[$p][$d] ?? 0;
                                    @endphp
                                    <td style="background-color: {{ $color }}; color: #fff;">
                                        @if($count > 0) <span class="count-badge">{{ $count }}</span> @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                        <tr><td style="border:none;"></td>@for($d = 1; $d <= 5; $d++)<td class="matrix-label" style="border:none;">{{ $d }}</td>@endfor</tr>
                    </table>
                </div>
            </td>
            <td width="50%" style="border:none;">
                <div class="matrix-box" style="text-align: left;">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 7px; color: #111; text-align: center;">DISTRIBUSI RISIKO PER KATEGORI</div>
                    @php $maxCat = $categoryStats->max('risks_count') ?: 1; @endphp
                    @foreach($categoryStats as $cat)
                        <div style="margin-bottom: 2px;">
                            <div style="font-size: 6px; margin-bottom: 1px;">{{ $cat->nama_kategori }} ({{ $cat->risks_count }})</div>
                            <div style="background-color: #eee; width: 100%; height: 4px; border-radius: 2px;">
                                <div style="background-color: #3b82f6; width: {{ ($cat->risks_count / $maxCat) * 100 }}%; height: 100%; border-radius: 2px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>

    <div class="matrix-box" style="margin-bottom: 15px; text-align: left;">
        <div style="font-weight: bold; margin-bottom: 8px; font-size: 8px; color: #111; text-align: center; border-bottom: 1px solid #eee; padding-bottom: 3px;">DAMPAK RISIKO TERHADAP INDEKS KINERJA (SEGMENTASI)</div>
        <table width="100%" style="border:none;">
            <tr>
                @foreach($indicatorStats as $type => $indicators)
                <td width="{{ 100 / count($indicatorStats) }}%" style="border:none; padding: 0 5px; vertical-align: top;">
                    <div style="font-weight: bold; font-size: 7px; color: #444; margin-bottom: 4px; border-left: 2px solid #10b981; padding-left: 5px;">{{ strtoupper($type) }}</div>
                    @php $maxInd = $indicators->max('risks_count') ?: 1; @endphp
                    @foreach($indicators as $ind)
                    <div style="margin-bottom: 3px;">
                        <div style="font-size: 6px; color: #666; margin-bottom: 1px;">{{ $ind->nama_indikator }} ({{ $ind->risks_count }})</div>
                        <div style="background-color: #f3f4f6; width: 100%; height: 3px; border-radius: 1.5px;">
                            <div style="background-color: #10b981; width: {{ ($ind->risks_count / $maxInd) * 100 }}%; height: 100%; border-radius: 1.5px;"></div>
                        </div>
                    </div>
                    @endforeach
                </td>
                @endforeach
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20px;">No</th>
                <th style="width: 130px;">Pernyataan Risiko & Penyebab</th>
                <th style="width: 100px;">Sasaran & Indikator Kinerja</th>
                <th style="width: 50px;">Inherent Risk</th>
                <th style="width: 130px;">Mitigasi & Pengendalian</th>
                <th style="width: 110px;">Realisasi & Residual Risk</th>
                <th style="width: 35px;">Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($risks as $index => $risk)
                @php
                    $latest = $risk->monitorings->sortByDesc('tanggal_update')->first();
                    $resScore = $latest ? ($latest->residual_probabilitas * $latest->residual_impact) : $risk->skor_risiko;
                    $resLvl = $latest ? \App\Http\Controllers\RiskEvaluationController::calculateLevel($resScore) : $risk->level_risiko;
                    $delta = $risk->skor_risiko - $resScore;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="font-bold">{{ $risk->nama_risiko }}</div>
                        <div style="margin-top: 3px;"><span class="font-bold">Causa:</span> {{ $risk->penyebab ?? '-' }}</div>
                        <div style="margin-top: 3px;"><span class="font-bold">Dampak:</span> {{ $risk->dampak ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="font-bold">SS:</div><div>{{ $risk->sasaran_strategis ?? '-' }}</div>
                        <div class="font-bold" style="margin-top: 3px;">IK:</div><div>{{ $risk->indikatorKinerja->nama_indikator ?? '-' }}</div>
                    </td>
                    <td class="text-center">
                        <div class="font-bold">{{ $risk->probabilitas }}&times;{{ $risk->level_dampak }}={{ $risk->skor_risiko }}</div>
                        <div class="badge level-{{ strtolower($risk->level_risiko) }}" style="margin-top: 3px;">{{ $risk->level_risiko }}</div>
                    </td>
                    <td>
                        @foreach($risk->mitigations as $mit)
                            <div style="margin-bottom: 3px; border-bottom: 0.1px solid #eee; padding-bottom: 2px;">
                                <span class="font-bold">{{ $mit->strategi }}:</span> {{ $mit->rencana_aksi }}
                                <br><span style="color: #666;">(PIC: {{ $mit->penanggung_jawab }})</span>
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @if($latest)
                            <div class="font-bold" style="color: var(--green-main);">Progress: {{ $latest->progress }}%</div>
                            <div style="margin-top: 2px; font-style: italic;">"{{ $latest->catatan }}"</div>
                            <div style="margin-top: 4px; padding-top: 3px; border-top: 1px dashed #ccc;">
                                <span class="font-bold">Residual Score:</span> {{ $latest->residual_probabilitas ?? $risk->probabilitas }}&times;{{ $latest->residual_impact ?? $risk->level_dampak }}={{ $resScore }}
                                <br><div class="badge level-{{ strtolower($resLvl) }}" style="margin-top: 2px;">{{ $resLvl }}</div>
                            </div>
                        @else
                            <div class="text-center" style="color: #999; margin-top: 10px;">Belum ada realisasi/monitoring.</div>
                        @endif
                    </td>
                    <td class="text-center font-bold" style="font-size: 7px;">
                        @if($delta > 0) <span style="color: green;">TURUN ({{ $delta }})</span>
                        @elseif($delta < 0) <span style="color: red;">NAIK ({{ abs($delta) }})</span>
                        @else <span style="color: gray;">STABIL</span>
                        @endif
                        <br><br>
                        {{ strtoupper($risk->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; width: 100%;">
        <table width="100%" style="border:none;">
            <tr>
                <td width="70%" style="border:none;"></td>
                <td width="30%" style="text-align: center; border:none;">
                    <p>Cirebon, {{ $date }}</p>
                    <p style="font-weight: bold; margin-top: 5px;">Risk Officer / Manager,</p>
                    <div style="margin-top: 50px; border-bottom: 1px solid #000; width: 150px; margin-left: auto; margin-right: auto;"></div>
                    <p style="margin-top: 5px;">NIP. ............................................</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <span class="page-number"></span> | Sistem Manajemen Risiko UIN Siber Syekh Nurjati Cirebon | https://uinssc.ac.id | Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>