<?php
//Auth::routes();
#Installation script Routes
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reviewer\ReviewerController;
use App\Http\Controllers\ApplicationApprover\ApplicationApproverController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\AdminStaff\AdminStaffController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ClientArea\Auth\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ClientArea\UpdateProfileController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportReviewController;

Route::group(array('prefix'=>'install','middleware'=>'install'),function() {
    Route::get('/','InstallController@index');
    Route::get('/database','InstallController@getDatabase');
    Route::post('/database','InstallController@postDatabase');
    Route::get('/user','InstallController@getUser');
    Route::post('/user','InstallController@postUser');
});


   
 
  Route::get('pay-status', 'ClientArea\PayController@status')->name('pay.status');
  Route::match(['get', 'post'],'direct-fpx', 'ClientArea\PayController@direct')->name('direct.fpx');
  Route::get('pay-bank-details', 'ClientArea\PayController@bankDetails')->name('pay.bank.details');
  Route::post('indirect-fpx', 'ClientArea\PayController@indirect')->name('indirect.fpx');
  Route::get('divisions/{dist_id}', 'ClientArea\HomeController@getDivisions')->name('divisions');
  Route::post('search-applications', 'ClientArea\HomeController@searchApplications')->name('applications.search');
  Route::get('search-appplication-results', 'ClientArea\HomeController@searchResult')->name('search.results');
   
 




Route::group(['middleware' => 'install'], function(){
    Route::group(['prefix'=>'clientarea'],function(){
        Route::get('login', 'ClientArea\Auth\AuthController@getLogin')->name('client_login');
        // Route::post('login', 'ClientArea\Auth\AuthController@postLogin');
        Route::post('login', 'ClientArea\Auth\AuthController@postLogin') ->middleware('check.account.lock');
        Route::get('logout', 'ClientArea\Auth\AuthController@getLogout')->name('client_logout');

        Route::any('register','ClientArea\Auth\AuthController@register')->name('client_register');
        Route::get('register-districts/{state_id}', 'ClientArea\HomeController@getDistricts')->name('register_districtes');

        Route::get('user-notification','ClientArea\HomeController@userNotification')->name('user_notification');
        Route::post('user-notifications/{id}/mark-as-read','ClientArea\HomeController@markAsReads')->name('user.notifications.mark_as_read');
        Route::post('user-notifications/mark-all-as-read','ClientArea\HomeController@markAllAsRead' )->name('user.notifications.mark_all_as_read');
        Route::get('get-notification-count', 'ClientArea\HomeController@getCount')->name('user.get.notification.count');
        Route::get('get-notifications', 'ClientArea\HomeController@getNotifications')->name('user.get.notifications');
        Route::get('get-user-details/{id}', 'ClientArea\HomeController@userApplicationDetails')->name('user.userDetails');
        Route::post('update-print-status/{id}', 'ClientArea\HomeController@updatePrintStatus')->name('update.print.status');
        Route::get('show-approval-letter/{application_id}', 'ClientArea\HomeController@showApprovalLetter')->name('show_approval_letter');
        Route::get('register/verify-otp', 'ClientArea\Auth\AuthController@showOtpVerification')->name('otp.verification');
        Route::post('register/verify-otp', 'ClientArea\Auth\AuthController@verifyOtp')->name('otp.verify');
        Route::post('register/resend-otp', 'ClientArea\Auth\AuthController@resendOtp')->name('otp.resend');
        




        // Password Reset Routes...
        Route::get('password/reset', 'ClientArea\Auth\ForgotPasswordController@showLinkRequestForm')->name('client.password.request');
        Route::post('client/password/email', 'ClientArea\Auth\ForgotPasswordController@sendResetLinkEmail')->name('client.password.email');
        Route::get('password/reset/{token}', 'ClientArea\Auth\ResetPasswordController@showResetForm')->name('client.password.reset');
        Route::post('password/reset', 'ClientArea\Auth\ResetPasswordController@reset')->name('client.password.update');
        Route::get('password/new-password', 'ClientArea\Auth\ForgotPasswordController@newPassword')->name('newpassword');
        Route::group(['middleware' => 'client'], function() {
            Route::get('/', 'ClientArea\HomeController@index')->name('clients.home');
            Route::get('home', 'ClientArea\HomeController@index')->name('client_dashboard');
            Route::post('new-application-submit', 'ClientArea\HomeController@applicationSubmit')->name('client_application_submit');
            Route::post('claim-contribution-submit', 'ClientArea\HomeController@claimSubmit')->name('client_claim_submit');
            Route::get('districts/{state_id}', 'ClientArea\HomeController@getDistricts')->name('districts');
            Route::get('division/{dist_id}', 'ClientArea\HomeController@getDivision')->name('division');
            Route::get('new-application', 'ClientArea\HomeController@application')->name('client_application');
            
            Route::get('resubmit-application/{id}', 'ClientArea\HomeController@resubmitApplication')->name('resubmit-application');
            Route::match(['put', 'post'],'application/{id}', 'ClientArea\HomeController@updateResubmitApplication')
           ->name('updateResubmitApplication');
            Route::post('notify-admin-new-application', 'ClientArea\HomeController@notifyAdminNewApplication' )->name('notify-admin-new-application');
            Route::get('application-status', 'ClientArea\HomeController@applicationStatus')->name('client_application_status');
            Route::get('user-payment-letter/{application_id}', 'ClientArea\HomeController@user_payment_letter')->name('user_payment_letter');
            Route::get('agency-payment-letter', 'ClientArea\HomeController@government_letter')->name('agency.payment.letter');
            Route::get('user-receipt-original/{application_id}','ClientArea\HomeController@userReceipt')->name('original_receipts');
            Route::get('user-receipt-copy/{id}', 'ClientArea\HomeController@userReceiptCopy')->name('user_copy_receipt');
            Route::get('contribution-history','ClientArea\HomeController@contribution_history')->name('contribution_history');
            Route::get('contribution-claim','ClientArea\HomeController@contributionClaim')->name('contribution_claim');
            Route::get('claim-contribution-list','ClientArea\HomeController@userClaimList')->name('claim.contribution.list');
            Route::get('faq','ClientArea\HomeController@faq')->name('faq');
            Route::get('contact-support','ClientArea\HomeController@contactSupport')->name('contact_support');
            Route::get('update-profile','ClientArea\HomeController@updateprofile')->name('update.profile');
            Route::get('new-payment','ClientArea\HomeController@newpayment')->name('new_payment');
            Route::get('payment-records','ClientArea\HomeController@paymentrecords')->name('payment_records');
            Route::get('helpdesk','ClientArea\HomeController@helpdesk')->name('helpdesk');
            Route::get('user-manual','ClientArea\HomeController@usermanual')->name('user_manual');
            Route::get('upload-deposit-receipt/{application_id}', 'ClientArea\HomeController@uploadDepositReceipt')
                 ->name('uploadDepositReceipt');
            Route::post('applications/submit-deposit',  'ClientArea\HomeController@submitDeposit')->name('applications.submitDeposit');
            
            
            
            
            
            Route::get('pay-details-b2c', 'ClientArea\PayController@b2c')->name('pay.details.b2c');
            Route::get('pay-details-b2b', 'ClientArea\PayController@b2b')->name('pay.details.b2b');
            Route::get('payment-selection/{application}', 'ClientArea\PayController@paymentSelection')->name('payment.selection');
            Route::post('process-payment-selection', 'ClientArea\PayController@processPaymentSelection')->name('process.payment.selection');
            Route::post('fpx/callback', 'ClientArea\PayController@handleFpxCallback')->name('fpx.callback');
            Route::get('fpx/return', 'ClientArea\PayController@handleFpxReturn')->name('fpx.return');
            
           
           
            Route::get('success',  'ClientArea\HomeController@success')->name('success');


           

            
            
            // Route::get('edit_profile/{id}/edit', 'ClientArea\UpdateProfileController@edit_profile')->name('edit_profile');

            // // Update Profile Route
            // Route::put('edit_profile/{id}/edit', 'ClientArea\UpdateProfileController@update_profile')->name('update_profile');

            Route::get('edit-profile/{id}/edit', 'ClientArea\UpdateProfileController@edit_profile')->name('edit_profile');
            // Update Profile Route
            Route::put('edit-profile/{id}/edit', 'ClientArea\UpdateProfileController@update_profile')->name('update_profile');
                    // Settings page
            Route::get('settings/{id}', 'ClientArea\UpdateProfileController@Settings')->name('settings');
                    // Password change handler
            Route::post('settings/change-password/{uuid}', 'ClientArea\UpdateProfileController@changePassword')->name('settings.change-password');

            Route::resource('cinvoices', 'ClientArea\InvoicesController', array('only' => array('index', 'show')));
            Route::resource('cestimates', 'ClientArea\EstimatesController', array('only' => array('index', 'show')));
            Route::resource('cpayments', 'ClientArea\PaymentsController', ['only' => ['index', 'show']]);
            Route::post('getCheckout', ['as'=>'getCheckout','uses'=>'ClientArea\CheckoutController@getCheckout']);
            Route::get('getDone', ['as'=>'getDone','uses'=>'ClientArea\CheckoutController@getDone']);
            Route::get('getCancel/{id}', ['as'=>'getCancel','uses'=>'ClientArea\CheckoutController@getCancel']);
            Route::post('paypal_notify', ['as'=>'paypal_notify','uses'=>'ClientArea\CheckoutController@paypalNotify']);
            Route::get('stripecheckout/{id}', ['as'=>'stripecheckout','uses'=>'ClientArea\CheckoutController@stripeCheckout']);
            Route::post('stripecheckout', ['as'=>'stripesuccess','uses'=>'ClientArea\CheckoutController@stripeSuccess']);
            Route::get('payment_methods/{invoice_id}', ['uses' => 'ClientArea\PaymentMethodsController@index'])->name('client.invoice.pay');
            Route::get('cprofile', ['uses' => 'ClientArea\ProfileController@edit'])->name('client.getprofile');
            Route::post('cprofile', ['uses' => 'ClientArea\ProfileController@update'])->name('client.postprofile');
            Route::get('estimatepdf/{id}', 'ClientArea\EstimatesController@estimatePdf')->name('cestimate_pdf');
            Route::get('invoicepdf/{id}', 'ClientArea\InvoicesController@invoicePdf')->name('cinvoice_pdf');
            Route::get('lang/{lang}', ['as'=>'client_lang_switch', 'uses'=>'LanguageController@switchLang']);
            # reports resource
            Route::group(array('prefix'=>'reports'),function(){
                Route::get('/', 'ClientArea\ReportsController@index');
                Route::post('general', 'ClientArea\ReportsController@general_summary');
                Route::post('payment_summary', 'ClientArea\ReportsController@payment_summary');
                Route::post('client_statement', 'ClientArea\ReportsController@client_statement');
                Route::post('invoices_report', 'ClientArea\ReportsController@invoices_report');
            });
        });
    });
    Route::get('login', 'Auth\AuthController@showLoginForm')->name('admin_login');
    Route::post('login', 'Auth\AuthController@postLogin')->middleware('check.admin.account.lock');
    Route::get('logout', 'Auth\AuthController@getLogout')->name('admin_logout');
    
    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');
    Route::get('password/new-password', 'Auth\ForgotPasswordController@newPassword')->name('new_password');
    // Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('client.password.update');
    Route::get('recurring', 'RecurringInvoicesController@index');
    Route::group(['middleware' => 'auth'], function(){
        #home controller
        Route::get('/',   'HomeController@index')->name('home');
        Route::get('home','HomeController@index');
        #Resources Routes
        Route::resources([
            'users'     => 'UsersController',
            'clients'   => 'ClientsController',
            'invoices'  => 'InvoicesController',
            'estimates' => 'EstimatesController',
            'payments'  => 'PaymentsController'
        ]);
        // Route::get('department','RolesController@department')->name('department');
        Route::get('/department', [DepartmentController::class, 'index'])->name('department');
        Route::post('/department/store', [DepartmentController::class, 'store'])->name('departments.store');
        Route::put('/department/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::get('staff','UsersController@staff')->name('staff');
        // Route::post('staff-add', [CrudController::class, 'storeStaff'])->name('crud.storeStaff');
        Route::match(['PUT', 'POST'], '/staff/update/{uuid}', 'RolesController@updateStaff')->name('staff.update');
        Route::get('/role', [RolesController::class, 'addRole'])->name('role');
        Route::get('/roles/{id}/permissions', [RolesController::class, 'getRolePermissions'])->name('roles.permissions');
        Route::post('/staff-add', 'RolesController@storeStaff')->name('storeStaff');
        Route::post('/role/store', [RolesController::class, 'storeRole'])->name('roles.store');
        // Route::match(['PUT', 'POST'], '/role/update', [RolesController::class, 'updateStoreRole'])->name('roles.update');
         Route::match(['PUT', 'POST'], '/role/update', [RolesController::class, 'updateStoreRole'])->name('roles.update');
         Route::post('update-permission-group-status', 'RolesController@updateGroupStatus')
        ->name('update.permission.group.status');
        Route::get('application-list','HomeController@applicationList')->name('application_list');
        Route::get('change-password/{uuid}', 'HomeController@changePassword')->name('admin.change-password');
        Route::post('update-password/{uuid}', 'HomeController@updatePassword')->name('admin.update-password');
        Route::post('toggle-user-block-status/{id}', 'HomeController@toggleBlockStatus')->name('toggle_user_block_status');
        Route::post('admin/unblock/{admin_id}', 'HomeController@toggleAdminBlockStatus')->name('admin.unblock');
        Route::get('approver-application-list','HomeController@approverapplicationList')->name('approver-application_list');
        Route::post('track-approver-application-view', 'HomeController@trackApplicationView');
        Route::get('districts/{state_id}', 'HomeController@getDistricts')->name('districts');
        Route::get('/application/search', 'HomeController@search' )->name('application.search');
        Route::get('search-applications', [HomeController::class, 'searchApplications'])->name('search.applications');
        Route::get('division/{dist_id}', 'HomeController@getDivision')->name('divisions');
        Route::post('check-reference-duplicate', 'HomeController@checkReferenceDuplicate')
        ->name('check.reference.duplicate');
        Route::post('update-claim-status/{id}', 'HomeController@updateStatus')
        ->name('updateClaimStatus');
        
        Route::get('mangage-state', 'HomeController@manageState')->name('manage.state');
        Route::post('states/add', 'HomeController@addState')->name('addState');
        Route::post('states/{id}', 'HomeController@editState')->name('editState');
        
        
        Route::match(['put', 'post'],'admin/payment/update/{application_id}', 'HomeController@paymentUpdate')
        ->name('admin.payment.update');
        
        
        Route::get('manage-districts', 'HomeController@manageDistrict')->name('manageDistrict');
        Route::post('add-districts', 'HomeController@addDistrict')->name('addDistrict');
        Route::post('districts/{id}', 'HomeController@editDistrict')->name('editDistrict');
        
        Route::get('activity-logs', 'ActivityLogController@getLogs')->name('getActivityLog');
        Route::get('activity-logs-check', 'ActivityLogController@index')->name('activity-logs.index');
        Route::get('activity-logs/record/{subjectType}/{subjectId}', 'ActivityLogController@getLogsByRecord');
        Route::get('activity-logs/stats', 'ActivityLogController@getLogStats');
        Route::get('activity-logs/{id}', 'ActivityLogController@getLogDetails');
        Route::delete('activity-logs/cleanup', 'ActivityLogController@cleanupLogs');
        
        
        Route::get('manage-division', 'HomeController@manageDivision')->name('manageDivision');
        Route::post('division/add', 'HomeController@addDivision')->name('addDivision');
        Route::post('divisions/{id}', 'HomeController@updateDivision')->name('divisions.update');
        
        
        Route::get('land-categories', 'HomeController@manageLandCategory')->name('landCategories');
        Route::post('land-categories', 'HomeController@store')->name('addLandCategory');
        Route::post('land-categories/{id}', 'HomeController@update')->name('updateLandCategory');;
        Route::delete('land-categories/{id}', 'HomeController@update')->name('deleteLandCategory');
        Route::get('claim-list','HomeController@claimList')->name('claim.list');
        Route::post('track-claim-view', 'HomeController@trackClaimView')->name('claim.track');
        Route::get('claim/view/{id}','HomeController@claimView')->name('claimEdit');
        
        
        Route::get('question-lists', 'HomeController@manageSecurityQuestions')->name('manage.question');
        Route::post('add-Security-Question', 'HomeController@addSecurityQuestion')->name('addSecurityQuestion');
        Route::post('security-questions/{id}', 'HomeController@updateSecurityQuestion')->name('updateSecurityQuestion');
        
        
        Route::get('application-status','HomeController@applicationStatus')->name('application_status');
        Route::get('view-application/{id}','HomeController@newApplication')->name('newApplication');
        Route::post('track-application-action', 'HomeController@trackAction')->name('track.application.action');
        Route::get('approver-view-application/{id}','HomeController@approvernewApplication')->name('approvernewApplication');
        Route::get('approver-letter/{application_id}','HomeController@userLetter')->name('user_letter');
        Route::get('view-letter/{application_id}','HomeController@adminViewLetter')->name('apporver_view_letter');
        Route::get('admin-approver-letter/{application_id}','HomeController@approverLetter')->name('approver_letter');
        // GET route to load the update application form
        Route::get('update-application/{id}', 'HomeController@updateApplication')->name('updateApplicationForm');
        // POST route to save the updated application
        Route::match(['put', 'post'], 'update-application/{id}', 'HomeController@saveUpdatedApplication')->name('updateApplication');
        Route::get('developer-list','HomeController@developer_list')->name('developer_list');
        Route::get('view-receipt','HomeController@viewReceipt')->name('view.receipt');
        Route::get('receipt-original','HomeController@userReceipt')->name('original_receipt');
         Route::get('receipt-copy','HomeController@adminuserReceiptCopy')->name('copy_receipt');
        // Route::get('user-approve','ApproverController@approve')->name('approve');
        Route::get('review-letter/{application_id}','HomeController@reviewLetter')->name('reviewLetter');
        Route::post('send-to-approver','HomeController@sendToApprover')->name('send-to-approver');
        Route::post('send-user-notification','HomeController@sendUserNotification')->name('send-user-notification');
        Route::get('get-notification-count','HomeController@getCount')
        ->name('get.notification.count');
        Route::get('get-notifications','HomeController@getNotifications')
        ->name('get-Notifications');
        Route::get('contribution-payment-report', 'HomeController@contribution_payment_report')->name('contribution_payment_report');
        Route::get('contribution-payment-report-detail', 'HomeController@contributionPaymentReportDetail')->name('contribution_payment_report_detail');
        Route::get('collectors-statement-report', 'HomeController@payment_report')->name('payment_report');
        Route::get('list-of-receipt', 'HomeController@paymentReceipt')->name('payment.receipt');
        Route::post('collectors-receipt', 'HomeController@collectors_receipt')->name('collectors-receipt');
        Route::post('/application/{id}/approve', [App\Http\Controllers\ApplicationController::class, 'approveApplication'])->name('application.approve');
        Route::post('/application/{id}/reject', [App\Http\Controllers\ApplicationController::class, 'rejectApplication'])->name('application.reject');
        Route::get('search', 'HomeController@searchFilter')->name('search.filter');
        Route::post('search', 'HomeController@searchFilter')->name('search-filter');
        Route::get('user-details/{id}', 'HomeController@userDetails')->name('user_details');
        Route::get('user-details-update/{id}', 'HomeController@userDetailsUpdate')->name('user_details_update');
        Route::get('user-receipts-original/{application_id}','HomeController@userReceiptView')->name('user_original_receipts');
        Route::put('user-details-update/{id}', 'HomeController@updateUserDetails')->name('update_user_details');
        // Route::get('approver_receiptoriginal','HomeController@approver_receiptoriginal')->name('approver_receiptoriginal');
        Route::get('notification','HomeController@notification')->name('notification');
        // Notification routes
        Route::post('notifications/{id}/mark-as-read','HomeController@markAsReads')->name('notifications.mark_as_read');
        Route::get('mark-notification-read','HomeController@markAsRead')
        ->name('mark.notification.read');
        Route::post('notifications/mark-all-as-read','HomeController@markAllAsRead' )->name('notifications.mark_all_as_read');
        
// Finance-Approver
         Route::get('approver-receiptoriginal','ApproverController@approver_receiptoriginal')->name('approver-receiptoriginal');
         Route::get('new-assignment-approver','ApproverController@approved_statement_approver')->name('approved_statement_approver');
         Route::get('collectors-statement-report-approver','ApproverController@collectors_statement_report_approver')->name('collectors_statement_report_approver');
         Route::get('collectors-receipt-approver/{report_id}','ApproverController@collectors_receipt_approver')->name('collectors_receipt_approver');
         Route::get('user-approve','ApproverController@approve')->name('approve');
         Route::get('cash-book-report-approver','ApproverController@cash_book_report_approver')->name('cash_book_report_approver');
         Route::get('daily-receipt-report-type-approver','ApproverController@dailyReceiptReportTypeApprover')->name('daily_receipt_report_type_approver');
         Route::get('daily-payment-receipt-report-approver','ApproverController@dailyPaymentReceiptReportApprover')->name('daily_payment_receipt_report_approver');
         Route::post('update-report-status', 'ApproverController@updateReportStatus');
         Route::post('/approver/{report_id}/reject', 'ApproverController@rejectReport')->name('approver.reports.reject');
         
        
        
        #Grouped Routes
        Route::group(['prefix'=>'settings'],function(){
            Route::resource('company', 'SettingsController', ['only' => ['index', 'store', 'update']])->names('settings.company');
            Route::resource('invoice', 'InvoiceSettingsController', ['only' => ['index', 'store', 'update']])->names('settings.invoice');
            Route::resource('email', 'EmailSettingsController', ['only' => ['index', 'store', 'update']])->names('settings.email');
            Route::resource('estimate', 'EstimateSettingsController', ['only' => ['index', 'store', 'update']])->names('settings.estimate');
            Route::resource('tax', 'TaxSettingsController')->names('settings.tax');
            Route::resource('templates', 'TemplatesController', ['only' => ['show', 'store', 'update']])->names('settings.template');
            Route::resource('number', 'NumberSettingsController', ['only' => ['index', 'store', 'update']])->names('settings.number');
            Route::resource('payment', 'PaymentMethodsController', ['except' => ['show']])->names('settings.payment');
            Route::resource('gateways', 'PaymentGatewayController',['only' => ['index', 'store', 'update']])->names('settings.gateways');
            Route::resource('currency', 'CurrencyController', ['except' => ['show']])->names('settings.currency');
            Route::resource('roles', 'RolesController')->names('settings.role');
            Route::resource('permissions', 'PermissionsController', ['except' => ['show', 'create']])->names('settings.permission');
            Route::resource('translations', 'TranslationsController')->names('settings.translation');
            Route::post('assignPermission', 'RolesController@assignPermission');
            Route::post('paypal_details', 'PaymentMethodsController@postPaypalDetails');
            Route::post('stripe_details', 'PaymentMethodsController@postStripeDetails');
            Route::get('update_exchange_rates', ['as'=>'update_exchange_rates','uses'=>'CurrencyController@updateCurrencyRates']);
            Route::post('/verify','InstallController@postVerify');
            Route::post('currency_key', 'CurrencyController@save_api_key')->name('post_currency_key');
        });
        # expenses resource
        Route::group(array('prefix'=>'expenses'),function(){
            Route::resource('list', 'ExpensesController')->names('expenses');
            Route::resource('category', 'ExpenseCategoryController')->names('expenses.category');
        });
        # products resource
        Route::group(array('prefix'=>'products'),function(){
            Route::resource('list', 'ProductsController')->names('products');
            Route::resource('category', 'ProductCategoryController')->names('products.category');
        });
        # estimates resource
        Route::group(array('prefix'=>'estimates'),function(){
            Route::post('deleteItem', 'EstimatesController@deleteItem');
            Route::get('pdf/{id}', 'EstimatesController@estimatePdf')->name('estimate_pdf');
            Route::post('makeInvoice', 'EstimatesController@makeInvoice');
            Route::get('send/{id}', 'EstimatesController@send_modal')->name('estimate_send_modal');
            Route::post('send', 'EstimatesController@send')->name('email_estimate');
        });
        # invoices resource
        Route::group(array('prefix'=>'invoices'),function(){
            Route::post('deleteItem', 'InvoicesController@deleteItem');
            Route::post('ajaxSearch', 'InvoicesController@ajaxSearch');
            Route::get('pdf/{id}', 'InvoicesController@invoicePdf')->name('invoice_pdf');;
            Route::get('send/{id}', 'InvoicesController@send_modal')->name('invoice.send_modal');
            Route::post('send', 'InvoicesController@send')->name('email_invoice');
        });
        # reports resource
        Route::group(array('prefix'=>'reports'),function(){
            Route::get('/', 'ReportsController@index');
            Route::post('general', 'ReportsController@general_summary');
            Route::post('payment_summary', 'ReportsController@payment_summary');
            Route::post('client_statement', 'ReportsController@client_statement');
            Route::post('invoices_report', 'ReportsController@invoices_report');
            Route::post('expenses_report', 'ReportsController@expenses_report');
        });
        # products custom routes
        Route::get('products_modal', 'ProductsController@products_modal')->name('products.modal');
        Route::post('process_products_selections', 'ProductsController@process_products_selections')->name('products.process_selection');
        # Profile
        Route::get('profile', ['uses' => 'ProfileController@index'])->name('users.profile.index');
        Route::post('profile', ['uses' => 'ProfileController@store'])->name('users.profile.store');
        # Language switch
        Route::get('lang/{lang}', ['as'=>'admin_lang_switch', 'uses'=>'LanguageController@switchLang']);
        Route::post('reports/ajaxData', 'ReportsController@ajaxData');
        #translations routes
        Route::get('language_translations/{groupKey}/{locale}', 'LanguageTranslationsController@getIndex')->where('groupKey', '.*')->name('language_translations');
    });
    
});
        Route::middleware(['auth:admin'])->group(function () {
        Route::get('approver-home', [ApproverController::class, 'approverHome'])->name('approver-home');
});
        Route::post('/validate-field', [\App\Http\Controllers\ClientArea\Auth\AuthController::class, 'validateField'])->name('validate.field');
        // Route::get('approver-receiptoriginal','ApproverController@approver_receiptoriginal')->name('approver_receiptoriginal');
        Route::get('approver-receiptoriginal','ApproverController@approver_receiptoriginal')->name('approver-receiptoriginal');


//Finance controller
    Route::middleware(['auth:admin'])->group(function () {
    // Route::get('/', 'HomeController@index')->name('home'); // Admin Dashboard
    Route::get('/finance-dashboard', 'FinanceController@index')->name('home-finance'); // Finance Dashboard
 });

    Route::get('/collectors-receipt-finance', 'FinanceController@collectors_receipt')->name('collectors_receipt_finance'); // Finance Dashboard
    Route::get('/approved-statement', 'FinanceController@approved_statement')->name('approved-statement'); // Finance Dashboard
    Route::get('/collectors-statement-report-finance', 'FinanceController@collectors_statement_report_finance')->name('collectors_statement_report_finance'); // Finance Dashboard
    Route::get('finance-payment-letter/{application_id}', 'FinanceController@financePaymentLetter')->name('finance.payment.letter');
    Route::get('/finance-receipt-original', 'FinanceController@finance_receipt_original')->name('finance_receipt_original'); // Finance Dashboard
    Route::post('finance/payment/{application_id}/approve', 'FinanceController@approvePayment')
    ->name('finance.payment.approve');
    Route::get('claim-contribution-report-show', 'FinanceController@claimContributionReport')
    ->name('claim-contribution-report-show');
    Route::get('claim-contribution-report-search', 'FinanceController@claimContributionReportSearch');
    Route::post('finance/payment/{application_id}/reject', 'FinanceController@rejectPayment')
    ->name('finance.payment.reject');
    Route::get('finance-user-approve','FinanceController@financeApprove')->name('finance.approve');
    Route::get('finance-view-receipt','FinanceController@viewReceipt')->name('finance.view.receipt');
    Route::get('finance/view-report/{report_id}', 'FinanceController@viewReportDetails')
    ->name('finance.view_report')
    ->where('report_id', '[0-9]+');
    // delete routes
    Route::delete('finance/reports/{id}/delete', 'FinanceController@deleteReport')
    ->name('finance.delete_report');


    
    Route::get('government-agency-application', 'FinanceController@governmentAgencyApplication')->name('finance.view.government-application');
    Route::get('collectors-statement-send-report-finance','FinanceController@collectors_statement_report_ispek')->name('collectors-statement-send-report-finance');
    Route::get('cash-book-report-finance','FinanceController@cash_book_report_finance')->name('cash_book_report_finance');
    Route::get('checkbook-receipt-finance','FinanceController@checkbook_receipt_finance')->name('checkbook_receipt_finance');
    Route::get('daily-receipt-report-type-finance','FinanceController@dailyReceiptReportTypeFinance')->name('daily_receipt_report_type_finance');
    Route::get('daily-payment-receipt-report-finance','FinanceController@dailyPaymentReceiptReport')->name('daily_payment_receipt_report_finance');
    Route::get('payment-summary-report-search', 'FinanceController@paymentSummaryReport')->name('payment.summary');
    Route::get('payment-summary-report', 'FinanceController@paymentSummaryReportDetails')->name('payment-summary-report');
    Route::get('task-not-completed-finance','FinanceController@task_not_completed_finance')->name('task_not_completed_finance');
    Route::get('treasury-receipts', 'FinanceController@treasury_receipts')->name('treasury_receipts');
    Route::get('treasury-receipt-show', 'FinanceController@treasury_receipt_show')->name('treasury_receipt_show');
    Route::get('report-list-all-application-contribution-ditch', 'FinanceController@reportListApplicationContributionDitch')->name('report-list-all-application-contribution-ditch');
    Route::get('report-list-all-application-contribution-ditch-search', 'FinanceController@reportListApplicationContributionDitchSearch')->name('report-list-all-application-contribution-ditch-search');
    Route::get('report-collection-contribution-ditch-by-district-search', 'FinanceController@reportCollectionContributionDistrictSearch')->name('report-collection-contribution-ditch-by-district-search');
    
    Route::get('report-collection-contribution-ditch-by-district', 'FinanceController@reportCollectionContributionDistrict')->name('report-collection-contribution-ditch-by-district');
    Route::get('receipt-void-report', 'FinanceController@receiptVoidReport')->name('receipt-void-report');
    Route::get('receipt-void-report-search', 'FinanceController@receiptVoidReportSearch')->name('receipt-void-report-search');
    Route::get('payment-summary-report-search', 'FinanceController@paymentSummaryReport')->name('payment.summary');
    Route::get('payment-summary-report', 'FinanceController@paymentSummaryReportDetails')->name('payment-summary-report');
    Route::get('report-collection-contribution-ditch-by-district-search', 'FinanceController@reportCollectionContributionDistrictSearch')->name('report-collection-contribution-ditch-by-district-search');

        Route::resources([
            'users'     => 'UsersController',
            'clients'   => 'ClientsController',
            'invoices'  => 'InvoicesController',
            'estimates' => 'EstimatesController',
            'payments'  => 'PaymentsController'
        ]);

//Finance-Reviewer
Route::middleware(['auth:admin'])->group(function () {
    // Route::get('/', [ReviewerController::class, 'index']);
    Route::get('/home-reviewer', [ReviewerController::class, 'index'])->name('home-reviewer'); // Finance Dashboard
    Route::post('reports/send-to-reviewer', [ReportReviewController::class, 'sendToReviewer'])
    ->name('reports.sendToReviewer');
    
     Route::post('reports/send-to-approver/{report_id}', [ReportReviewController::class, 'sendToApprover'])->name('reports.sendToApprover');
    
    // Reviewer dashboard
    Route::get('reviewer/dashboard', [ReportReviewController::class, 'reviewerDashboard'])
        ->name('reviewer.dashboard');
    
    // Review report action
    Route::post('reviewer/reports/{id}/review', [ReportReviewController::class, 'reviewReport'])
        ->name('reviewer.reviewReport');
});

Route::get('/new-assignment-reviewer', [ReviewerController::class, 'paymentReview'])->name('collectors_receipt_review');
Route::get('/collector-statement-report-reviewer', [ReviewerController::class, 'collectorStatement'])->name('collectorStatementReview');
Route::get('/collector/receipt/reviewer/{report_id}', [ReviewerController::class, 'collectorReceiptReview'])->name('collector.receipt.reviewer');
Route::post('/collector/{report_id}/reject', [ReviewerController::class, 'rejectReport'])->name('reports.reject');

Route::get('/cash-book-report-reviewer', [ReviewerController::class, 'cash_book_report_reviewer'])->name('cash_book_report_reviewer');
Route::get('/checkbook-receipt-reviewer', [ReviewerController::class, 'checkbook_receipt_reviewer'])->name('checkbook_receipt_reviewer');
Route::get('/daily-receipt-report-type-reviewer', [ReviewerController::class, 'dailyReceiptReportTypeReviewer'])->name('daily_receipt_report_type_reviewer');
Route::get('daily-payment-receipt-report-reviewer',[ReviewerController::class, 'dailyPaymentReceiptReportReviewer'])->name('daily_payment_receipt_report_reviewer');




// Application Approver
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/application-approver-dashboard', [ApplicationApproverController::class, 'index'])->name('home_adminapprover'); // Finance Dashboard
});


//  Admin Staff

    // Route::get('approver-receiptoriginal','ApproverController@approver_receiptoriginal')->name('approver-receiptoriginal');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/home-admin-staff', [AdminStaffController::class, 'index'])->name('home_admin_staff'); // Finance Dashboard
    });

Route::get('user-application-status', 'HomeController@userApplicationStatus')->name('userApplicationStatus');
Route::get('user-registration', 'HomeController@userRegistration')->name('userRegistration');


 