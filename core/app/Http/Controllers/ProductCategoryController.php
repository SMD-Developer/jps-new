<?php
namespace App\Http\Controllers;

use App\Datatables\ProductCategoryDatatable;
use App\Http\Forms\ProductCategoryForm;
use App\Http\Requests\ProductCategoryRequest;
use App\Invoicer\Repositories\Contracts\ProductCategoryInterface;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;

class ProductCategoryController extends CrudController
{
    protected $datatable = ProductCategoryDatatable::class;
    protected string $formClass = ProductCategoryForm::class;
    protected $formRequest = ProductCategoryRequest::class;
    protected string $heading =  'app.categories';
    protected string $icon = 'th-large';
    protected string $btnCreateText = 'app.new_category';
    protected string $iconCreate = 'th-large';
    protected array $routes = [
        'index'     => 'products.category.index',
        'create'    => 'products.category.create',
        'show'      => 'products.category.show',
        'edit'      => 'products.category.edit',
        'store'     => 'products.category.store',
        'destroy'   => 'products.category.destroy',
        'update'    => 'products.category.update'
    ];
    public function __construct(ProductCategoryInterface $categoryInterface){
        parent::__construct();
        $this->repository = $categoryInterface;
        $this->entityClass = ProductCategory::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('product-category.create'));
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
