<?php

namespace App\Http\Controllers;

use App\Traits\CrudEventTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
class CrudController extends Controller
{
    use CrudEventTrait, FormBuilderTrait;
    protected array $excludes = [];
    protected $resource;
    protected array $load;
    protected array $routes=[];
    protected array $modelData=[];
    protected string $heading = '';
    protected string $icon = '';
    protected bool $showBtnCreate = true;
    protected bool $settingsMode = false;
    protected string $btnCreateText = 'Create';
    protected string $createDisplayMode = 'ajax-modal';
    protected string $editDisplayMode = 'ajax-modal';
    protected string $showDisplayMode = 'ajax-modal';
    protected string $formClasses = '';
    protected string $iconCreate = '';
    protected $datatable;
    protected $repository;
    protected $entityClass;

    protected $formRequest;
    protected $loggedUser;
    protected array $jsFiles = [];
    protected array $cssFiles = [];
    protected array $jsIncludes = [];

    public function __construct(){
        View::share('heading', trans($this->heading));
        View::share('headingIcon', $this->icon);
        View::share('btnCreateText', trans($this->btnCreateText));
        View::share('createDisplayMode', $this->createDisplayMode);
        View::share('routes', $this->routes);
        View::share('iconCreate', $this->iconCreate);
        View::share('jsFiles', $this->jsFiles);
        View::share('cssFiles', $this->cssFiles);
        View::share('jsIncludes', $this->jsIncludes);
        $this->formClasses = $this->createDisplayMode === 'ajax-modal' ? 'ajax-submit' : '';
        $this->middleware(function ($request, $next) {
            $this->loggedUser  = auth('admin')->user();
            return $next($request);
        });
    }

    public function index(): mixed
    {
        $this->authorize('viewAny', $this->entityClass);
        View::share('settingsMode', $this->settingsMode);
        return App::make($this->datatable)->render('crud.index');
    }
    public function create(Request $request)
    {
        $this->authorize('create', $this->entityClass);
        $this->beforeCreate($request);
        $createForm = $this->form($this->formClass, [
            'method' => 'POST',
            'url' => route($this->routes['store']),
            'id' => $this->form_name ?? 'create_form',
            'class' => 'needs-validation row '.$this->formClasses,
            'model'=>$this->modelData,
            'novalidate'
        ]);
        $view = $this->createDisplayMode === 'ajax-modal' ? view('crud.modal') : view('crud.form');
        $view->with('form',$createForm);
        $view->with('heading',trans($this->heading));
        return $view;
    }
    public function store(Request $request)
    {
        $this->authorize('create', $this->entityClass);
        $formRequest = App::make($this->formRequest ?? Request::class);
        $data = $formRequest->except($this->excludes);
        $this->beforeStore($request,$data);
        $entity = $this->repository->create($data);
        if($entity){
            $this->afterStore($request,$entity);
            flash(trans('app.record_created'))->success();
            if($request->ajaxNonReload){
                return response()->json(['msg' => trans('app.record_created'), 'record' => $entity]);
            }
            if($request->ajax()){
                return response()->json(['success' => true, 'msg' => trans('app.record_created')]);
            }
            return redirect(route($this->routes['index']));
        }
        if($request->ajax()){
            return response()->json(['success' => false, 'msg' => trans('app.record_creation_failed')], 422);
        }
        flash('app.record_creation_failed')->error();
        return redirect(route($this->routes['index']));
    }
    public function edit($uuid){
        $entity = $this->repository->getById($uuid);
        $this->authorize('update', $entity);
        if($entity){
            $this->beforeEdit($entity);
            $updateForm = $this->form($this->formClass, [
                'method' => 'PATCH',
                'url' => route($this->routes['update'], $entity),
                'id' => 'edit_form',
                'class' => 'needs-validation row '.$this->formClasses,
                'novalidate',
                'model' => $entity
            ]);
            $view = $this->editDisplayMode === 'ajax-modal' ? view('crud.modal') : view('crud.form');
            $view->with(['form'=>$updateForm, 'heading'=>trans($this->heading)]);
            return $view;
        }
        flash(trans('app.record_not_found'))->error();
        return redirect(route($this->routes['index']));
    }

    public function update(Request $request, string $id)
    {
        $formRequest = App::make($this->formRequest ?? Request::class);
        $entity = $this->repository->getById($id);
        if ($entity) {
            $this->authorize('update', $entity);
            $data = $formRequest->except($this->excludes);
            $this->beforeUpdate($request,$entity, $data);
            $updated = $this->repository->updateById($id,$data);
            if($updated){
                flash(trans('app.record_updated'))->success();
                $this->afterUpdate($request,$entity);
                if($request->ajaxNonReload){
                    return response()->json(['msg' => trans('app.record_updated'), 'record' => $entity]);
                }
                if($request->ajax()){
                    return response()->json(['success' => true, 'msg' => trans('app.record_updated')]);
                }
                return redirect(route($this->routes['index']));
            }
        }
        flash(trans('app.record_not_found'))->error();
        return redirect(route($this->routes['index']));
    }
    public function show($id){
        $entity = $this->repository->getById($id);
        if($entity){
            $ajax_form = request('mode') ? 'ajax-submit' : '';
            $this->beforeShow($entity);
            $updateForm = $this->form($this->formClass, [
                'method' => 'PATCH',
                'url' => route($this->routes['update'], $entity),
                'class' => 'needs-validation row '.$ajax_form,
                'novalidate',
                'model' => $entity
            ]);
            $updateForm->disableFields();
            $updateForm->remove('buttons');
            $view = $this->showDisplayMode === 'ajax-modal' ? view('crud.show_modal') : view('crud.show');
            $view->with([
                'form' => $updateForm,
                'heading'=>trans($this->heading)
            ]);
            return $view;
        }
        flash(trans('app.record_not_found'))->error();
        return redirect(route($this->routes['index']));
    }
    public function destroy($id){
        $entity = $this->repository->getById($id);
        if($entity){
            $this->authorize('delete', $entity);
            $this->beforeDestroy($entity);
            $this->repository->deleteById($entity->uuid);
            $this->afterDestroy($entity);
            flash(trans('app.record_updated'))->success();
            if (request()->ajax()) {
                return response()->json(['success' => true,'action'=>'refresh_datatable', 'msg' => trans('app.record_deleted')]);
            }
            return redirect(route($this->routes['index']));
        }
        flash(trans('app.record_not_found'))->error();
        return redirect(route($this->routes['index']));
    }
    public function authorize($ability, $arguments = []): void
    {
        Gate::forUser($this->loggedUser)->authorize($ability, $arguments);
    }
}
