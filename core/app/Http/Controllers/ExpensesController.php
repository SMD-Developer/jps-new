<?php namespace App\Http\Controllers;

use App\Datatables\ExpenseDatatable;
use App\Http\Forms\ExpenseForm;
use App\Http\Requests\ExpenseFormRequest;
use App\Invoicer\Repositories\Contracts\ExpenseInterface;
use App\Models\Expense;
use Illuminate\Support\Facades\View;

class ExpensesController extends CrudController {
    protected $entityClass;
    protected $datatable = ExpenseDatatable::class;
    protected string $formClass = ExpenseForm::class;
    protected $formRequest = ExpenseFormRequest::class;
    protected string $heading =  'app.expenses';
    protected string $icon = 'credit-card';
    protected string $btnCreateText = 'app.add_expense';
    protected string $iconCreate = 'credit-card';
    protected array $routes = [
        'index'     => 'expenses.index',
        'create'    => 'expenses.create',
        'show'      => 'expenses.show',
        'edit'      => 'expenses.edit',
        'store'     => 'expenses.store',
        'destroy'   => 'expenses.destroy',
        'update'    => 'expenses.update'
    ];
    public function __construct(Expense $model, ExpenseInterface $expenseInterface){
        parent::__construct();
        $this->repository = $expenseInterface;
        $this->entityClass = $model;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('expense.create'));
            return $next($request);
        });
    }
    public function beforeCreate($request): void
    {
        $this->heading = 'app.new_expense';
    }
    public function boforeEdit(&$entity): void
    {
        $this->heading = 'app.edit_expense';
    }
}
