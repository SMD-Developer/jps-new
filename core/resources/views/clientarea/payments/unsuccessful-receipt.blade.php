@extends('clientarea.app')

@section('content')
<div class="receipt-container">
    <div class="receipt-header">
        <h3>RECEIPT PAGE</h3>
    </div>
    
    <div class="receipt-content">
        <table class="receipt-table">
            <tr>
                <td>Transaction Status</td>
                <td style="color: red; font-weight: bold;">{{ $status }}</td>
            </tr>
            <tr>
                <td>FPX Transaction ID</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Seller Order Number</td>
                <td>{{ $fpx_sellerOrderNo }}</td>
            </tr>
            <tr>
                <td>Transaction Date & Time</td>
                <td>{{ $payment_date }}</td>
            </tr>
            <tr>
                <td>Buyer Bank</td>
                <td>{{ $fpx_buyerBankBranch }}</td>
            </tr>
            <tr>
                <td>Transaction Amount</td>
                <td>RM{{ number_format($transaction_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Unsuccessful Reason</td>
                <td style="color: red;">{{ $unsuccessful_reason }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection