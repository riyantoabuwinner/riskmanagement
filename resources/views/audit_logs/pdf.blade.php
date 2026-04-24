<!DOCTYPE html>
<html>
<head>
    <title>Audit Log Report</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #047857; padding-bottom: 10px; }
        .header h2 { color: #047857; margin-bottom: 5px; }
        .info { margin-bottom: 15px; font-size: 9pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { background-color: #f8fafc; color: #475569; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8pt; color: #94a3b8; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Log Aktivitas Sistem</h2>
        <div>RiskManagement UINSSC</div>
    </div>

    <div class="info">
        @if($start_date || $end_date)
            <strong>Periode:</strong> 
            {{ $start_date ? \Carbon\Carbon::parse($start_date)->format('d/m/Y') : 'Awal' }} 
            s/d 
            {{ $end_date ? \Carbon\Carbon::parse($end_date)->format('d/m/Y') : 'Sekarang' }}
        @else
            <strong>Periode:</strong> Semua Data
        @endif
        <br>
        <strong>Dicetak pada:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Waktu</th>
                <th width="15%">User</th>
                <th width="15%">IP Address</th>
                <th width="40%">Aktivitas</th>
                <th width="15%">Risiko</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->waktu->format('d/m/Y H:i') }}</td>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ $log->aktivitas }}</td>
                <td>{{ $log->risk->nama_risiko ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman ini dicetak secara otomatis oleh sistem manajemen risiko.
    </div>
</body>
</html>
