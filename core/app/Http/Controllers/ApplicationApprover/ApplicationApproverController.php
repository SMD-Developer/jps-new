<?php

namespace App\Http\Controllers\ApplicationApprover;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use Illuminate\Support\Facades\DB;


class ApplicationApproverController extends Controller
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
        $totalapplication = DB::table('applications')
        ->where('forwarded_by_admin_staff', 1)
        ->count();
        $totalclient = DB::table('client_register')->count();
        $newapplication = DB::table('applications')->where('status', 'pending')
        ->where('forwarded_by_admin_staff', 1)
        ->count(); 
        $monthapplication = DB::table('applications')
            ->whereMonth('created_at', date('m'))
            ->where('forwarded_by_admin_staff', 1)
            ->count(); 
        $approvedapplication = DB::table('applications')->where('status', 'approved')
        ->where('forwarded_by_admin_staff', 1)
        ->count(); 
        $passed = DB::table('applications')->where('status', 'approved')
        ->where('forwarded_by_admin_staff', 1)
        ->count();
        $rejected = DB::table('applications')->where('status', 'rejected')
        ->where('forwarded_by_admin_staff', 1)
        ->count();
        
        $applicationsByDistrict = DB::table('applications')
            ->select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->get();
            
             $districtCounts = DB::table('applications')
            ->select('district', DB::raw('count(*) as count'))
            ->where('forwarded_by_admin_staff', 1)  
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
        
        return view('admin_approver.home', compact(
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
