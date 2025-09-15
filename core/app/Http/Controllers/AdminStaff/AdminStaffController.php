<?php

namespace App\Http\Controllers\AdminStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use App\Models\Application;
use DB;


class AdminStaffController extends Controller
{
      protected $invoice, $product, $client, $estimate, $payment, $expense;
    /**
     * Create a new controller instance.
     */
    public function __construct(Invoice $invoice, Product $product, Client $client, Estimate $estimate, Payment $payment, Expense $expense)
    {
        $this->invoice      = $invoice;
        $this->product      = $product;
        $this->client       = $client;
        $this->estimate     = $estimate;
        $this->payment      = $payment;
        $this->expense      = $expense;
    }


    public function index()
    {
        $totalapplication = DB::table('applications')->count(); // Total applications
        $totalclient = DB::table('client_register')->count(); 
        $newapplication = DB::table('applications')
                    ->where('status', 'pending')
                    ->whereNull('forwarded_by_admin_staff')
                    ->count();
        $monthapplication = DB::table('applications')
            ->whereMonth('created_at', date('m'))
            ->count(); 
        $approvedapplication = DB::table('applications')->where('status', 'approved')->count(); 
        $passed = DB::table('applications')->where('status', 'approved')->count();
        $rejected = DB::table('applications')->where('status', 'rejected')->count();
        
        $applicationsByDistrict = DB::table('applications')
            ->select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->get();
            
        $districtCounts = DB::table('applications')
        ->select('district', DB::raw('count(*) as count'))
        ->groupBy('district')
        ->get();
            
        $districts = [];
        foreach ($districtCounts as $item) {
            $districtInfo = DB::table('district')
                ->where('iddaerah', $item->district)
                ->first();
                
            if ($districtInfo) {
                $districts[] = [
                    'name' => $districtInfo->daerah,
                    'count' => $item->count
                ];
            }
        }
        
        return view('adminstaff.home_admin_staff', compact(
            'totalapplication', 
            'totalclient',
            'newapplication', 
            'monthapplication', 
            'approvedapplication', 
            'passed',
            'rejected',
            'applicationsByDistrict',
            'districts'
        ));
    }
}



