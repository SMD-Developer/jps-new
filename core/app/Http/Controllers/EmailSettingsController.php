<?php namespace App\Http\Controllers;

use App\Http\Forms\EmailSettingForm;
use App\Http\Requests\EmailSettingsRequest;
use App\Invoicer\Repositories\Contracts\EmailSettingInterface;
use App\Models\EmailSetting;

class EmailSettingsController extends CrudController {
    protected string $formClass = EmailSettingForm::class;
    protected $formRequest = EmailSettingsRequest::class;
    protected string $heading =  'app.email_settings';
    protected string $icon = 'paper-plane';
    protected bool $showBtnCreate = false;
    protected bool $settingsMode = true;
    public function __construct(EmailSettingInterface $emailSettingInterface){
        parent::__construct();
        $this->repository = $emailSettingInterface;
        $this->entityClass = EmailSetting::class;
    }
    protected array $routes = [
        'index' => 'settings.email.index',
        'store' => 'settings.email.store',
        'update' => 'settings.email.update'
    ];
    public function index(): mixed
    {
        $emailSetting = $this->repository->first();
        $route = $emailSetting ? route($this->routes['update'],$emailSetting->uuid) : route($this->routes['store']);
        $method = $emailSetting ? 'PATCH' : 'POST';
        $form = $this->form($this->formClass, [
            'method' => $method,
            'url' => $route,
            'class' => 'needs-validation',
            'novalidate',
            'model'=>$emailSetting
        ]);
		return view('settings.index', compact('form'));
    }
    public function afterStore($request, &$entity): void
    {
        saveConfiguration([
            'MAIL_DRIVER'       =>$request->protocol,
            'MAILGUN_DOMAIN'    =>$request->mailgun_domain,
            'MAILGUN_SECRET'    =>$request->mailgun_secret,
            'MANDRILL_SECRET'   =>$request->mandrill_secret,
            'MAIL_FROM_ADDRESS' =>$request->from_email,
            'MAIL_FROM_NAME'    =>$request->from_name,
            'MAIL_USERNAME'     =>$request->smtp_username,
            'MAIL_PASSWORD'     =>"'$request->smtp_password'",
            'MAIL_HOST'         =>$request->smtp_host,
            'MAIL_PORT'         =>$request->smtp_port,
            'MAIL_ENCRYPTION'   =>$request->encryption
        ]);
    }
    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }
}
