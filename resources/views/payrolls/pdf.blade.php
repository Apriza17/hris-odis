<!DOCTYPE html>
<html>

<head>
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1a56db;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .info-table td {
            padding: 5px;
        }

        .label {
            font-weight: bold;
            width: 120px;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .salary-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }

        .salary-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        .total-row {
            background-color: #eef2ff;
            font-weight: bold;
            color: #1e3a8a;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #888;
        }

        .stamp {
            margin-top: 10px;
            border: 1px dashed #ccc;
            padding: 10px;
            text-align: center;
            width: 150px;
            float: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>{{ $payroll->company->name }}</h1>
        <p>SLIP GAJI KARYAWAN PERIODE: {{ strtoupper($payroll->month) }} {{ $payroll->year }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Karyawan</td>
            <td>: {{ $payroll->employee->user->name }}</td>
            <td class="label">Jabatan</td>
            <td>: {{ $payroll->employee->position->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">NIP / ID</td>
            <td>: {{ $payroll->employee->nip ?? '-' }}</td>
            <td class="label">Departemen</td>
            <td>: {{ $payroll->employee->department->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td>: {{ \Carbon\Carbon::parse($payroll->pay_date)->format('d F Y') }}</td>
            <td class="label">Bank Transfer</td>
            <td>: {{ $payroll->employee->bank_name }} - {{ $payroll->employee->account_number }}</td>
        </tr>
    </table>

    <table class="salary-table">
        <thead>
            <tr>
                <th>KETERANGAN</th>
                <th style="text-align: right;">JUMLAH (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok</td>
                <td class="amount">{{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan</td>
                <td class="amount">{{ number_format($payroll->allowances, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td style="color: #dc2626;">Potongan (Terlambat/Alpha/Lainnya)</td>
                <td class="amount" style="color: #dc2626;">- {{ number_format($payroll->deductions, 0, ',', '.') }}
                </td>
            </tr>

            <tr class="total-row">
                <td style="padding: 15px;">TOTAL GAJI BERSIH (TAKE HOME PAY)</td>
                <td class="amount" style="font-size: 16px;">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><i>Dokumen ini digenerate otomatis oleh sistem OrcaHRIS.</i></p>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>

        <div class="stamp">
            APPROVED<br>
            <b>HR DEPARTMENT</b>
        </div>
    </div>

</body>

</html>
