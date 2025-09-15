<?php

namespace App\Datatables;

use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
class CoreDatatable extends DataTable
{
    protected $editRoute;
    protected string $editDisplayMode = 'modal';
    protected string $showDisplayMode = 'modal';
    protected bool $edit_permission = false;
    protected bool $delete_permission = false;
    protected bool $show_permission = false;
    protected bool $download_permission = false;
    protected bool $assign_permission = false;
    protected bool $add_payment_permission = false;
    public const SHOW_URL_ROUTE = '';
    protected array $btnDelete = [
        'delete' => [
            'data' => 'delete',
            'title' => '',
            'data_type' => 'delete',
            'orderable' => false,
            'searchable' => false,
        ]
    ];
    protected array $btnEdit = [
        'btn_edit' => [
            'data' => 'btn_edit',
            'title' => '',
            'data_type' => 'edit',
            'orderable' => false,
            'searchable' => false,

        ]
    ];
    protected array $btnAction = [
        'btn_action' => [
            'data' => 'btn_action',
            'title' => 'Action',
            'data_type' => 'action',
            'orderable' => false,
            'searchable' => false,

        ]
    ];
    public function action_links(EloquentDataTable $table, $route, $prefix = null)
    {
        $rawColumns = [];
        $table->addRowAttr('record-id', function ($record) {
            return $record->id;
        });
        $table->addRowAttr('record-type', function ($record) {
            return get_class($record);
        });
        foreach ($this->getColumns() as $column => $properties) {
            $rawColumns[] = $column;
            $table->editColumn($column, function ($record) use ($column, $properties, $route, $prefix) {
                if ($properties['data_type'] === 'delete') {
                    $view = view('crud.datatable_links.delete');
                    $view->with('entityId', $record->uuid);
                    $view->with('delete_route', $this->deleteRoute);
                    $view->with('delete_permission', $this->delete_permission);
                    return $view;
                }
                if ($properties['data_type'] === 'edit') {
                    $view = view('crud.datatable_links.edit');
                    $view->with('entityId', $record->uuid);
                    $view->with('edit_route', $this->editRoute);
                    $view->with('edit_display_mode', $this->editDisplayMode);
                    $view->with('edit_permission', $this->edit_permission);
                    return $view;
                }
                if ($properties['data_type'] === 'action') {
                    $view = view('crud.datatable_links.action');
                    $view->with('entityId', $record->uuid);
                    $view->with('edit_route', $this->editRoute);
                    $view->with('edit_display_mode', $this->editDisplayMode);
                    $view->with('show_display_mode', $this->showDisplayMode);
                    $view->with('delete_route', $this->deleteRoute);
                    $view->with('download_route', $this->downloadRoute);
                    $view->with('permissionRoute', $this->permissionRoute);
                    $view->with('show_route', $this->show_route);
                    $view->with('email_route', $this->email_route);
                    $view->with('submit_draft_route', $this->submitDraftRoute);
                    $view->with('show_permission', $this->show_permission);
                    $view->with('edit_permission', $this->edit_permission);
                    $view->with('delete_permission', $this->delete_permission);
                    $view->with('download_permission', $this->download_permission);
                    $view->with('add_payment_permission', $this->add_payment_permission);
                    $view->with('assign_permission', $this->assign_permission);
                    $view->with('translation_route', $this->translationRoute);
                    $view->with('payment_route', $this->paymentRoute);
                    $view->with('record', $record);
                    return $view;
                }
                return $this->drawLink($column, $record, $properties, $route);
            });
        }
        $table->rawColumns($rawColumns);
    }
    public static function drawLink($column, $record, $columnProperties, $route)
    {
        $displayColumn = $record->$column;
        if ($route != '') {
            $href = route($route, $record->uuid);
        } else {
            $href = '';
        }
        $datatype = 'text';
        if (isset($columnProperties['data_type'])) {
            $datatype = $columnProperties['data_type'];
        }
        if ($datatype === 'boolean') {
            return $displayColumn  ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
        }
        if ($datatype === 'image') {
            if (!empty($displayColumn)) {
                $displayColumn = "<img class='datatable_image' src='" . asset($displayColumn) . "' />";
                if (!empty($href)) {
                    return '<a data-column="' . strip_tags($column) . '" title="' . strip_tags($displayColumn) . '" href="' . $href . '"> ' . ($displayColumn) . '</a>';
                }
                return $displayColumn;
            }
        }
        if ($datatype === 'none') {
            return $displayColumn;
        }
        if ($datatype === 'email') {
            $href = 'mailto:' . $record->$column;
        }
        if (is_array($displayColumn)) {
            $displayColumn = implode(",", $displayColumn);
        }
        $oldDisplayColumn = $displayColumn;
        $title = $displayColumn;
        if (strlen($oldDisplayColumn) >= 30 && $datatype === 'text') {
            $displayColumn = mb_substr($displayColumn, 0, 50, 'utf-8') . '...';
        }
        if (!empty($href)) {
            $link = '<a data-column="' . strip_tags($column) . '" title="' . strip_tags($title) . '" href="' . $href . '"> ' . strip_tags($displayColumn) . '</a>';
        } else {
            $link = strip_tags($displayColumn);
        }
        return $link;
    }
}
