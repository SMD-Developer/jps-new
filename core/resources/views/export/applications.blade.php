<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width:100%;
            border-collapse: collapse;
        }

        th {
            background:#f2f2f2;
            font-weight:bold;
        }

        th, td {
            border:1px solid #000;
            padding:5px;
            text-align:center;
        }

        .left {
            text-align:left;
        }

    </style>
</head>

<body>

<h3 style="text-align:center;">
    Permohonan Baru
</h3>


<table>

<thead>
<tr>
    <th>Bil</th>
    <th>Tarikh</th>
    <th>Reference No</th>
    <th>Jenis Akaun</th>
    <th>Jenis Permohonan</th>
    <th>Nama Pemohon</th>
    <th>Lot/PT</th>
    <th>Jumlah Sumbangan (RM)</th>
    <th>Status Staff</th>
    <th>Status Pelulus</th>
    <th>Status Keseluruhan</th>
</tr>
</thead>


<tbody>

@foreach($applications as $key=>$application)

<tr>

<td>
{{ $key+1 }}
</td>


<td>
{{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}
</td>


<td>
{{ $application->refference_no ?? '-' }}
</td>


<td>
@if($application->client)

@php

$accountTypes = [
    1 => 'Individu',
    2 => 'Pemaju',
    3 => 'Agensi Kerajaan',
    4 => 'Perunding'
];

echo $accountTypes[$application->client->accountType] ?? 'N/A';

@endphp

@else
N/A
@endif
</td>


<td>

@if($application->application_type == 'reapply')

Memohon Semula

@elseif($application->application_type == 'appeal')

Appeal

@else

Baru

@endif

</td>


<td class="left">
{{ strtoupper($application->applicant) }}
</td>


<td class="left">

{{ strtoupper(
    $application->land_lot .
    ', ' .
    $application->land_area .
    ', ' .
    ($application->landDivision->mukim ?? '') .
    ', DAERAH ' .
    ($application->landDistrict->daerah ?? '')
) }}

</td>


<td>
@if($application->client)

{{ number_format($application->final_amount,2) }}

@else

N/A

@endif
</td>


<td>

{{ ucfirst($application->status) }}

</td>


<td>

@if($application->status == 'approved')

Lulus

@elseif($application->status == 'rejected')

Ditolak

@else

Dalam Proses

@endif

</td>


<td>

@if($application->status == 'approved')

Selesai

@elseif($application->status == 'rejected')

Ditolak

@else

Dalam Proses

@endif

</td>


</tr>

@endforeach


</tbody>

</table>

</body>
</html>