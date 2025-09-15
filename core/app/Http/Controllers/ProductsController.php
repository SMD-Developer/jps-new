<?php namespace App\Http\Controllers;

use App\Datatables\ProductDatatable;
use App\Http\Forms\ProductForm;
use App\Http\Requests\ProductFormRequest;
use App\Invoicer\Repositories\Contracts\ProductInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;

class ProductsController extends CrudController {
    protected $datatable = ProductDatatable::class;
    protected string $formClass = ProductForm::class;
    protected $formRequest = ProductFormRequest::class;
    //protected string $heading =  'app.products';
    protected string $icon = 'puzzle-piece';
    protected string $btnCreateText = 'app.add_product';
    protected string $iconCreate = 'puzzle-piece';
    protected array $routes = [
        'index'     => 'products.index',
        'create'    => 'products.create',
        'show'      => 'products.show',
        'edit'      => 'products.edit',
        'store'     => 'products.store',
        'destroy'   => 'products.destroy',
        'update'    => 'products.update'
    ];
    public function __construct(Product $model, ProductInterface $productInterface){
        parent::__construct();
        $this->entityClass = $model;
        $this->repository = $productInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('product.create'));
            return $next($request);
        });
    }
    public function afterStore($request, &$entity): void
    {
        if ($request->hasFile('product_image')){
            $file = $request->file('product_image');
            $path = config('app.images_path').'uploads/product_images/';
            $filename = uploadFile($file,$path, true, 245);
            $entity->image = $filename;
            $entity->save();
        }
    }
    public function beforeCreate($request): void
    {
        $this->heading = 'app.add_product';
    }

    public function beforeEdit(&$entity): void
    {
        $this->heading = 'app.edit_product';
    }
    public function beforeShow(&$entity): void
    {
        $this->heading = 'app.view_product';
    }

    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }
    /**
     * @return \Illuminate\View\View
     */
    public function products_modal(): \Illuminate\View\View
    {
        $products = $this->repository->all();
        return view('products.products_modal', compact('products'));
    }

    /**
     * @return JsonResponse
     */
    public function process_products_selections(): JsonResponse
    {
        $selected = request('product_lookup_id');
        $product = $this->repository->getById($selected);
        $product->quantity = 1;
        return response()->json(['success'=>true, 'product' => $product], 200);
    }
}
