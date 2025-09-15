<?php
namespace App\Datatables;

use App\Models\Client;
use Collective\Html\HtmlFacade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class ClientDatatable extends CoreDatatable
{
    protected $editRoute = 'clients.edit';
    protected string $deleteRoute = 'clients.destroy';
    protected string $showDisplayMode = 'normal';
    protected string $show_route = 'clients.show';

    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('client.view');
        $this->edit_permission = hasPermission('client.edit');
        $this->delete_permission = hasPermission('client.delete');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);
        $dataTable->editColumn('photo',function($data){
            $photo = $data->photo != '' ? $data->photo : 'uploads/no-image.jpg';
            return HtmlFacade::image(image_url($photo),'Image',['class'=>'img-circle','width'=>'36px']);
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
    public function query(Client $model)
    {
        return $model->newQuery()->select();
    }
    protected function getColumns(){
        return [
                'client_no' => [
                    'data' => 'client_no',
                    'data_type' => 'text',
                    'title' => trans('app.client_no')
                ],
                'name' => [
                    'data' => 'name',
                    'data_type' => 'text',
                    'title' => trans('app.name')
                ],
                'photo' => [
                    'data' => 'photo',
                    'data_type' => 'text',
                    'title' => trans('app.photo')
                ],
                'email' => [
                    'data' => 'email',
                    'data_type' => 'text',
                    'title' => trans('app.email')
                ],
                'phone' => [
                    'data' => 'phone',
                    'data_type' => 'text',
                    'title' => trans('app.phone')
                ],
                'country' => [
                    'data' => 'country',
                    'data_type' => 'text',
                    'title' => trans('app.country')
                ]
            ]+$this->btnAction;
    }
}
