<?php
namespace App\Datatables;
use Html;
use App\Datatables\CoreDatatable;
use App\Models\Product;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class ProductDatatable extends CoreDatatable
{
    protected $editRoute = 'products.edit';
    protected string $deleteRoute = 'products.destroy';
    protected string $show_route = 'products.show';
    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('product.view');
        $this->edit_permission = hasPermission('product.edit');
        $this->delete_permission = hasPermission('product.delete');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);  
        $dataTable->editColumn('category_id', function($data){ return $data->category ? $data->category->name : ''; }); 
        $dataTable->editColumn('image',function($row){
           return  '<a href="javascript:void(0);" data-toggle="popover" data-trigger="hover" title="'.$row->name.'" data-html="true" data-content="Html content">'.\Html::image($row->imageUrl, 'image', ['style'=>'width:50px']).'</a>';
        });
        $dataTable->editColumn('price', function($data){ return format_amount($data->price); });
        $dataTable->rawColumns(['image']);  
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
    public function query(Product $model)
    {
        return $model->newQuery()->select();
    }
    protected function getColumns(){
        return [
            'photo' => [
                'data' => 'image',
                'data_type' => 'text',
                'title' => trans('app.photo')
            ],
            'name' => [
                'data' => 'name',
                'data_type' => 'text',
                'title' => trans('app.name')
            ],
            'code' => [
                'data' => 'code',
                'data_type' => 'text',
                'title' => trans('app.code')
            ],
            'category_id' => [
                'data' => 'category_id',
                'data_type' => 'text',
                'title' => trans('app.category')
            ],
            'price' => [
                'data' => 'price',
                'data_type' => 'text',
                'title' => trans('app.price')
            ]
        ]+$this->btnAction;
    }
}
