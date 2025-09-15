<?php

namespace App\Http\Controllers;

use App\Datatables\PermissionDatatable;
use App\Http\Forms\PermissionForm;
use App\Http\Requests\PermissionFormRequest;
use App\Invoicer\Repositories\Contracts\PermissionInterface;
use App\Models\Permission;
use Illuminate\Support\Facades\View;

class PermissionsController extends CrudController
{
    protected $datatable = PermissionDatatable::class;
    protected string $formClass = PermissionForm::class;
    protected $formRequest = PermissionFormRequest::class;
    protected string $heading =  'app.permissions';
    protected bool $settingsMode = true;
    protected string $icon = 'cog';
    protected array $routes = [
        'index' => 'settings.permission.index',
        'create' => 'settings.permission.create',
        'store' => 'settings.permission.store',
        'update' => 'settings.permission.update'
    ];
    public function __construct(PermissionInterface $paymentInterface){
        parent::__construct();
        $this->repository = $paymentInterface;
        $this->entityClass = Permission::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', false);
            return $next($request);
        });
    }
}
