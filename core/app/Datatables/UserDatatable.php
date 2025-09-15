<?php
namespace App\Datatables;
use App\Models\User;
use Html;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class UserDatatable extends CoreDatatable
{
    protected $editRoute = 'users.edit';
    protected string $deleteRoute = 'users.destroy';
    protected string $showDisplayMode = 'normal';

    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('user.view');
        $this->edit_permission = hasPermission('user.edit');
        $this->delete_permission = hasPermission('user.delete');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);    
        $dataTable->editColumn('photo',function($row){
            $photo = $row->photo != '' ? $row->photo : 'uploads/no-image.jpg';
            return Html::image(image_url($photo),'Photo', ['class'=>'img-circle','width'=>'36px']);
        });  
        $dataTable->filterColumn('role_name',function($query, $keyword){
            return $query->whereRaw('roles.name LIKE ?',["%{$keyword}%"]);
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
                    ['extend' => 'pageLength', 'className' => 'btn-xs btn-secondary']
                ],
                'regexp'  => true
            ]);
        if (!empty($this->filterDefinition)) {
            $builder->hasQueryFilters = true;
        }
        return $builder;
    }
    public function query(User $model)
    {
        return $model->newQuery()
            ->join('roles','roles.uuid','=','users.role_id')
            ->where('users.uuid','!=',auth('admin')->id())
            ->select('users.*','roles.name as role_name');
        return $model->newQuery()->select();
    }
    protected function getColumns(){
        return [
            'photo' => [
                'data' => 'photo',
                'data_type' => 'text',
                'title' => trans('app.photo')
            ],
            'name' => [
                'data' => 'name',
                'data_type' => 'text',
                'title' => trans('app.name')
            ],
            'username' => [
                'data' => 'username',
                'data_type' => 'text',
                'title' => trans('app.username')
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
            'role_name' => [
                'data' => 'role_name',
                'data_type' => 'text',
                'title' => trans('app.role')
            ]
        ]+$this->btnAction;
    }
}
