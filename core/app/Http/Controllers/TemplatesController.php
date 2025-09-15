<?php namespace App\Http\Controllers;

use App\Http\Forms\TemplateForm;
use App\Http\Requests\TemplateFormRequest;
use App\Invoicer\Repositories\Contracts\TemplateInterface;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TemplatesController extends CrudController {
    protected string $formClass = TemplateForm::class;
    protected $formRequest = TemplateFormRequest::class;
    protected string $heading =  'app.email_templates';
    protected string $icon = 'envelope';
    protected array $routes = [
        'index' => 'settings.template.index',
        'store' => 'settings.template.store',
        'update' => 'settings.template.update'
    ];
    public function __construct(TemplateInterface $productInterface){
        parent::__construct();
        $this->entityClass = Template::class;
        $this->repository = $productInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', false);
            return $next($request);
        });
    }
    public function show($id)
    {
        $template = $this->repository->getTemplate($id);
        $route = $template ? route($this->routes['update'],$template->uuid) : route($this->routes['store']);
        $method = $template ? 'PATCH' : 'POST';
        if(!$template){
            $template = new \stdClass();
            $template->name = $id;
        }
        $form = $this->form($this->formClass, [
            'method' => $method,
            'url' => $route,
            'class' => 'needs-validation',
            'novalidate',
            'model'=>$template
        ]);
		return view('settings.index', compact('form'));
    }
    public function update(Request $request, string $id)
    {
         $data = [
            'subject' => $request->subject,
            'body' => $request->body,
        ];
        if($this->repository->updateById($id, $data)) {
            flash()->success(trans('app.record_updated'));
        }
        else {
            flash()->error(trans('app.update_failed'));
        }
        return redirect('settings/templates/'.$request->name);
    }
}
