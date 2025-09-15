<?php
namespace App\Datatables;
use App\Datatables\CoreDatatable;
use App\Models\Locale;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;

class LanguageDatatable extends CoreDatatable
{
    protected $editRoute = 'settings.translation.edit';
    protected string $deleteRoute = 'settings.translation.destroy';
    protected string $translationRoute = 'language_translations';
    public function __construct() 
    {
        parent::__construct();
        $this->show_permission = hasPermission('locale.view');
        $this->edit_permission = hasPermission('locale.edit');
        $this->delete_permission = hasPermission('locale.delete');
    }
    public function dataTable($query){
        $dataTable = new EloquentDataTable($query);
        $this->action_links($dataTable, self::SHOW_URL_ROUTE);   
        $dataTable->editColumn('flag', function($row){
            return \Html::image(image_url($row->flag != '' ? $row->flag : 'flags/placeholder_Flag.jpg'), 'flag', ['class' => 'thumbnail', 'style'=>'margin-bottom:0']);
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
    public function query(Locale $model)
    {
        return $model->newQuery()->select();
    }
    protected function getColumns(){
        return [
            'flag' => [
                'data' => 'flag',
                'data_type' => 'text',
                'title' => trans('app.flag')
            ],
            'locale_name' => [
                'data' => 'locale_name',
                'data_type' => 'text',
                'title' => trans('app.locale_name')
            ],
            'short_name' => [
                'data' => 'short_name',
                'data_type' => 'text',
                'title' => trans('app.short_name')
            ],
            'default' => [
                'data' => 'default',
                'data_type' => 'boolean',
                'title' => trans('app.default')
            ],
            'status' => [
                'data' => 'status',
                'data_type' => 'boolean',
                'title' => trans('app.status')
            ]
        ]+$this->btnAction;
    }
}
