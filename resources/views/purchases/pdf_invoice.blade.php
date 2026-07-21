<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Voucher Invoice</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 10px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .header-table td {
            vertical-align: top;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .details-table td {
            padding: 10px;
            border-bottom: 1px solid #edf2f7;
        }
        .label {
            font-weight: bold;
            color: #4a5568;
            width: 30%;
        }
        .value {
            color: #2d3748;
        }
        .total-box {
            margin-top: 40px;
            text-align: right;
            border-top: 2px solid #e2e8f0;
            padding-top: 15px;
        }
        .total-title {
            font-size: 16px;
            font-weight: bold;
            color: #4a5568;
        }
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #059669;
            margin-left: 20px;
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <table class="header-table">
            <tr>
                <td>
                    <div class="title">Purchase Voucher</div>
                    <span style="color: #718096; font-size: 12px;">Inventory Management System</span>
                </td>
                <td style="text-align: right; color: #4a5568;">
                    <strong>Voucher No:</strong> #{{ $purchase->purchase_no }}<br>
                    <strong>Date:</strong> {{ $purchase->date }}
                </td>
            </tr>
        </table>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 20px;">

        <table class="details-table">
            <tr>
                <td class="label">Supplier Identity</td>
                <td class="value">({{ $purchase->supplier_id }}) {{ $purchase->supplier->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Narration / Remarks</td>
                <td class="value">{{ $purchase->narration ?? 'No remarks recorded for this purchase voucher.' }}</td>
            </tr>
        </table>

        <div class="total-box">
            <span class="total-title">Total Net Amount:</span>
            <span class="total-amount">{{ number_format($purchase->total_amount, 2) }}</span>
        </div>

        <div class="footer">
            This is a system generated document. Generated on {{ date('Y-m-d H:i:s') }}
        </div>
    </div>

</body>
</html>