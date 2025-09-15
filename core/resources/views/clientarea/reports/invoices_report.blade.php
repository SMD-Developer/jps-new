<div class="col-md-12" id="report_content">
    @include('clientarea.reports.partials.report_header',['report_type'=>trans('app.invoice_report')])
    <table class="table table-hover table-bordered ">
        <thead>
        <tr class="table_header">
            <th>@lang('app.status')</th>
            <th>@lang('app.invoice_number')</th>
            <th>@lang('app.date')</th>
            <th>@lang('app.client')</th>
            <th class="text-right">@lang('app.amount')</th>
            <th class="text-right">@lang('app.paid')</th>
            <th class="text-right">@lang('app.amount_due')</th>
        </tr>
        </thead>
        <tbody>
        @php($total_invoiced = 0)
        @php($total_paid = 0)
        @php($total_due = 0)
        @foreach($invoices as $invoice)
            @php ($total_invoiced += currency_convert(getCurrencyId($invoice->currency),$invoice->totals['grandTotal']))
            @php ($total_paid += currency_convert(getCurrencyId($invoice->currency),$invoice->totals['paidFormatted']))
            @php ($total_due += currency_convert(getCurrencyId($invoice->currency),$invoice->totals['amountDue']))
            <tr>
                <td><span class="badge {{ statuses()[$invoice->status]['class'] }}">{{ strtoupper(statuses()[$invoice->status]['label']) }}</span></td>
                <td><a href="{{ route('cinvoices.show', $invoice->uuid) }}">{{ $invoice->number }}</a></td>
                <td>{{ format_date($invoice->invoice_date) }}</td>
                <td>{{ $invoice->client->name }}</td>
                <td class="text-right">{{  format_amount(currency_convert(getCurrencyId($invoice->currency),$invoice->totals['grandTotal']),defaultCurrency()) }} </td>
                <td class="text-right">{{  format_amount(currency_convert(getCurrencyId($invoice->currency),$invoice->totals['paidFormatted']),defaultCurrency()) }} </td>
                <td class="text-right">{{  format_amount(currency_convert(getCurrencyId($invoice->currency),$invoice->totals['amountDue']),defaultCurrency()) }} </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-bold" colspan="4">{{ trans('app.total') }}</td>
            <td class="text-bold text-right">{{ format_amount($total_invoiced,defaultCurrency()) }}</td>
            <td class="text-bold text-right">{{ format_amount($total_paid,defaultCurrency()) }}</td>
            <td class="text-right text-bold text-red" colspan="4">{{ format_amount($total_due,defaultCurrency()) }}</td>
        </tr>
        </tbody>
    </table>
</div>