<?php namespace App\Http\Controllers;

use App\Datatables\LanguageDatatable;
use App\Http\Forms\LanguageForm;
use App\Http\Requests\TranslationFormRequest;
use App\Invoicer\Repositories\Contracts\TranslationInterface;
use App\Models\Locale;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class TranslationsController extends CrudController {
    protected $datatable = LanguageDatatable::class;
    protected string $formClass = LanguageForm::class;
    protected $formRequest = TranslationFormRequest::class;
    protected string $heading =  'app.translations';
    protected string $icon = 'globe';
    protected string $btnCreateText = 'app.add_locale';
    protected string $iconCreate = 'plus';
    protected bool $settingsMode = true;
    protected array $routes = [
        'index' => 'settings.translation.index',
        'create' => 'settings.translation.create',
        'store' => 'settings.translation.store',
        'update' => 'settings.translation.update'
    ];
    public function __construct(TranslationInterface $translationInterface){
        parent::__construct();
        $this->entityClass = Locale::class;
        $this->repository = $translationInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('locale.create'));
            return $next($request);
        });
    }
    public function beforeStore($request, &$input): void
    {

        if($request->default){
            $this->repository->resetDefault();
        }
    }
    public function beforeUpdate($request, &$entity, &$input): void
    {
        $this->beforeStore($request,$input);
        if($entity->short_name === 'en'){
            unset($input['short_name']);
        }
    }

    public function afterStore($request, &$entity): void
    {
        if ($request->hasFile('image')){
            $oldFlag = $entity->flag;
            $file = $request->file('image');
            $path = config('app.images_path').'flags/';
            $filename = uploadFile($file,$path, true, 20);
            $entity->flag = $filename;
            $entity->save();
            if($entity->save() && !is_null($oldFlag) && File::exists($oldFlag)){
               File::delete($oldFlag);
            }
        }
        if($entity->short_name !== $request->short_name && $entity->short_name !== 'en') {
            $this->repository->updateLocaleKey($entity->short_name, $request->short_name);
        }
        if($entity->short_name !== 'en') {
            $old_path = base_path() . '/resources/lang/' . $entity->short_name;
            $new_path = base_path() . '/resources/lang/' . $request->short_name;
            if (File::exists($old_path)) {
                File::move($old_path, $new_path);
            }
        }
    }
    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }
    public function beforeDestroy(&$entity)
    {
        if($entity->short_name === 'en'){
            return response()->json(['success' => false, 'msg' => trans('app.record_deletion_failed')], 422);
            exit;
        }
    }

    public function afterDestroy(&$entity): void
    {
        if(File::exists($entity->flag)){
            File::delete($entity->flag);
        }
    }
}
