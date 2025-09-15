<?php
namespace App\Datatables;
use Html;
use App\Datatables\CoreDatatable;
use App\Models\Estimate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class EstimateDatatable extends CoreDatatable
{
    protected $editRoute = 'estimates.edit';
    protected string $deleteRoute = 'estimates.destroy';
    protected string $editDisplayMode = 'normal';
    protected string $showDisplayMode = 'normal';
    protected string $downloadRoute = 'estimate_pdf';
    protected string $show_route = 'estimates.show';
    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('estimate.view');
        $this->edit_permission = hasPermission('estimate.edit');
        $this->delete_permission = hasPermission('estimate.delete');
        $this->download_permission = hasPermission('estimate.download');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);    
        $dataTable->editColumn('client_name',function($row){
            return '<a href="'.route('clients.show', $row->client_id).'">'.$row->client_name ?? ''.'</a>';
        });  
        $dataTable->editColumn('estimate_date',function($row){
            return format_date($row->estimate_date);
        });  
        $dataTable->editColumn('amount',function($row){
            return '<span style="display:inline-block"> '.format_amount($row->totals['grandTotal'],$row->currency).'</span>';
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
    public function query(Estimate $model)
    {
        return $model->newQuery()->join('clients','clients.uuid','=','estimates.client_id')->select('estimates.*','clients.name as client_name');
    }
    protected function getColumns(){
        return [
                'estimate_no' => [
                    'data' => 'estimate_no',
                    'data_type' => 'text',
                    'title' => trans('app.estimate_number')
                ],
                'client_name' => [
                    'data' => 'client_name',
                    'data_type' => 'text',
                    'title' => trans('app.client')
                ],
                'estimate_date' => [
                    'data' => 'estimate_date',
                    'data_type' => 'text',
                    'title' => trans('app.estimate_date')
                ],
                'amount' => [
                    'data' => 'amount',
                    'data_type' => 'text',
                    'title' => trans('app.amount'),
                    'searchable'=>false,
                    'orderable'=>false
                ]
            ]+$this->btnAction;
    }
}
