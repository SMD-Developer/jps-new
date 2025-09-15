<?php
namespace App\Datatables;
use App\Datatables\CoreDatatable;
use App\Models\TaxSetting;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class TaxDatatable extends CoreDatatable
{
    protected $editRoute = 'settings.tax.edit';
    protected string $deleteRoute = 'settings.tax.destroy';
    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('tax-setting.view');
        $this->edit_permission = hasPermission('tax-setting.edit');
        $this->delete_permission = hasPermission('tax-setting.delete');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);
        $dataTable->editColumn('value',function($row){
            return $row->value.'%';
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
    public function query(TaxSetting $model)
    {
        return $model->newQuery()->select();
    }
    protected function getColumns(){
        return [
            'name' => [
                'data' => 'name',
                'data_type' => 'text',
                'title' => trans('app.name')
            ],
            'value' => [
                'data' => 'value',
                'data_type' => 'text',
                'title' => trans('app.value'),
                'class'=>'text-center'
            ],
            'selected' => [
                'data' => 'selected',
                'data_type' => 'boolean',
                'title' => trans('app.default'),
                'class'=>'text-center'
            ]
        ]+$this->btnAction;
    }
}
