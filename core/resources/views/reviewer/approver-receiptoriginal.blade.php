@extends('clientarea.app')
<style>
    /* General Styles */
    body {
        font-family: sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
        /*background-color: #f4f6f9;*/
    }

@import url(https://fonts.googleapis.com/css?family=Denk+One);
@import url(https://fonts.googleapis.com/css?family=Arimo);
.rotingtxt{
	-webkit-transform: rotate(331deg);
	-moz-transform: rotate(331deg);
	-o-transform: rotate(331deg);
	transform: rotate(331deg);
	font-size: 10em;
	color: #cccccc;
	position: absolute;
	font-family: 'Denk One', sans-serif;
	text-transform:uppercase;
	/*padding-left: 10%;*/
	/*display: flex;*/
    /*text-align: center;*/
    font-weight: 700;
    top: 19rem;
    left: 25%;
  
}

.content{
            background-color: #f4f6f9;
            margin-bottom: 50px;
}

.container{
      padding-inline: 120px !important;
      
}
.row1{
        display: flex;
    justify-content: center;
}
 table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
button{
    border-radius: 20px !important;
    padding: 7px 50px !important;
}

button.btn.btn-primary.float-right{
    width: max-content;
}
</style>
<title>@lang('app.receipt') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-file"></i> @lang('app.receipt')</h5>
    </div> 
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <p class="rotingtxt">ASAL</p>
               <div class="row">
                   <div class="col-12 row1">
                       <img src="{{ asset('assets/images/uploads/settings/1732803848.png') }}" class="img " alt="...">
                   </div>
               </div>
               <div class="row">
                   <div class="col-3"></div>
                   <div class="col-5 px-0">
                        <p class="mb-0 pl-3">KERAJAAN NEGERI SELANGOR DARUL EHSAN</p>
                        <p class="mb-0 text-center">Resit Resmi</p>
                        <p class="text-center">ASAL</p>
                   </div>
                   <div class="col-4">
                       <p class="mb-0">(Kew.38E 03-2021)</p>
                       <!--<p></p>-->
                       <p class="mb-0">No. Resit : 24TUTR0500066</p>
                       <p>Tarikh  &nbsp; &nbsp; &nbsp;: 31/07/2024</p>
                   </div>
               </div>
               <div class="row">
                   <div class="col-12">
                       <p>Diterima daripada &nbsp; &nbsp; &nbsp;: &nbsp; KAHARUL ARIFFIN BIN MOHD NOOR</p>
                       <p>No. Kad Pengenalan/ No Daftar Perniagaan &nbsp; &nbsp; : * </p>
                       <p class="mb-0">Alamat &nbsp; &nbsp;: &nbsp; (PEMEGANG SURAT WAKIL KUASA KEPADA NORZILAH BINTI MOHD NOH DAN RAKAN-RAKAN)</p>
                       <p class="mb-0 pl-5">&nbsp; &nbsp; &nbsp; NO.29, RUMAH MURAH RAKYAT</p>
                       <p class="mb-0 pl-5">&nbsp; &nbsp; &nbsp; RANTAJU</p>
                       <p class="mb-0 pl-5">&nbsp; &nbsp; &nbsp; 71200</p>
                       <p class="pl-5">&nbsp; &nbsp; &nbsp; NEGERI SEMBILAN</p>
                       
                       <table style="width:100%; text-align: center;">
                              <tr>
                                <th>Bill</th>
                                <th>Perihal Terimaan</th> 
                                <th>Cara Bayaran</th>
                                <th>No Rujukan / <br> Tarikh</th>
                                <th>Vot/Dana</th>
                                <th>Kod Akaun</th>
                                <th>Amaun (RM)</th>
                              </tr>
                              <tr class="data-row px-5" style="vertical-align: baseline;">
                                <td class="pt-2">1.</td>
                                <td style="width: 70px;">L453-PTSEL/04/B/PTS/2024/1- G001- BAGI HAKMILIK GM 699 LOT 1044 SELUAS 1.6163 HEKTAR (3.9940 EKAR) DI MUKIM BESTARI JAYA,DAERAH KUALA SELANGOR</td>
                                <td>BANK DRAF</td>
                                 <td>008659 / <br><br> 13/11/2024 </td>
                                <td>L453 <br><br> G001</td>
                                <td>H0161304 <br><br> H0161304</td>
                                <td class="text-right">9,985.00 <br><br> 9,985.00</td> 
                              </tr>
                       </table>
                       <table style="width:100%; text-align: center; margin-top:50px;">
                              <tr class="">
                                <td class="py-4" >
                                   <div class="row" style="font-weight: 600;">
                                        <div class="col-7"></div>
                                        <div class="col-3  text-right">
                                            <p class="mb-0">Jumlah Sebelum Cukai</p>
                                            <p class="mb-0">Cukai (0%)</p>
                                            <p class="mb-0">Jumlah Selepas Cukai</p>
                                        </div>
                                         <div class="col-2  text-right ">
                                            <p class="mb-0">19,970.00 </p>
                                            <p class="mb-0">0.00 </p>
                                            <p class="mb-0">19,970.00 </p>
                                        </div>
                                   </div>
                                </td>
                              </tr>
                       </table>
                       
                       <p class="mt-4 mb-0">Ringgit Malaysia : Sembilan Belas Ribu Sembilan Ratus Tujuh Puluh Sahaja</p>
                       <p class="mb-0">Catatan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : L453-PTSEL/04/B/PTS/2024/1-G001- BAGI HAKMILIK GM 699 LOT 1044 SELUAS 1.6163 HEKTAR </p>
                       <p style="padding-left: 107px;">  : (3.9940 EKAR) DI MUKIM BESTARI JAYA, DAERAH KUALA SELANGOR</p>
                       <p class="mb-0">Jabatan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : JABATAN PENGAIRAN & SALIRAN SELANGOR PTJ</p>
                       <p class="mb-0">PTJ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: PENGARAH PENGAIRAN & SALIRAN</p>
                       <p> Pusat Terimaan &nbsp; : 22101000 - PENGAWI DAERAH & TANAH KUALA SELANGOR</p>
                       
                   </div>
               </div>
               <div class="row my-5">
                    <div class="col-7">
                        <P> (SURIAH BT MOHAMAD)</P>
                        
                    </div>
                    <div class="col-5">
                        <P>(31/07/2024 10:53:14 AM)</P>
                    </div>
               </div>
               <div class="row mt-5">
                    <div class="col-12">
                        <p class="text-center">Ini adalah cetakan komputer dan tidak perlu ditandatangani </p>
                    </div>
               </div>
               <div class="row mb-5">
                    <div class="col-9">
                        <p class=""> No. Kelulusan Perbendaharaan : MOF.BSKK.600-2/9/2(68)</p>
                    </div>
                    <div class="col-3">
                        <p class="">JANM 11 </p>
                    </div>
               </div>
            </div>
        </div>
     </div>
     <div class="container pb-5">
        <div class="row mb-5">
           <div class="col-md-6">
           </div>
           <div class="col-md-3">
               <button type="button" class="btn btn-danger float-right">Muat Turun</button>
           </div>
           <div class="col-md-3">
               <button type="button" class="btn btn-primary float-right">Cetak Resit</button>
           </div>
       </div>
    </div>
</section>
@endsection