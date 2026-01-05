@extends('third-party.layouts.app')

<style>
    /* Keep all existing styles from document 14 */
    body {
        font-family: sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }

    @import url(https://fonts.googleapis.com/css?family=Denk+One);
    @import url(https://fonts.googleapis.com/css?family=Arimo);

     .rotingtxt {
        -webkit-transform: rotate(331deg);
        -moz-transform: rotate(331deg);
        -o-transform: rotate(331deg);
        transform: rotate(331deg);
        font-size: 10em;
        color: #cccccc;
        position: absolute;
        font-family: 'Denk One', sans-serif;
        text-transform: uppercase;
        /*padding-left: 10%;*/
        /*display: flex;*/
        /*text-align: center;*/
        font-weight: 700;
        top: 26rem;
        left: 25%;
        opacity: 0.5;

    }
    
      .receipt-table th {
        font-size: 14px; 
    }
    
    
     .receipt-footer .info-row {
        display: flex;
        margin-bottom: 5px;
        align-items: flex-start;
    }

    .receipt-footer .label {
        width: 150px;
        flex-shrink: 0;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .receipt-footer .label::after {
        content: ":";
        margin-left: 5px;
    }

    .receipt-footer .value {
        flex-grow: 1;
        margin-left: 10px;
        align-self: flex-start;
    }
    
    .receipt-header .info-row {
        display: flex;
        margin-bottom: 5px;
        align-items: flex-start;
    }

    .receipt-header .label {
        width: 202px;
        flex-shrink: 0;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .receipt-header .label::after {
        content: ":";
        margin-left: 5px;
    }

    .receipt-header .value {
        flex-grow: 1;
        margin-left: 10px;
        align-self: flex-start;
    }

    .content {
        background-color: #f4f6f9;
        margin-bottom: 50px;
    }

    .container {
        padding-inline: 120px !important;

    }

    .row1 {
        display: flex;
        justify-content: center;
    }

    table,
    th,
    td {
        border: 1px solid black !important;
        border-collapse: collapse;
    }

    button {
        border-radius: 20px !important;
        padding: 7px 50px !important;
    }

    button.btn.btn-primary.float-right {
        width: max-content;
    }

    .custome-text{
        font-size:14px;
    }
    
    @media print {
        #printButton, #downloadButton, #backButton {
            display: none !important;
        }
    }
</style>

<title>@lang('app.receipt') | JPS - Third Party</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-file"></i> @lang('app.receipt')</h5>
    </div>
    
    <section class="content">
        <div class="container" id="receipt-content">
            <div class="row">
                <div class="col-4 mt-4 ml-auto text-right pr-0">
                    <p class="mb-0">(Kew.38E 03-2021)</p>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-12 row1" style="text-align: center;">
                            <img src="{{ asset('assets/images/uploads/settings/logo_jps-removebg-preview.png') }}" 
                                 style="width:30%; height:80%;" class="img" alt="JPS Logo">
                        </div>
                    </div>
                    
                    <div class="row align-items-center">
                        <div class="col-3"></div>
                        <div class="col-5 px-0">
                            <p class="mb-0 pl-3"><strong>KERAJAAN NEGERI SELANGOR DARUL EHSAN</strong></p>
                            <p class="mb-0 text-center"><strong>RESIT RASMI</strong></p>
                            <p class="text-center"><strong>ASAL</strong></p>
                        </div>
                    </div>
                    
                    {{-- Receipt content - same as document 14 --}}
                    <div class="receipt-container"
                        style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto;">
                        <div class="receipt-header">
                            <div class="info-row">
                                <div class="label">DITERIMA DARIPADA</div>
                                <div class="value">
                                    @if($application->payment_type === 'third_party')
                                        {{ strtoupper($application->buyer_name ?? $application->applicant) }}
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="label">NO. KAD PENGENALAN /</div>
                                <div class="value">{{ $application->payment_type === 'third_party' ? ($application->third_party_id_card ?? '-') : $application->identities }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">NO. DAFTAR PERNIAGAAN</div>
                                <div class="value"></div>
                            </div>
                            <div class="info-row">
                                <div class="label">ALAMAT</div>
                                <div class="value">
                                    @if($application->payment_type === 'third_party')
                                        {{ strtoupper($application->third_party_address ?? '-') }}
                                    @else
                                        {{ strtoupper($application->address) }}<br>
                                        {{ strtoupper($application->city) }}<br>
                                        {{ strtoupper($application->postal_code) }}<br>
                                        {{ strtoupper($application->negeri ?? 'N/A') }} DARUL EHSAN
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="label">NOMBOR RESIT</div>
                                <div class="value">{{ $application->receipt_number }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">TARIKH / MASA</div>
                                <div class="value">{{ $application->fpx_payment_time ?? $application->payment_date }}</div>
                            </div>
                            <div class="info-row" style="margin-bottom: 20px;">
                                <div class="label">PERIHAL TERIMAAN</div>
                                <div class="value">
                                     @if($application->payment_type === 'third_party')
                                        PERMOHONAN SALINAN RESIT CARUMAN PARIT DI ATAS <br>
                                    @endif
                                    {{ strtoupper($application->land_lot) }},
                                    {{ $application->hectare }} HEKTAR
                                    ({{ number_format($application->hectare * 2.47105, 2) }} EKAR)
                                    MUKIM {{ strtoupper($application->negeri ?? 'N/A') }}, DAERAH
                                    {{ strtoupper($application->daerah ?? 'N/A') }}<br>
                                    ({{ $application->refference_no ?? 'N/A'}})
                                </div>
                            </div>
                        </div>

                        <table class="receipt-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                            <tr style="background-color: #f2f2f2;">
                                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">BIL</th>
                                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">CARA BAYARAN</th>
                                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">NO RUJUKAN /<br>TARIKH
                                </th>
                                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">VOT/DANA</th>
                                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">KOD AKAUN</th>
                                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">AMAUN (RM)</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;" class="custome-text">1</td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;" class="custome-text">
                                    @if($application->payment_method === 'cheque')
                                        Cek<br>
                                        @if(!empty($application->transaction_id))
                                            <small>{{ $application->transaction_id }}</small>
                                        @endif
                                    @else
                                        @php
                                            $methodLabel = match($application->payment_method) {
                                                'FPX_B2C' => 'EFT_B2C',
                                                'FPX_B2B' => 'EFT_B2B',
                                                default => $application->payment_method,
                                            };
                                        @endphp
                                        {{ $methodLabel }}
                                    @endif
                                </td>
                                 <td style="border: 1px solid #ddd; padding: 8px; text-align: center; line-height: 20px;" class="custome-text">
                                    @php
                                        $txnId = $application->transaction_id ?? 'N/A';
                                        if ($txnId !== 'N/A' && str_starts_with($txnId, 'TXN-')) {
                                            $txnId = str_replace('TXN-', '', $txnId);
                                        }
                                    @endphp
                                    {{ $txnId }}<br>
                                    {{ $application->payment_date ? \Carbon\Carbon::parse($application->payment_date)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;" class="custome-text">
                                    @if($application->payment_type === 'third_party')
                                        G001
                                    @else
                                        L453<br>G001
                                    @endif
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;" class="custome-text">
                                    @if($application->payment_type === 'third_party')
                                        H0272499
                                    @else
                                        H0161304<br>H0161304
                                    @endif
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: right;" class="custome-text">
                                    @php
                                        $secondHalf = floor($application->payment_amount * 100 / 2) / 100;
                                        $firstHalf = $application->payment_amount - $secondHalf;
                                    @endphp
                                    {{ number_format($firstHalf, 2) }}<br>
                                    {{ number_format($secondHalf, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"
                                    style="border: 1px solid #ddd; padding: 8px; text-align: right; font-weight: bold; font-size:14px;" class="custome-text">
                                    JUMLAH KESELURUHAN </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: right; font-weight: bold;" class="custome-text">
                                    {{ number_format($application->payment_amount, 2) }}
                                </td>
                            </tr>
                        </table>
                         <div class="receipt-footer">
                            <div class="info-row">
                                <div class="label">RINGGIT MALAYSIA</div>
                                <div class="value">
                                    {{ strtoupper(\App\Helpers\NumberHelper::numberToMalayWords($application->payment_amount)) }} SAHAJA
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="label">JABATAN</div>
                                <div class="value">JABATAN PENGAIRAN & SALIRAN SELANGOR PTJ</div>
                            </div>
                            <div class="info-row">
                                <div class="label">PTJ</div>
                                <div class="value">PENGARAH PENGAIRAN & SALIRAN</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-12">
                            <p class="text-center">INI ADALAH CETAKAN KOMPUTER DAN TIDAK PERLU DITANDATANGANI</p>
                        </div>
                    </div>
                    
                    <div class="row mb-5 mt-5">
                        <div class="col-9">
                            <p class="text-left">RESIT INI DIJANA OLEH SISTEM e-CARUMAN PARIT</p>
                            <p class="">NO KELULUSAN PERBENDAHARAAN : PWN.SEL.600-5/1/1 JLD.1 (49)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container pb-5">
            <div class="row mb-5 justify-content-end">
                <div class="col-auto">
                    <button class="btn btn-success" id="backButton" onClick="window.history.back()">Kembali</button>
                </div>
                <div class="col-auto" style="display:none;">
                    <button type="button" id="downloadButton" class="btn btn-danger">@lang('app.download')</button>
                </div>
                <div class="col-auto">
                    <button type="button" id="printButton" class="btn btn-primary">@lang('app.print_receipt')</button>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-auto text-end">
                    <p style="font-size: 14px; color: #555; font-style: italic; margin-top: 5px;">
                        <strong>Nota:</strong> Sila pastikan Resit <u>ASAL PIHAK KETIGA</u> dicetak untuk rekod.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Keep all scripts from document 14 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('downloadButton').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            html2canvas(document.getElementById('receipt-content'), {
                scale: 2, 
                useCORS: true,
                allowTaint: true,
                width: document.getElementById('receipt-content').offsetWidth,
                height: document.getElementById('receipt-content').offsetHeight
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgProps = doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                doc.save('Receipt_ThirdParty_' + '{{ $application->refference_no }}' + '.pdf');
            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('Failed to generate PDF. Please try again.');
            });
        });

        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>

@endsection