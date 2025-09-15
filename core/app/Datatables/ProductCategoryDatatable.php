<?php
namespace App\Datatables;
use App\Datatables\CoreDatatable;
use App\Models\ProductCategory;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class ProductCategoryDatatable extends CoreDatatable
{
    protected $editRoute = 'products.category.edit';
    protected string $deleteRoute = 'products.category.destroy';
    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('product-category.view');
        $this->edit_permission = hasPermission('product-category.edit');
        $this->delete_permission = hasPermission('product-category.delete');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);        
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
    public function query(ProductCategory $model)
    {
        return $model->newQuery()->select();
    }
    protected function getColumns(){
        return [
                'name' => [
                    'data' => 'name',
                    'data_type' => 'text',
                    'title' => trans('app.name')
                ]
            ]+$this->btnAction;
    }
}
