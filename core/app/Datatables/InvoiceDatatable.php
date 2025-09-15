<?php
namespace App\Datatables;
use Html;
use App\Datatables\CoreDatatable;
use App\Models\Invoice;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class InvoiceDatatable extends CoreDatatable
{
    protected $editRoute = 'invoices.edit';
    protected string $deleteRoute = 'invoices.destroy';
    protected string $editDisplayMode = 'normal';
    protected string $showDisplayMode = 'normal';
    protected string $show_route = 'invoices.show';
    protected string $downloadRoute = 'invoice_pdf';
    protected string $paymentRoute = 'payments.create';
    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('invoice.view');
        $this->edit_permission = hasPermission('invoice.edit');
        $this->delete_permission = hasPermission('invoice.delete');
        $this->download_permission = hasPermission('invoice.download');
        $this->add_payment_permission = hasPermission('payment.create');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);   
        $dataTable->editColumn('client_name',function($row){
            return '<a href="'.route('clients.show', $row->client_id).'">'.$row->client_name ?? ''.'</a>';
        });  
        $dataTable->editColumn('due_date',function($row){
            return format_date($row->due_date);
        });  
        $dataTable->editColumn('status', function($row){
            return '<span class="badge '.statuses()[$row->status]['class'].'">'.ucwords(statuses()[$row->status]['label']).'</span>'; 
        });
        $dataTable->editColumn('amount',function($row){
            return format_amount($row->totals['grandTotal'],$row->currency);
        });
        $dataTable->editColumn('paid',function($row){
            return format_amount($row->totals['paid'],$row->currency);
        });
        $dataTable->editColumn('due',function($row){
            return format_amount($row->totals['amountDue'],$row->currency);
        });
        $dataTable->filterColumn('client_name',function($query, $keyword){
            return $query->whereRaw('clients.name LIKE ?',["%{$keyword}%"]);
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
    public function query(Invoice $model){
        return $model->newQuery()->join('clients','clients.uuid','=','invoices.client_id')->select('invoices.*','clients.name as client_name');
    }
    protected function getColumns(){
        return [
                'invoice_no' => [
                    'data' => 'invoice_no',
                    'data_type' => 'text',
                    'title' => trans('app.invoice_number')
                ],
                'status' => [
                    'data' => 'status',
                    'data_type' => 'boolen',
                    'title' => trans('app.status')
                ],
                'client_name' => [
                    'data' => 'client_name',
                    'data_type' => 'text',
                    'title' => trans('app.client')
                ],
                'due_date' => [
                    'data' => 'due_date',
                    'data_type' => 'text',
                    'title' => trans('app.due_date')
                ],
                'amount'=> [
                    'title' => trans('app.amount'),
                    'data_type' => 'text',
                    'searchable'=>false,
                    'orderable'=>false
                ],
                'paid'=> [
                    'title' => trans('app.paid'),
                    'data_type' => 'text',
                    'searchable'=>false,
                    'orderable'=>false
                ],
                'due'=> [
                    'title' => trans('app.amount_due'),
                    'data_type' => 'text',
                    'searchable'=>false,
                    'orderable'=>false
                ]
            ]+$this->btnAction;
    }
}
