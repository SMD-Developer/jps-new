<?php
namespace App\Datatables\ClientArea;

use App\Datatables\CoreDatatable;
use App\Models\Payment;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class PaymentDatatable extends CoreDatatable{
    protected string $show_route = 'cpayments.show';
    const SHOW_URL_ROUTE = '';
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE); 
        $dataTable->editColumn('invoice_no',function($row){
            return $row->invoice ? '<a href="'.route('cinvoices.show', $row->invoice->uuid).'">'.$row->invoice_no.'</a>' : null;
        });          
        $dataTable->editColumn('payment_date',function($row){
            return format_date($row->payment_date);
        });    
        $dataTable->editColumn('amount',function($row){
            return $row->invoice ? format_amount($row->amount,$row->invoice->currency) : null;
        });
        $dataTable->filterColumn('invoice_no',function($query, $keyword){
            return $query->whereRaw('invoices.invoice_no LIKE ?',["%{$keyword}%"]);
        }); 
        $dataTable->filterColumn('payment_method',function($query, $keyword){
            return $query->whereRaw('payment_methods.name LIKE ?',["%{$keyword}%"]);
        });      
        return $dataTable;
    }
    public function builder(): Builder
    {
        $builder = parent::builder();
        $builder->hasQueryFilters = false;
        $builder->columns($this->getColumns())
            ->setTableAttribute('class', 'table table-hover table-striped table-bordered')
            ->parameters([
                'dom' => 'Bfrtip',
                'responsive' => true,
                'stateSave' => true,
                "oLanguage" => [
                    'sLengthMenu' => "_MENU_",
                    'buttons'=> [
                        'pageLength' => " %d ".trans('app.records'),
                    ],
                    'sSearch'=>"",
                ],
                "bInfo"  => false,
                'buttons' => [
                    ['extend' => 'print', 'className' => 'btn-xs btn-info', 'text' => '<i class="fa fa-print"></i> '.trans('app.print')],
                    ['extend' => 'csv', 'className' => 'btn-xs btn-warning', 'text' => '<i class="fa fa-file-excel-o"> </i> '. trans('app.csv')],
                    ['extend' => 'pageLength', 'className' => 'btn-xs btn-secondary'],
                ],
                'regexp'  => true
            ]);
        if (!empty($this->filterDefinition)) {
            $builder->hasQueryFilters = true;
        }
        return $builder;
    }
    public function query(Payment $model)
    {
        return $model->newQuery()
            ->join('invoices','invoices.uuid','=','payments.invoice_id')
            ->join('payment_methods','payment_methods.uuid','=','payments.method')
            ->where('invoices.client_id',auth()->guard('user')->id())
            ->select('payments.*','invoices.invoice_no','payment_methods.name as payment_method');
    }
    protected function getColumns(){
        return [
                'invoice_no' => [
                    'data' => 'invoice_no',
                    'data_type' => 'text',
                    'title' => trans('app.invoice_number')
                ],
                'payment_date' => [
                    'data' => 'payment_date',
                    'data_type' => 'text',
                    'title' => trans('app.date')
                ],
                'payment_method' => [
                    'data' => 'payment_method',
                    'data_type' => 'text',
                    'title' => trans('app.payment_method')
                ],
                'amount' => [
                    'data' => 'amount',
                    'data_type' => 'text',
                    'title' => trans('app.amount')
                ],
                'notes' => [
                    'data' => 'notes',
                    'data_type' => 'text',
                    'title' => trans('app.notes')
                ],
            ]+$this->btnAction;
    }
}
