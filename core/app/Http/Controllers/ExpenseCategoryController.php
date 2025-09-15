<?php

namespace App\Http\Controllers;

use App\Datatables\ExpenseCategoryDatatable;
use App\Http\Forms\ExpenseCategoryForm;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Invoicer\Repositories\Contracts\ExpenseCategoryInterface;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\View;

class ExpenseCategoryController extends CrudController
{
    protected $datatable = ExpenseCategoryDatatable::class;
    protected string $formClass = ExpenseCategoryForm::class;
    protected $formRequest = ExpenseCategoryRequest::class;
    protected string $heading =  'app.expense_categories';
    protected string $icon = 'credit-card';
    protected string $btnCreateText = 'app.new_category';
    protected string $iconCreate = 'credit-card';
    protected string $showDisplayMode = 'normal';
    protected $entityClass;
    protected array $routes = [
        'index'     => 'expenses.category.index',
        'create'    => 'expenses.category.create',
        'show'      => 'expenses.category.show',
        'edit'      => 'expenses.category.edit',
        'store'     => 'expenses.category.store',
        'destroy'   => 'expenses.category.destroy',
        'update'    => 'expenses.category.update'
    ];
    public function __construct(ExpenseCategoryInterface $expenseCategoryInterface){
        parent::__construct();
        $this->repository = $expenseCategoryInterface;
        $this->entityClass = ExpenseCategory::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('expense-category.create'));
            return $next($request);
        });
    }
    public function beforeCreate($request): void
    {
        $this->heading = 'app.new_category';
    }
    public function boforeEdit(&$entity): void
    {
        $this->heading = 'app.edit_category';
    }
}
