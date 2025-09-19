<?php



use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use App\Jobs\InvoicerMailerJob;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

if (!function_exists('sendmail')) {
    function sendmail(array $data) {
        try {
            dispatch(new InvoicerMailerJob($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
if(! function_exists('makeDirectoryIfNotExist')){
    function makeDirectoryIfNotExist($path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }
}
if(! function_exists('getMenus')){
    function getMenus(): array
    {
        $menus=[];
         $user = auth('admin')->check() && auth('admin')->user() ? auth('admin')->user() : null;
         //Super Admin Menu
         if($user->HasRole('admin')){
             
            //  dd($user);
    
   
        $menus = [
            'main_menu' => [
                'title' => trans('app.main_menu'),
                'menus' => [
                    [
                        'icon' => 'home',
                        'text' => trans('app.dashboard'),
                        'route' => url('home'),
                        'menu_active' => request()->is('home') ? 'active' : ''
                    ],
                    // [
                    //     'icon' => 'users',
                    //     'text' => trans('app.clients'),
                    //     'route' => url('clients'),
                    //     'menu_active' => FormFacade::menu_active('clients'),
                    // ],
                     [
                        'icon' => 'users',
                        'text' => trans('app.new_registrations'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('developer-list') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('developer-list') ? 'block' : 'none',
                        'menu_active' => request()->is('developer-list') ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.applicant_list'),
                                'route' =>  url('developer-list'),
                                'menu_active' => request()->is('developer-list') ? 'active' : ''
                            ],
                        ]
                    ],
                    // [
                    //     'icon' => 'file-pdf-o',
                    //     'text' => trans('app.invoices'),
                    //     'route' => url('invoices'),
                    //     'menu_active' => FormFacade::menu_active('invoices')
                    // ],
                    // [
                    //     'icon' => 'list-alt',
                    //     'text' => trans('app.estimates'),
                    //     'route' => url('estimates'),
                    //     'menu_active' => FormFacade::menu_active('estimates')
                    // ],
                    // [
                    //     'icon' => 'money',
                    //     'text' => trans('app.payments'),
                    //     'route' => url('payments'),
                    //     'menu_active' => FormFacade::menu_active('payments')
                    // ],
                     [
                        'icon' => 'line-chart',
                        'text' => trans('app.new_applications'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('application-list') || request()->is('application-status') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('application-list') || request()->is('application-status') ? 'block' : 'none',
                        'menu_active' => request()->is('application-list') || request()->is('application-status') ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.list_of_application'),
                                'route' =>  url('application-list'),
                                'menu_active' => request()->is('application-list') ? 'active' : ''
                            ],
                            [
                                'icon' => 'line-chart',
                                'text' => trans('app.application_status'),
                                'route' =>  url('application-status'),
                                'menu_active' => request()->is('application-status') ? 'active' : ''
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.claim_contribution'),
                                'route' =>  url('#'),
                                'menu_active' => ''
                            ]
                        ]
                    ],
                    
                    [
                        'icon' => 'money',
                        'text' => trans('app.payments'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('view-receipt') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt') ? 'block' : 'none',
                        'menu_active' => request()->is('view-receipt') ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.list_of_payments'),
                                'route' =>  url('view-receipt'),
                                'menu_active' => request()->is('view-receipt') ? 'active' : ''
                            ],
                        ]
                    ],
                     [
                        'icon' => 'money',
                        'text' => trans('app.log_activities'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('view-receipt') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt') ? 'block' : 'none',
                        'menu_active' => request()->is('view-receipt') ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.log_activities'),
                                'route' =>  url('activity-logs-check'),
                                'menu_active' => request()->is('view-receipt') ? 'active' : ''
                            ],
                        ]
                    ],
                    [
                        'icon' => 'location',
                        'text' => trans('app.location'),
                        'route' => url('expenses'),
                        'active_dropdown' => active_dropdown_menu('expenses') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => active_dropdown_menu('expenses') ? 'block' : 'none',
                        'menu_active' => FormFacade::menu_active('expenses').' '.FormFacade::menu_active('expenses/category'),
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'location',
                                'text' => trans('app.manage_state'),
                                'route' => route('manage.state'),
                                'menu_active' => Request::is('expenses/list') ? 'active' : null
                            ],
                            [
                                'icon' => 'location',
                                'text' => trans('app.mange_district'),
                                'route' => route('manageDistrict'),
                                'menu_active' => Request::is('expenses/category') ? 'active' : null
                            ],
                            [
                                'icon' => 'location',
                                'text' => trans('app.manage_division'),
                                'route' => route('manageDivision'),
                                'menu_active' => Request::is('products/category') ? 'active' : null
                            ]
                        ]
                    ],
                    [
                        'icon' => 'globe',
                        'text' => trans('app.land_management'),
                        'route' => url('products'),
                        'active_dropdown' => active_dropdown_menu('products') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => active_dropdown_menu('products') ? 'block' : 'none',
                        'menu_active' => FormFacade::menu_active('products').' '.FormFacade::menu_active('products/category'),
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'layer-group',
                                'text' => trans('app.land_category'),
                                'route' => route('landCategories'),
                                'menu_active' => Request::is('products/list') ? 'active' : null
                            ],
                             [
                                'icon' => 'question',
                                'text' => trans('app.question_management'),
                                'route' => route('manage.question'),
                                'menu_active' => Request::is('products/list') ? 'active' : null
                            ],
                        ]
                    ],
                    // [
                    //     'icon' => 'puzzle-piece',
                    //     'text' => trans('app.products'),
                    //     'route' => url('products'),
                    //     'active_dropdown' => active_dropdown_menu('products') ? 'menu-is-opening menu-open' : '',
                    //     'active_dropdown_menu' => active_dropdown_menu('products') ? 'block' : 'none',
                    //     'menu_active' => FormFacade::menu_active('products').' '.FormFacade::menu_active('products/category'),
                    //     'is_dropdown' => true,
                    //     'submenus' => [
                    //         [
                    //             'icon' => 'circle',
                    //             'text' => trans('app.products'),
                    //             'route' => route('products.index'),
                    //             'menu_active' => Request::is('products/list') ? 'active' : null
                    //         ],
                    //         [
                    //             'icon' => 'circle',
                    //             'text' => trans('app.categories'),
                    //             'route' => route('products.category.index'),
                    //             'menu_active' => Request::is('products/category') ? 'active' : null
                    //         ]
                    //     ]
                    // ],
                    // [
                    //     'icon' => 'line-chart',
                    //     'text' => trans('app.reports'),
                    //     'route' => url('reports'),
                    //     'menu_active' => FormFacade::menu_active('reports')
                    // ],
                    
                     [
                            'icon' => 'line-chart',
                            'text' => trans('app.reports'),
                            'route' => url('#'),
                            'active_dropdown' => request()->is('collectors-statement-report') ? 'menu-is-opening menu-open' : '',
                            'active_dropdown_menu' => request()->is('collectors-statement-report') ? 'block' : 'none',
                            'menu_active' => '',
                            'is_dropdown' => true,
                            'submenus' => [
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.daily_receipt_payment_report'),
                                'route' =>  url('#'),
                                'menu_active' => ''
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.collection_payment_report'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('collectors-statement-report') ? 'active' : '',
                                'submenus' => [ // Second-level submenu
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.generate_a_collectors_statement'),
                                                    'route' =>  url('collectors-statement-report'),
                                                    'menu_active' => request()->is('collectors-statement-report') ? 'active' : ''
                                                ]
                                                
                                            ],
                                
                                
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.contribution_payment_report'),
                                'route' =>  url('#'),
                                'menu_active' => ''
                            ],
                           
                        ]
                    ],
                    // [
                    //     'icon' => 'user',
                    //     'text' => trans('app.users'),
                    //     'route' => url('users'),
                    //     'menu_active' => FormFacade::menu_active('users')
                    // ]
                ]
            ]
        ];
        // if(hasPermission('setting.view')){
        //     $menus['main_menu']['menus'][] = [
        //         'icon' => 'cogs',
        //         'text' => trans('app.settings'),
        //         'route' => url('settings/company'),
        //         'menu_active' => FormFacade::menu_active('settings')
        //     ];
        // }
        
        $menus['account_menu'] = [
            'title' => trans('app.account_menu'),
            'menus' => [
                [
                    'icon' => 'fa fa-search',
                    'text' => trans('app.filter_search'),
                    'route' => url('/search'),
                    'menu_active' => request()->is('search') || request()->is('search/*') ? 'active' : ''
                ],
                [
                    'icon' => 'fa fa-users',
                    'text' => trans('app.staff'),
                    'route' => url('staff'),
                    'menu_active' => request()->is('staff') || request()->is('staff/*') ? 'active' : ''
                ],
                [
                    'icon' => 'fa fa-building',
                    'text' => trans('app.department'),
                    'route' => url('department'),
                    'menu_active' => request()->is('department') || request()->is('department/*') ? 'active' : ''
                ],
                [
                    'icon' => 'fa fa-key',
                    'text' => trans('app.roles_and_permission'),
                    'route' => url('role'),
                    'menu_active' => request()->is('role') || request()->is('role/*') ? 'active' : ''
                ],
                [
                    'icon' => 'user',
                    'text' => trans('app.profile'),
                    'route' => url('profile'),
                    'menu_active' => request()->is('profile') || request()->is('profile/*') ? 'active' : ''
                ],
                [
                        'icon' => 'credit-card',
                        'text' => trans('app.helpdesk'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('manual') || request()->is('support') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('manual') || request()->is('support') ? 'block' : 'none',
                        'menu_active' => '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'user',
                                'text' => trans('app.manual'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('manual') ? 'active' : ''
                            ],
                            [
                                'icon' => 'support',
                                'text' => trans('app.support'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('support') ? 'active' : ''
                            ]
                        ]
                    ],
                    
                    // [
                    //     'icon' => 'line-chart',
                    //     'text' => trans('app.reports'),
                    //     'route' => url('reports'),
                    //     'menu_active' => FormFacade::menu_active('reports')
                    // ],
                [
                    'icon' => 'power-off',
                    'text' => trans('app.logout'),
                    'route' => route('admin_logout'),
                    'menu_active' => request()->is('logout') ? 'active' : ''
                ]
            ]
        ];
    }
        //Finance-Approver Menu
         else if($user->HasRole('approver')){
    
   
        $menus = [
            'main_menu' => [
                'title' => trans('app.main_menu'),
                'menus' => [
                    [
                        'icon' => 'home',
                        'text' => trans('app.dashboard'),
                        'route' => url('approver-home'),
                         'menu_active' => request()->is('approver-home') ? 'active' : '',
                    ],
                    
                      [
                        'icon' => 'line-chart',
                        'text' => trans('app.application'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('user-approve') || request()->is('application-status') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('user-approve') || request()->is('application-status') ? 'block' : 'none',
                        'menu_active' => '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.application_list'),
                                'route' =>  url('user-approve'),
                                'menu_active' => request()->is('user-approve') ? 'active' : '',
                                'permission' => 'applications.view-list',
                            ],
                            [
                                'icon' => 'line-chart',
                                'text' => trans('app.application_status'),
                                'route' =>  url('application-status'),
                                'menu_active' => request()->is('application-status') ? 'active' : '',
                                'permission' => 'application-status.view-list',
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.claim_contribution'),
                                'route' => url('claim-list'),
                                'menu_active' => request()->is('claim-contribution') ? 'active' : '',
                                'permission' => 'claim-contribution.view-list'
                            ]
                        ]
                    ],
                    
                    
                    [
                        'icon' => 'money',
                        'text' => trans('app.payments'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('view-receipt') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt') ? 'block' : 'none',
                        'menu_active' => '',
                        'permission' => 'payments.view-list',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.list_of_payments'),
                                'route' =>  url('view-receipt'),
                                'menu_active' => request()->is('view-receipt') ? 'active' : '',
                                'permission' => 'payments.view-details',
                            ],
                        ]
                    ],
                  
                    
                    [
                        'icon' => 'line-chart',
                        'text' => trans('app.reports'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('daily-receipt-report-type-approver') || request()->is('cash-book-report-approver') || request()->is('new-assignment-approver') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('daily-receipt-report-type-approver') || request()->is('cash-book-report-approver') || request()->is('new-assignment-approver') ? 'block' : 'none',
                        'menu_active' => '',
                        'permission' => 'reports.view-list',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.collection_payment_report'),
                                'route' => url('#'),
                                //  Ensure parent menu stays open if child `new-assignment-approver` is active
                                'active_dropdown' => request()->is('new-assignment-approver') ? 'menu-is-opening menu-open' : '',
                                'active_dropdown_menu' => request()->is('new-assignment-approver') ? 'block' : 'none',
                                'menu_active' => request()->is('new-assignment-approver') ? 'active' : '',
                                'permission' => 'collection-payment.view-list',
                                'is_dropdown' => true,
                                'submenus' => [
                                    [
                                        'icon' => 'file-text',
                                        'text' => trans('app.assignments_not_taken'),
                                        'route' => url('new-assignment-approver'),
                                        //  Ensure this submenu is active when visiting this route
                                        'menu_active' => request()->is('new-assignment-approver') ? 'active' : '',
                                    ],
                                ],
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.daily_receipt_payment_report'),
                                'route' => url('daily-receipt-report-type-approver'),
                                'menu_active' => request()->is('daily-receipt-report-type-approver') ? 'active' : '',
                                'permission' => 'daily-payment-receipt.view-list',
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.checkbook_cash_book_report_by_date'),
                                'route' => url('cash-book-report-approver'),
                                'menu_active' => request()->is('cash-book-report-approver') ? 'active' : '',
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.contribution_payment_report'),
                                'route' => url('#'),
                                'menu_active' => '',
                                'permission' => 'contribution-payment.view-list',
                            ],
                        ]
                    ],

                    [
                        'icon' => 'user',
                        'text' => trans('app.profile'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('profile') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('profile') ? 'block' : 'none',
                        'menu_active' => '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                            'icon' => 'user',
                            'text' => trans('app.personal_information'),
                            'route' => url('profile'),
                            'menu_active' => request()->is('profile') ? 'active' : '',
                            ],
                            [
                            'icon' => 'user',
                            'text' => trans('app.update_profile'),
                            'route' => url('#'),
                             'menu_active' => '',
                            ],
                            [
                                'icon' => 'user',
                                'text' => trans('app.security_settings'),
                                'route' => url('change-password/' . auth('admin')->user()->uuid),
                                'menu_active' => ''
                           ],
                        ]
                    ],
                    [
                        'icon' => 'credit-card',
                        'text' => trans('app.helpdesk'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('helpdesk/*') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('helpdesk/*') ? 'block' : 'none',
                        'menu_active' => '',
                        'permission' => 'helpdesk',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'user',
                                'text' => trans('app.manual'),
                                'route' =>  url('#'),
                                'menu_active' => '',
                                'permission' => 'manual'
                            ],
                            [
                                'icon' => 'support',
                                'text' => trans('app.support'),
                                'route' =>  url('#'),
                                'menu_active' => '',
                                'permission' => 'support'
                            ]
                        ]
                    ],
                ]
            ]
        ];
        // if(hasPermission('setting.view')){
        //     $menus['main_menu']['menus'][] = [
        //         'icon' => 'cogs',
        //         'text' => trans('app.settings'),
        //         'route' => url('settings/company'),
        //         'menu_active' => FormFacade::menu_active('settings')
        //     ];
        // }
        
        $menus['account_menu'] = [
            'title' => trans('app.account_menu'),
            'menus' => [
                [
                    'icon' => 'fa fa-search',
                    'text' => trans('app.filter_search'),
                    'route' => url('/search'),
                    'menu_active' => request()->is('search') || request()->is('search/*') ? 'active' : '',
                    'permission' => 'filter-search'
                    
                ],
                
                [
                    'icon' => 'power-off',
                    'text' => trans('app.logout'),
                    'route' => route('admin_logout'),
                    'menu_active' => request()->is('admin_logout') ? 'active' : '',
                ],
            ]
        ];
    }
        // Adminstaff Menu
         else if($user->HasRole('adminstaff')){
             $applicationCount = getAdminStaffApplicationCount();
             $claimCount =  getClaimContributionPendingCount();
         $menus = [
            'main_menu' => [
                'title' => trans('app.main_menu'),
                'menus' => [
                    [
                        'icon' => 'home',
                        'text' => trans('app.dashboard'),
                        'route' => url('home-admin-staff'),
                        'menu_active' => request()->is('home-admin-staff') ? 'active' : '',
                    ],
            
                     [
                        'icon' => 'users',
                        'text' => trans('app.new_registrations'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('developer-list')  ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('developer-list')  ? 'block' : 'none',
                        'menu_active' => '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.applicant_list'),
                                'route' => url('developer-list'),
                                'menu_active' => request()->is('developer-list') ? 'active' : '',
                                'permission' => 'customers.view-list'
                            ],
                        ]
                    ],
                    
                     [
                        'icon' => 'line-chart',
                        'text' => trans('app.new_applications'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('application-list') || request()->is('application-status') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('application-list') || request()->is('application-status') ? 'block' : 'none',
                        'menu_active' => request()->is('application-list') || request()->is('application-status') ? 'active' : '',
                        'badge_count' => $applicationCount, // Add badge count here
                        'badge_class' => 'badge bg-danger text-secondary',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.list_of_application'),
                                'route' => url('application-list'),
                                'menu_active' => request()->is('application-list') ? 'active' : '',
                                'permission' => 'applications.view-list' 
                            ],
                            [
                                'icon' => 'line-chart',
                                'text' => trans('app.application_status'),
                                'route' => url('application-status'),
                                'menu_active' => request()->is('application-status') ? 'active' : '',
                                'permission' => 'application-status.view-list'
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.claim_contribution'),
                                'route' => url('claim-list'),
                                'menu_active' => '',
                                'badge_count' => $claimCount,
                                'badge_class' => 'badge bg-danger text-secondary',
                                'permission' => 'claim-contribution.view-list'
                            ]
                        ]
                    ],
                    
                    [
                        'icon' => 'money',
                        'text' => trans('app.payments'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('view-receipt') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt') ? 'block' : 'none',
                        'menu_active' => request()->is('view-receipt') ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.list_of_payments'),
                                'route' => url('view-receipt'),
                                'menu_active' => request()->is('view-receipt') ? 'active' : '',
                                'permission' => 'payments.view-list'
                            ],
                        ]
                    ],
                    
            //          [
            //             'icon' => 'line-chart',
            //             'text' => trans('app.reports'),
            //             'route' => url('#'),
            //             'active_dropdown' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('daily-receipt-payment-report') || request()->is('contribution-payment-report') ? 'menu-is-opening menu-open' : '',
            //             'active_dropdown_menu' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('daily-receipt-payment-report') || request()->is('contribution-payment-report') ? 'block' : 'none',
            //             'menu_active' => '',
            //             'permission' => 'reports.view-list',
            //             'is_dropdown' => true,
            //             'submenus' => [
            //                 [
            //                     'icon' => 'money',
            //                     'text' => trans('app.report_list_application_ditch_contribution'),
            //                     'route' =>  url('report-list-all-application-contribution-ditch-search'),
            //                     'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') ? 'active' : '',
            //                 ],
                            
            //                 [
            //                         'icon' => 'money',
            //                         'text' => trans('app.report_collection_contribution_ditch_by_district'),
            //                         'route' =>  url('report-collection-contribution-ditch-by-district-search'),
            //                         'menu_active' => request()->is('report-collection-contribution-ditch-by-district-search','report-collection-contribution-ditch-by-district') ? 'active' : '',
            //                 ],
                           
            //                 [
            //             'icon' => 'money',
            //             'text' => trans('app.contribution_payment_report'),
            //             'route' => url('contribution-payment-report'),
            //             'menu_active' => request()->is('contribution-payment-report') ? 'active' : '',
            //             'permission' => 'contribution-payment.view-list',
            //         ],
            //     ]
            // ]
            
                        [
                            'icon' => 'line-chart',
                            'text' => trans('app.reports'),
                            'route' => url('#'),
                            'active_dropdown' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') || request()->is('daily-receipt-report-type-finance') || request()->is('receipt-void-report-search' , 'receipt-void-report') || request()->is('cash-book-report-finance') || request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance')  ? 'menu-is-opening menu-open' : '',
                            'active_dropdown_menu' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') || request()->is('daily-receipt-report-type-finance') || request()->is('receipt-void-report-search' , 'receipt-void-report') || request()->is('cash-book-report-finance') || request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'block' : 'none',
                            'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') ? 'active' : '',
                            'permission' => 'reports.view-list',
                            'is_dropdown' => true,
                            'submenus' => [
                                
                                [
                                'icon' => 'money',
                                'text' => trans('app.report_list_application_ditch_contribution'),
                                'route' =>  url('report-list-all-application-contribution-ditch-search'),
                                'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') ? 'active' : '',
                                'permission'=> 'report.account.type'
                                ],
                                [
                                'icon' => 'money',
                                'text' => trans('app.report_collection_contribution_ditch_by_district'),
                                'route' =>  url('report-collection-contribution-ditch-by-district-search'),
                                'menu_active' => request()->is('report-collection-contribution-ditch-by-district-search','report-collection-contribution-ditch-by-district') ? 'active' : '',
                                'permission' => 'report.district'
                                ],
                                [
                                'icon' => 'money',
                                'text' => trans('app.collection_payment_report'),
                                'route' =>  url('#'),
                                'active_dropdown' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'menu-is-opening menu-open' : '',
                                'active_dropdown_menu' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance')  ? 'block' : 'none',
                                'menu_active' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'active' : '',
                                'permission' => 'collection-payment.view-list',
                                'is_dropdown' => true,
                                'submenus' => [ // Second-level submenu
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.generate_a_collectors_statement'),
                                                    'route' =>  url('collectors-statement-report'),
                                                    'menu_active' => request()->is('collectors-statement-report') ? 'active' : '',
                                                    'permission' => 'generate_collector_statement'
                                                ],
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.assignments_not_taken'),
                                                    'route' =>  url('approved-statement'),
                                                    'menu_active' => request()->is('approved-statement') ? 'active' : '',
                                                    'permission' => 'approved_statement'
                                                ],
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.unfinished_tasks'),
                                                    'route' =>  url('task-not-completed-finance'),
                                                    'menu_active' => request()->is('task-not-completed-finance') ? 'active' : '',
                                                ]
                                                
                                            ],
                                
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.daily_payment_receipt_report_by'),
                                'route' =>  url('daily-receipt-report-type-finance'),
                                'menu_active' => request()->is('daily-receipt-report-type-finance') ? 'active' : '',
                                'permission' => 'daily-payment-receipt.view-list',
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.summary_of_overall_receipt_report'),
                                'route' =>  url('payment-summary-report-search'),
                                'menu_active' => request()->is('receipt-void-report' ,'receipt-void-report') ? 'active' : '',
                                'permission'  => 'payment.summary.report'

                            ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.receipt_void_report'),
                            //     'route' =>  url('receipt-void-report-search'),
                            //     'menu_active' => request()->is('receipt-void-report' ,'receipt-void-report') ? 'active' : '',

                            // ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.checkbook_cash_book_report_by_date'),
                            //     'route' =>  url('cash-book-report-finance'),
                            //     'menu_active' => request()->is('cash-book-report-finance') ? 'active' : '',
                            // ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.contribution_payment_report'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('') ? 'active' : '',
                                'permission' => 'contribution-payment.view-list',
                            ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.treasury_eceipts'),
                            //     'route' =>  url('treasury-receipts'),
                            //     'menu_active' => Request::is('treasury-receipts') ? 'active' : null
                            // ],
                            
                        ]
                    ],
        ]
    ]
];
        
        $menus['account_menu'] = [
    'title' => trans('app.account_menu'),
    'menus' => [
        [
            'icon' => 'fa fa-search',
            'text' => trans('app.filter_search'),
            'route' => url('/search'),
            'menu_active' => request()->is('search') || request()->is('search/*') ? 'active' : '',
            'permission' => 'filter-search'
        ],
         [
            'icon' => 'fa fa-users',
            'text' => trans('app.staff'),
            'route' => url('staff'),
            'menu_active' => request()->is('staff') || request()->is('staff/*') ? 'active' : '',
            'permission' => 'staff.view-list' 
        ],
        [
            'icon' => 'fa fa-building',
            'text' => trans('app.department'),
            'route' => url('department'),
            'menu_active' => request()->is('department') || request()->is('department/*') ? 'active' : '',
            'permission' => 'department.view-list' 
        ],
        [
            'icon' => 'user',
            'text' => trans('app.profile'),
            'route' => url('#'),
            'active_dropdown' => request()->is('profile') ? 'menu-is-opening menu-open' : '',
            'active_dropdown_menu' => request()->is('profile') ? 'block' : 'none',
            'menu_active' => request()->is('profile') ? 'active' : '',
            'is_dropdown' => true,
            'submenus' => [
                [
                    'icon' => 'user',
                    'text' => trans('app.personal_information'),
                    'route' => url('profile'),
                    'menu_active' => request()->is('profile') ? 'active' : ''
                ],
                // [
                //     'icon' => 'user',
                //     'text' => trans('app.update_profile'),
                //     'route' => url('#'),
                //     'menu_active' => ''
                // ],
                 [
                    'icon' => 'user',
                    'text' => trans('app.security_settings'),
                    'route' => url('change-password/' . auth('admin')->user()->uuid),
                    'menu_active' => ''
                ],
            ]
        ],
        [
            'icon' => 'credit-card',
            'text' => trans('app.helpdesk'),
            'route' => url('#'),
            'active_dropdown' => request()->is('manual') || request()->is('support') ? 'menu-is-opening menu-open' : '',
            'active_dropdown_menu' => request()->is('manual') || request()->is('support') ? 'block' : 'none',
            'menu_active' => '',
            'permission' => 'helpdesk',
            'is_dropdown' => true,
            'submenus' => [
                [
                    'icon' => 'user',
                    'text' => trans('app.manual'),
                    'route' => url('#'),
                    'menu_active' => request()->is('manual') ? 'active' : '',
                    'permission' => 'manual' 
                ],
                [
                    'icon' => 'support',
                    'text' => trans('app.support'),
                    'route' => url('#'),
                    'menu_active' => request()->is('support') ? 'active' : '',
                    'permission' => 'support' 
                ]
            ]
        ],
        [
            'icon' => 'power-off',
            'text' => trans('app.logout'),
            'route' => route('admin_logout'),
            'menu_active' => FormFacade::menu_active('logout')
        ]
    ]
];
    }
    
     // Admin-Approver Menu
         else if($user->HasRole('application_approver')){
             $applicationCount = getAdminApproverApplicationCount();
         $menus = [
            'main_menu' => [
                'title' => trans('app.main_menu'),
                'menus' => [    
                    [
                        'icon' => 'home',
                        'text' => trans('app.dashboard'),
                        'route' => url('application-approver-dashboard'),
                        'menu_active' => request()->is('application-approver-dashboard') ? 'active' : '',
                    ],
            
                     [
                        'icon' => 'users',
                        'text' => trans('app.new_registrations'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('developer-list') || request()->is('approved-statement') ? 'menu-is-opening menu-open' : '',
                        'menu_active' => request()->is('developer-list') || request()->is('approved-statement') ? 'active' : '' ,
                        'active_dropdown_menu' => request()->is('developer-list'),
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.applicant_list'),
                                'route' =>  url('developer-list'),
                                'menu_active' => request()->is('developer-list') ? 'active' : '',
                                'permission' => 'customers.view-list'
                            ],
                        ]
                    ],
                    
                     [
                        'icon' => 'line-chart',
                        'text' => trans('app.new_applications'),
                        'route' => url('#'),
                        'active_dropdown' =>request()->is('application-list') || request()->is('application-status') || request()->is('claim-contribution') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('application-list') || request()->is('application-status') || request()->is('claim-contribution') ? 'block' : 'none',
                        'menu_active' => request()->is('developer-list') ? 'active' : '',
                        'badge_count' => $applicationCount, // Add badge count here
                        'badge_class' => 'badge bg-danger text-secondary',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.list_of_application'),
                                'route' =>  url('approver-application-list'),
                                'menu_active' => request()->is('approver-application-list') ? 'active' : '',
                                'permission' => 'applications.view-list'
                            ],
                            [
                                'icon' => 'line-chart',
                                'text' => trans('app.application_status'),
                                'route' =>  url('application-status'),
                                'menu_active' => request()->is('application-status') ? 'active' : '',
                                'permission' => 'application-status.view-list'
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.claim_contribution'),
                                'route' => url('claim-list'),
                                'menu_active' => request()->is('claim-contribution') ? 'active' : '',
                                'permission' => 'claim-contribution.view-list'
                            ]
                        ]
                    ],
                    
                    [
                        'icon' => 'money',
                        'text' => trans('app.payments'),
                        'route' => url('#'),
                        'active_dropdown' =>request()->is('view-receipt')  ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt')  ? 'block' : 'none',
                        'menu_active' => request()->is('view-receipt') ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.list_of_payments'),
                                'route' =>  url('view-receipt'),
                                'menu_active' => request()->is('view-receipt') ? 'active' : '',
                                'permission' => 'payments.view-list'
                            ],
                        ]
                    ],
                    
                    //  [
                    //         'icon' => 'line-chart',
                    //         'text' => trans('app.reports'),
                    //         'route' => url('#'),
                    //         'active_dropdown' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('daily-receipt-payment') || request()->is('contribution-payment-report') ? 'menu-is-opening menu-open' : '',
                    //         'menu_active' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('daily-receipt-payment') || request()->is('contribution-payment-report') ? 'active' : '',
                    //         'permission' => 'reports.view-list',
                    //         'is_dropdown' => true,
                    //         'submenus' => [
                    // [
                    //     'icon' => 'money',
                    //     'text' => trans('app.daily_receipt_payment_report'),
                    //     'route' => url('#'),
                    //     'menu_active' => request()->is('daily-receipt-payment') ? 'active' : '',
                    //     'permission' => 'daily-payment-receipt.view-list',
                    // ],
                    // [
                    //     'icon' => 'money',
                    //     'text' => trans('app.collection_payment_report'),
                    //     'route' => url('#'),
                    //     'active_dropdown' => request()->is('collectors-statement-report') || request()->is('approved-statement') ? 'menu-is-opening menu-open' : '',
                    //     'menu_active' => request()->is('collectors-statement-report') || request()->is('approved-statement') ? 'active' : '',
                    //     'permission' => 'collection-payment.view-list',
                    //     'is_dropdown' => true,
                    //     'submenus' => [
                    //         [
                    //             'icon' => 'file-text',
                    //             'text' => trans('app.generate_a_collectors_statement'),
                    //             'route' => url('collectors-statement-report'),
                    //             'menu_active' => request()->is('collectors-statement-report') ? 'active' : '',
                    //             'permission' => 'generate_collector_statement'
                    //         ],
                    //         [
                    //             'icon' => 'file-text',
                    //             'text' => trans('app.approved_statement'),
                    //             'route' => url('approved-statement'),
                    //             'menu_active' => request()->is('approved-statement') ? 'active' : '',
                    //             'permission' => 'approved_statement'
                    //         ]
                    //     ]
                    // ],
                    // [
                    //     'icon' => 'money',
                    //     'text' => trans('app.contribution_payment_report'),
                    //     'route' => url('#'),
                    //     'menu_active' => request()->is('contribution-payment-report') ? 'active' : '',
                    //     'permission' => 'contribution-payment.view-list',
                    // ]
                           
                    //     ]
                    // ],
                    
                    
                    [
                            'icon' => 'line-chart',
                            'text' => trans('app.reports'),
                            'route' => url('#'),
                            'active_dropdown' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') || request()->is('daily-receipt-report-type-finance') || request()->is('receipt-void-report-search' , 'receipt-void-report') || request()->is('cash-book-report-finance') || request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance')  ? 'menu-is-opening menu-open' : '',
                            'active_dropdown_menu' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') || request()->is('daily-receipt-report-type-finance') || request()->is('receipt-void-report-search' , 'receipt-void-report') || request()->is('cash-book-report-finance') || request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'block' : 'none',
                            'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') ? 'active' : '',
                            'permission' => 'reports.view-list',
                            'is_dropdown' => true,
                            'submenus' => [
                                
                                [
                                'icon' => 'money',
                                'text' => trans('app.report_list_application_ditch_contribution'),
                                'route' =>  url('report-list-all-application-contribution-ditch-search'),
                                'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') ? 'active' : '',
                                'permission'=> 'report.account.type'
                                ],
                                [
                                'icon' => 'money',
                                'text' => trans('app.report_collection_contribution_ditch_by_district'),
                                'route' =>  url('report-collection-contribution-ditch-by-district-search'),
                                'menu_active' => request()->is('report-collection-contribution-ditch-by-district-search','report-collection-contribution-ditch-by-district') ? 'active' : '',
                                'permission' => 'report.district'
                                ],
                                [
                                'icon' => 'money',
                                'text' => trans('app.collection_payment_report'),
                                'route' =>  url('#'),
                                'active_dropdown' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'menu-is-opening menu-open' : '',
                                'active_dropdown_menu' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance')  ? 'block' : 'none',
                                'menu_active' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'active' : '',
                                'permission' => 'collection-payment.view-list',
                                'is_dropdown' => true,
                                'submenus' => [ // Second-level submenu
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.generate_a_collectors_statement'),
                                                    'route' =>  url('collectors-statement-report'),
                                                    'menu_active' => request()->is('collectors-statement-report') ? 'active' : '',
                                                    'permission' => 'generate_collector_statement'
                                                ],
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.assignments_not_taken'),
                                                    'route' =>  url('approved-statement'),
                                                    'menu_active' => request()->is('approved-statement') ? 'active' : '',
                                                    'permission' => 'approved_statement'
                                                ],
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.unfinished_tasks'),
                                                    'route' =>  url('task-not-completed-finance'),
                                                    'menu_active' => request()->is('task-not-completed-finance') ? 'active' : '',
                                                ]
                                                
                                            ],
                                
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.daily_payment_receipt_report_by'),
                                'route' =>  url('daily-receipt-report-type-finance'),
                                'menu_active' => request()->is('daily-receipt-report-type-finance') ? 'active' : '',
                                'permission' => 'daily-payment-receipt.view-list',
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.summary_of_overall_receipt_report'),
                                'route' =>  url('payment-summary-report-search'),
                                'menu_active' => request()->is('receipt-void-report' ,'receipt-void-report') ? 'active' : '',
                                'permission'  => 'payment.summary.report'

                            ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.receipt_void_report'),
                            //     'route' =>  url('receipt-void-report-search'),
                            //     'menu_active' => request()->is('receipt-void-report' ,'receipt-void-report') ? 'active' : '',

                            // ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.checkbook_cash_book_report_by_date'),
                            //     'route' =>  url('cash-book-report-finance'),
                            //     'menu_active' => request()->is('cash-book-report-finance') ? 'active' : '',
                            // ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.contribution_payment_report'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('') ? 'active' : '',
                                'permission' => 'contribution-payment.view-list',
                            ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.treasury_eceipts'),
                            //     'route' =>  url('treasury-receipts'),
                            //     'menu_active' => Request::is('treasury-receipts') ? 'active' : null
                            // ],
                            
                        ]
                    ],
                   
                ]
            ]
        ];
        
        $menus['account_menu'] = [
            'title' => trans('app.account_menu'),
            'menus' => [
                [
                    'icon' => 'fa fa-search',
                    'text' => trans('app.filter_search'),
                    'route' => url('/search'),
                    'menu_active' => request()->is('search') || request()->is('search/*') ? 'active' : '',
                    'permission' => 'filter-search'
                ],
                
                [
                    'icon' => 'user',
                    'text' => trans('app.profile'),
                    'route' => url('#'),
                    'active_dropdown' => request()->is('profile') ? 'menu-is-opening menu-open' : '',
                    'active_dropdown_menu' => request()->is('profile') ? 'block' : 'none',
                    'menu_active' => request()->is('profile') ? 'active' : '',
                    'is_dropdown' => true,
                    'submenus' => [
                        [
                            'icon' => 'user',
                            'text' => trans('app.personal_information'),
                            'route' => url('profile'),
                            'menu_active' => request()->is('profile') ? 'active' : ''
                        ],
                        // [
                        //     'icon' => 'user',
                        //     'text' => trans('app.update_profile'),
                        //     'route' => url('#'),
                        //     'menu_active' => ''
                        // ],
                         [
                            'icon' => 'user',
                            'text' => trans('app.security_settings'),
                            'route' => url('change-password/' . auth('admin')->user()->uuid),
                            'menu_active' => ''
                        ],
                    ]
                ],
                
                
                [
                    'icon' => 'credit-card',
                    'text' => trans('app.helpdesk'),
                    'route' => url('#'),
                    'active_dropdown' => request()->is('manual') || request()->is('support') ? 'menu-is-opening menu-open' : '',
                    'active_dropdown_menu' => request()->is('manual') || request()->is('support') ? 'block' : 'none',
                    'menu_active' => '',
                    'permission' => 'helpdesk',
                    'is_dropdown' => true,
                    'submenus' => [
                        [
                            'icon' => 'user',
                            'text' => trans('app.manual'),
                            'route' => url('#'),
                            'menu_active' => request()->is('manual') ? 'active' : '',
                            'permission' => 'manual',
                        ],
                        [
                            'icon' => 'support',
                            'text' => trans('app.support'),
                            'route' => url('#'),
                            'menu_active' => request()->is('support') ? 'active' : '',
                            'permission' => 'support',
                        ]
                    ]
                ],
               
                [
                    'icon' => 'power-off',
                    'text' => trans('app.logout'),
                    'route' => route('admin_logout'),
                    'menu_active' => FormFacade::menu_active('logout')
                ]
            ]
        ];
    }
    
    
    
        // Finance Menu
         else if($user->HasRole('Finance')){
          $applicationCount = getAgencyApplicationCount();
             
         $menus = [
            'main_menu' => [
                'title' => trans('app.main_menu'),
                'menus' => [
                    [
                        'icon' => 'home',
                        'text' => trans('app.dashboard'),
                        'route' => url('finance-dashboard'),
                        'menu_active' => request()->is('finance-dashboard') || request()->is('finance-dashboard/*') ? 'active' : ''
                    ],
                    
                      [
                        'icon' => 'line-chart',
                        'text' => trans('app.application'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('finance-user-approve') || request()->is('application-status') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('finance-user-approve') || request()->is('application-status') ? 'block' : 'none',
                        'menu_active' => request()->is('finance-user-approve') || request()->is('application-status') ? 'active' : '',
                        // 'badge_count' => $applicationCount,
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.application_list'),
                                'route' =>  url('finance-user-approve'),
                                'menu_active' => request()->is('finance-user-approve') || request()->is('finance-user-approve/*') ? 'active' : '',
                                'permission' => 'applications.view-list'

                            ],
                            [
                                'icon' => 'line-chart',
                                'text' => trans('app.application_status'),
                                'route' =>  url('application-status'),
                                'menu_active' => request()->is('application-status') || request()->is('application-status/*') ? 'active' : '',
                                'permission' => 'application-status.view-list'

                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.claim_contribution'),
                                'route' => url('claim-list'),
                                'menu_active' => request()->is('claim-contribution') ? 'active' : '',
                                'permission' => 'claim-contribution.view-list'
                            ]
                        ]
                    ],
                    
                    
                    [
                        'icon' => 'money',
                        'text' => trans('app.payments'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('view-receipt') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt')  ? 'block' : 'none',
                        'menu_active' => request()->is('view-receipt') ? 'active' : '',
                        'badge_count' => $applicationCount,
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.list_of_payments'),
                                'route' =>  url('view-receipt'),
                                'menu_active' => request()->is('view-receipt') ? 'active' : '',
                                'permission' => 'payments.view-list'
                            ],
                        ]
                    ],
                  
                    
                    [
                            'icon' => 'line-chart',
                            'text' => trans('app.reports'),
                            'route' => url('#'),
                            'active_dropdown' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') || request()->is('daily-receipt-report-type-finance') || request()->is('receipt-void-report-search' , 'receipt-void-report') || request()->is('cash-book-report-finance') || request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance')  ? 'menu-is-opening menu-open' : '',
                            'active_dropdown_menu' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') || request()->is('daily-receipt-report-type-finance') || request()->is('receipt-void-report-search' , 'receipt-void-report') || request()->is('cash-book-report-finance') || request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'block' : 'none',
                            'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') || request()->is('report-collection-contribution-ditch-by-district-search') ? 'active' : '',
                            'permission' => 'reports.view-list',
                            'is_dropdown' => true,
                            'submenus' => [
                                
                                [
                                'icon' => 'money',
                                'text' => trans('app.report_list_application_ditch_contribution'),
                                'route' =>  url('report-list-all-application-contribution-ditch-search'),
                                'menu_active' => request()->is('report-list-all-application-contribution-ditch-search' ,'report-list-all-application-contribution-ditch') ? 'active' : '',
                                'permission'=> 'report.account.type'
                                ],
                                [
                                'icon' => 'money',
                                'text' => trans('app.report_collection_contribution_ditch_by_district'),
                                'route' =>  url('report-collection-contribution-ditch-by-district-search'),
                                'menu_active' => request()->is('report-collection-contribution-ditch-by-district-search','report-collection-contribution-ditch-by-district') ? 'active' : '',
                                'permission' => 'report.district'
                                ],
                                [
                                'icon' => 'money',
                                'text' => trans('app.collection_payment_report'),
                                'route' =>  url('#'),
                                'active_dropdown' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'menu-is-opening menu-open' : '',
                                'active_dropdown_menu' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance')  ? 'block' : 'none',
                                'menu_active' => request()->is('collectors-statement-report') || request()->is('approved-statement') || request()->is('task-not-completed-finance') ? 'active' : '',
                                'permission' => 'collection-payment.view-list',
                                'is_dropdown' => true,
                                'submenus' => [ // Second-level submenu
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.generate_a_collectors_statement'),
                                                    'route' =>  url('collectors-statement-report'),
                                                    'menu_active' => request()->is('collectors-statement-report') ? 'active' : '',
                                                    'permission' => 'generate_collector_statement'
                                                ],
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.assignments_not_taken'),
                                                    'route' =>  url('approved-statement'),
                                                    'menu_active' => request()->is('approved-statement') ? 'active' : '',
                                                    'permission' => 'approved_statement'
                                                ],
                                                // [
                                                //     'icon' => 'file-text',
                                                //     'text' => trans('app.unfinished_tasks'),
                                                //     'route' =>  url('task-not-completed-finance'),
                                                //     'menu_active' => request()->is('task-not-completed-finance') ? 'active' : '',
                                                // ]
                                                
                                            ],
                                
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.daily_payment_receipt_report_by'),
                                'route' =>  url('daily-receipt-report-type-finance'),
                                'menu_active' => request()->is('daily-receipt-report-type-finance') ? 'active' : '',
                                'permission' => 'daily-payment-receipt.view-list',
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.summary_of_overall_receipt_report'),
                                'route' =>  url('payment-summary-report-search'),
                                'menu_active' => request()->is('receipt-void-report' ,'receipt-void-report') ? 'active' : '',
                                'permission'  => 'payment.summary.report'

                            ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.receipt_void_report'),
                            //     'route' =>  url('receipt-void-report-search'),
                            //     'menu_active' => request()->is('receipt-void-report' ,'receipt-void-report') ? 'active' : '',

                            // ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.checkbook_cash_book_report_by_date'),
                            //     'route' =>  url('cash-book-report-finance'),
                            //     'menu_active' => request()->is('cash-book-report-finance') ? 'active' : '',
                            // ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.contribution_payment_report'),
                                'route' =>  url('claim-contribution-report-search'),
                                'menu_active' => request()->is('') ? 'active' : '',
                                'permission' => 'contribution-payment.view-list',
                            ],
                            // [
                            //     'icon' => 'money',
                            //     'text' => trans('app.treasury_eceipts'),
                            //     'route' =>  url('treasury-receipts'),
                            //     'menu_active' => Request::is('treasury-receipts') ? 'active' : null
                            // ],
                            
                        ]
                    ],
                    
                    [
                        'icon' => 'user',
                        'text' => trans('app.profile'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('profile') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('profile')  ? 'block' : 'none',
                        'menu_active' => request()->is('profile')  ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                            'icon' => 'user',
                            'text' => trans('app.personal_information'),
                            'route' => url('profile'),
                            'menu_active' => request()->is('profile')  ? 'active' : '',
                            ],
                            // [
                            // 'icon' => 'user',
                            // 'text' => trans('app.update_profile'),
                            // 'route' => url('#'),
                            // 'menu_active' => request()->is('profile')  ? 'active' : '',
                            // ],
                        //      [
                        //         'icon' => 'user',
                        //         'text' => trans('app.security_settings'),
                        //         'route' => url('change-password/' . auth('admin')->user()->uuid),
                        //         'menu_active' => ''
                        //   ],
                        ]
                    ],
                    [
                        'icon' => 'credit-card',
                        'text' => trans('app.helpdesk'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('#') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('#')  ? 'block' : 'none',
                        'menu_active' => request()->is('#')  ? 'active' : '',
                        'permission' => 'helpdesk',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'user',
                                'text' => trans('app.manual'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('#')  ? 'active' : '',
                                'permission' => 'manual',
                            ],
                            [
                                'icon' => 'support',
                                'text' => trans('app.support'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('#')  ? 'active' : '',
                                'permission' => 'support',
                            ]
                        ]
                    ],
                ]
            ]
        ];
        // if(hasPermission('setting.view')){
        //     $menus['main_menu']['menus'][] = [
        //         'icon' => 'cogs',
        //         'text' => trans('app.settings'),
        //         'route' => url('settings/company'),
        //         'menu_active' => FormFacade::menu_active('settings')
        //     ];
        // }
        
        $menus['account_menu'] = [
            'title' => trans('app.account_menu'),
            'menus' => [
                [
                    'icon' => 'fa fa-search',
                    'text' => trans('app.filter_search'),
                    'route' => url('search'),
                    'menu_active' => request()->is('search') || request()->is('search/*') ? 'active' : '',
                    'permission' => 'filter-search'
                ],
               
                // [
                //         'icon' => 'credit-card',
                //         'text' => trans('app.helpdesk'),
                //         'route' => url('#'),
                //         'active_dropdown' => active_dropdown_menu('expenses') ? 'menu-is-opening menu-open' : '',
                //         'active_dropdown_menu' => active_dropdown_menu('expenses') ? 'block' : 'none',
                //         'menu_active' => FormFacade::menu_active('expenses').' '.FormFacade::menu_active('expenses/category'),
                //         'is_dropdown' => true,
                //         'submenus' => [
                //             [
                //                 'icon' => 'user',
                //                 'text' => trans('app.manual'),
                //                 'route' =>  url('#'),
                //                 'menu_active' => Request::is('expenses/list') ? 'active' : null
                //             ],
                //             [
                //                 'icon' => 'support',
                //                 'text' => trans('app.support'),
                //                 'route' =>  url('#'),
                //                 'menu_active' => Request::is('expenses/category') ? 'active' : null
                //             ]
                //         ]
                //     ],
                    
                    // [
                    //     'icon' => 'line-chart',
                    //     'text' => trans('app.reports'),
                    //     'route' => url('reports'),
                    //     'menu_active' => FormFacade::menu_active('reports')
                    // ],
                [
                    'icon' => 'power-off',
                    'text' => trans('app.logout'),
                    'route' => route('admin_logout'),
                    'menu_active' => FormFacade::menu_active('logout')
                ]
            ]
        ];
    }
        //Finance-Reviewer Menu
        else if($user->HasRole('reviewer')){
        $menus = [
            'main_menu' => [
                'title' => trans('app.main_menu'),
                'menus' => [
                    [
                        'icon' => 'home',
                        'text' => trans('app.dashboard'),
                        'route' => url('home-reviewer'),
                        'menu_active' => request()->is('home-reviewer') || request()->is('home-reviewer/*') ? 'active' : ''
                    ],
                      [
                        'icon' => 'line-chart',
                        'text' => trans('app.application'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('user-approve') || request()->is('application-status')  ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('user-approve') || request()->is('application-status')  ? 'block' : 'none',
                        'menu_active' => request()->is('user-approve') || request()->is('application-status')  ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'list',
                                'text' => trans('app.application_list'),
                                'route' =>  url('user-approve'),
                                'menu_active' =>  request()->is('user-approve') || request()->is('user-approve/*') ? 'active' : '',
                                'permission' => 'applications.view-list',
                            ],
                            [
                                'icon' => 'line-chart',
                                'text' => trans('app.application_status'),
                                'route' =>  url('application-status'),
                                'menu_active' => request()->is('application-status') || request()->is('application-status/*') ? 'active' : '',
                                'permission' => 'application-status.view-list',
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.claim_contribution'),
                                'route' => url('claim-list'),
                                'menu_active' => request()->is('claim-contribution') ? 'active' : '',
                                'permission' => 'claim-contribution.view-list'
                            ]
                        ]
                    ],
                    
                    
                    [
                        'icon' => 'money',
                        'text' => trans('app.payments'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('view-receipt') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('view-receipt') ? 'block' : 'none',
                        'menu_active' => request()->is('view-receipt')  ? 'active' : '',
                        'permission' => 'payments.view-list',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.list_of_payments'),
                                'route' =>  url('view-receipt'),
                                'menu_active' => request()->is('view-receipt')  ? 'active' : '',
                            ],
                        ]
                    ],
                  
                    
                     [
                            'icon' => 'line-chart',
                            'text' => trans('app.reports'),
                            'route' => url('#'),
                            'active_dropdown' => request()->is('new-assignment-reviewer') || request()->is('daily-receipt-report-type-reviewer') || request()->is('cash-book-report-reviewer') ? 'menu-is-opening menu-open' : '',
                            'active_dropdown_menu' => request()->is('new-assignment-reviewer') || request()->is('daily-receipt-report-type-reviewer') || request()->is('cash-book-report-reviewer') ? 'block' : 'none',
                            'menu_active' => request()->is('new-assignment-reviewer') || request()->is('daily-receipt-report-type-reviewer') || request()->is('cash-book-report-reviewer')  ? 'active' : '',
                            'permission' => 'reports.view-list',
                            'is_dropdown' => true,
                            'submenus' => [
                            [
                                'icon' => 'money',
                                'text' => trans('app.collection_payment_report'),
                                'route' =>  url('#'),
                                'active_dropdown' => request()->is('new-assignment-reviewer') ? 'menu-is-opening menu-open' : '',
                                'active_dropdown_menu' => request()->is('new-assignment-reviewer') ? 'block' : 'none',
                                'menu_active' => request()->is('new-assignment-reviewer')  ? 'active' : '',
                                'permission' => 'collection-payment.view-list',
                                'submenus' => [ // Second-level submenu
                                                [
                                                    'icon' => 'file-text',
                                                    'text' => trans('app.assignments_not_taken'),
                                                    'route' =>  url('new-assignment-reviewer'),
                                                    'menu_active' => request()->is('new-assignment-reviewer')  ? 'active' : '',
                                                ],
                                                // [
                                                //     'icon' => 'file-text',
                                                //     'text' => trans('app.approved_statement'),
                                                //     'route' =>  url('approved-statement'),
                                                //     'menu_active' => request()->is('approved-statement') ? 'active' : '',
                                                // ]
                                                
                                            ],
                                
                                
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.daily_receipt_payment_report'),
                                'route' =>  url('daily-receipt-report-type-reviewer'),
                                'menu_active' => request()->is('daily-receipt-report-type-reviewer')  ? 'active' : '',
                                'permission' => 'daily-payment-receipt.view-list',
                            ],
                            [
                                'icon' => 'money',
                                'text' => trans('app.checkbook_cash_book_report_by_date'),
                                'route' =>  url('cash-book-report-reviewer'),
                                'menu_active' => request()->is('cash-book-report-reviewer')  ? 'active' : '',
                            ],
                            
                            [
                                'icon' => 'money',
                                'text' => trans('app.contribution_payment_report'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('#')  ? 'active' : '',
                                'permission' => 'contribution-payment.view-list',
                            ],
                            
                        ]
                    ],
                    [
                        'icon' => 'user-md',
                        'text' => trans('app.profile'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('profile') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('profile') ? 'block' : 'none',
                        'menu_active' => request()->is('profile')  ? 'active' : '',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                            'icon' => 'user-md',
                            'text' => trans('app.personal_information'),
                            'route' => url('profile'),
                            'menu_active' => request()->is('profile')  ? 'active' : '',
                            ],
                            [
                            'icon' => 'user-md',
                            'text' => trans('app.update_profile'),
                            'route' => url('#'),
                            'menu_active' => request()->is('#')  ? 'active' : '',
                            ],
                            [
                                'icon' => 'user',
                                'text' => trans('app.security_settings'),
                                'route' => url('change-password/' . auth('admin')->user()->uuid),
                                'menu_active' => ''
                           ],
                        ]
                    ],
                    [
                        'icon' => 'credit-card',
                        'text' => trans('app.helpdesk'),
                        'route' => url('#'),
                        'active_dropdown' => request()->is('#') ? 'menu-is-opening menu-open' : '',
                        'active_dropdown_menu' => request()->is('#') ? 'block' : 'none',
                        'menu_active' => request()->is('#')  ? 'active' : '',
                        'permission' => 'helpdesk',
                        'is_dropdown' => true,
                        'submenus' => [
                            [
                                'icon' => 'user',
                                'text' => trans('app.manual'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('#')  ? 'active' : '',
                                'permission' => 'manual',
                            ],
                            [
                                'icon' => 'support',
                                'text' => trans('app.support'),
                                'route' =>  url('#'),
                                'menu_active' => request()->is('#')  ? 'active' : '',
                                'permission' => 'support',
                            ]
                        ]
                    ],
                ]
            ]
        ];
        // if(hasPermission('setting.view')){
        //     $menus['main_menu']['menus'][] = [
        //         'icon' => 'cogs',
        //         'text' => trans('app.settings'),
        //         'route' => url('settings/company'),
        //         'menu_active' => FormFacade::menu_active('settings')
        //     ];
        // }
        
        $menus['account_menu'] = [
            'title' => trans('app.account_menu'),
            'menus' => [
                [
                    'icon' => 'fa fa-search',
                    'text' => trans('app.filter_search'),
                    'route' => url('/search'),
                    'menu_active' => request()->is('search') || request()->is('search/*') ? 'active' : '',
                    'permission' => 'filter-search',
                ],
               
                // [
                //         'icon' => 'credit-card',
                //         'text' => trans('app.helpdesk'),
                //         'route' => url('#'),
                //         'active_dropdown' => active_dropdown_menu('expenses') ? 'menu-is-opening menu-open' : '',
                //         'active_dropdown_menu' => active_dropdown_menu('expenses') ? 'block' : 'none',
                //         'menu_active' => FormFacade::menu_active('expenses').' '.FormFacade::menu_active('expenses/category'),
                //         'is_dropdown' => true,
                //         'submenus' => [
                //             [
                //                 'icon' => 'user',
                //                 'text' => trans('app.manual'),
                //                 'route' =>  url('#'),
                //                 'menu_active' => Request::is('expenses/list') ? 'active' : null
                //             ],
                //             [
                //                 'icon' => 'support',
                //                 'text' => trans('app.support'),
                //                 'route' =>  url('#'),
                //                 'menu_active' => Request::is('expenses/category') ? 'active' : null
                //             ]
                //         ]
                //     ],
                    
                    // [
                    //     'icon' => 'line-chart',
                    //     'text' => trans('app.reports'),
                    //     'route' => url('reports'),
                    //     'menu_active' => FormFacade::menu_active('reports')
                    // ],
                [
                    'icon' => 'power-off',
                    'text' => trans('app.logout'),
                    'route' => route('admin_logout'),
                    'menu_active' => FormFacade::menu_active('logout')
                ]
            ]
        ];
    }
    else{
        
        // dd($user);
        $menus=[];
    }
        return $menus;
    }
}
if(! function_exists('getSettingMenus')) {
    function getSettingMenus(): array
    {
        $menus = [
            [
                'text' => trans('app.company'),
                'active_class' => Request::is('settings/company') ? 'active' : '',
                'route' => route('settings.company.index'),
                'is_visible' => hasPermission('setting.view')
            ],
            [
                'text' => trans('app.invoice'),
                'active_class' => Request::is('settings/invoice') ? 'active' : '',
                'route' => route('settings.invoice.index'),
                'is_visible' => hasPermission('invoice-setting.view')
            ],
            [
                'text' => trans('app.email'),
                'active_class' => Request::is('settings/email') ? 'active' : '',
                'route' => route('settings.email.index'),
                'is_visible' => hasPermission('email-setting.view')
            ],
            [
                'text' => trans('app.estimate'),
                'active_class' => Request::is('settings/estimate') ? 'active' : '',
                'route' => route('settings.estimate.index'),
                'is_visible' => hasPermission('estimate-setting.view')
            ],
            [
                'text' => trans('app.tax'),
                'active_class' => Request::is('settings/tax') ? 'active' : '',
                'route' => route('settings.tax.index'),
                'is_visible' => hasPermission('tax-setting.view-all')
            ],
            [
                'text' => trans('app.templates'),
                'active_class' => Request::is('settings/templates/*') ? 'active' : '',
                'route' => route('settings.template.show','invoice'),
                'is_visible' => hasPermission('template.view')
            ],
            [
                'text' => trans('app.numbering'),
                'active_class' => Request::is('settings/number') ? 'active' : '',
                'route' => route('settings.number.index'),
                'is_visible' => hasPermission('number-setting.view')
            ],
            [
                'text' => trans('app.payment_methods'),
                'active_class' => Request::is('settings/payment') ? 'active' : '',
                'route' => route('settings.payment.index'),
                'is_visible' => hasPermission('payment-method.view-all')
            ],
            [
                'text' => trans('app.payment_gateway'),
                'active_class' => Request::is('settings/gateways') ? 'active' : '',
                'route' => route('settings.gateways.index'),
                'is_visible' => hasPermission('payment-gateway.view')
            ],
            [
                'text' => trans('app.currency'),
                'active_class' => Request::is('settings/currency') ? 'active' : '',
                'route' => route('settings.currency.index'),
                'is_visible' => hasPermission('currency.view-all')
            ],
            [
                'text' => trans('app.roles'),
                'active_class' => Request::is('settings/roles') ? 'active' : '',
                'route' => route('settings.role.index'),
                'is_visible' => hasPermission('role.view-all')
            ],
            [
                'text' => trans('app.permissions'),
                'active_class' => Request::is('settings/permissions') ? 'active' : '',
                'route' => route('settings.permission.index'),
                'is_visible' => hasPermission('permission.view-all')
            ],
            [
                'text' => trans('app.language_manager'),
                'active_class' => Request::is('settings/translations') || Request::is('translations') || Request::is('settings/translations/*') || Request::is('translations/*') ? 'active' : '',
                'route' => route('settings.translation.index'),
                'is_visible' => hasPermission('locale.view-all')
            ]

        ];
        return $menus;
    }
}
if(! function_exists('uploadFile')){
    function uploadFile($file, $path, $resize=false, $width=null, $height=null): string
    {
        $filename = time() . '.' . $file->extension();
        makeDirectoryIfNotExist($path);
        $file->move($path, $filename);
        if($resize && !is_null($width)){
            $height = is_null($height) ? $width : $height;
            $manager = new Image(new Driver());
            $manager->read(sprintf($path.'%s', $filename))
                ->scale($width, $height)
                ->save();
        }
        return $path.$filename;
    }
}
function message(){
    $notification = session()->pull('flash_notification')[0];
    $message_type = $notification->level;
    $msghtml = '<div class="alert alert-'.$message_type .'">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Message: </strong>'.$notification->message.'</div>';
    return $msghtml;
}
function display_form_errors($errors){
    $error_list = '';
    foreach($errors->all() as $error){
        $error_list .= '- '.$error.'<br/>';
    }
    $errorsHtml = '<div class="alert alert-danger">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   '.$error_list.'</div>';
    return $errorsHtml;
}
function show_btn($route, $id){
    $btn = '<a class="btn btn-info btn-xs" href="'.route($route, $id).'" data-rel="tooltip" data-placement="top" title="'.trans("app.view").'"><i class="fa fa-eye"></i></a>';
    return $btn;
}
function edit_btn($route, $id){
    $btn = '<a class="btn btn-success btn-xs" data-toggle="ajax-modal" data-rel="tooltip" data-placement="top" href="'.route($route, $id).'" title="'.trans("app.edit").'"><i class="fa fa-pencil"></i></a>';
    return $btn;
}
function delete_btn($route, $id){
    $btn = Form::open(array("method"=>"DELETE", "route" => array($route, $id), 'class' => 'form-inline', 'style'=>'display:inline')).'
           <a class="btn btn-danger btn-xs btn-delete" data-rel="tooltip" data-placement="top" title="'.trans('app.delete').'"><i class="fa fa-trash"></i></a>'.Form::close();
    return $btn;
}
function format_amount($amount,$symbol=null,$show_symbol=true){
    $settings = App\Models\Setting::first();
    $thousand_separator = $settings && $settings->thousand_separator != '' ? $settings->thousand_separator : ',' ;
    $decimal_point = $settings && $settings->decimal_separator != '' ? $settings->decimal_separator : '.' ;
    $decimals = $settings && $settings->decimals != '' ? $settings->decimals : 2;
    $amount = number_format(round($amount,$decimals),$decimals,$decimal_point,$thousand_separator);
    if($show_symbol){
        $amount = $settings && $settings->currency_position === 0 ?  $amount.' '.$symbol : $symbol.' '.$amount;
    }
    return $amount;
}
function format_date($date){
    $settings = App\Models\Setting::first();
    $date_format = $settings && $settings->date_format != '' ? $settings->date_format : 'd-m-Y';
    return date($date_format, strtotime($date));
}
function mask_input($number){
    if($number) {
        return str_repeat("*", strlen($number) - 5) . substr($number, -5);
    }
}
function get_company_name(){
    $settings = App\Models\Setting::first();
    $company_name = $settings && $settings->name != '' ? Str::limit($settings->name, 20, '')  : 'Classic Invoicer';
    return $company_name;
}
function get_setting_value($key){
    $settings = App\Models\Setting::first();
    return $settings && $settings->{$key} != '' ? $settings->{$key}  : '';
}
function get_role($key){
    $settings = App\Models\Role::where("uuid",$key)->first();
    return  $settings->name??"";
}
function get_languages(){
    return \DB::table('locales')->where('status', 1)->get();
}
function get_current_language($lang){
    return \DB::table('locales')->where('short_name', $lang)->first();
}
function get_default_language(){
    $language = \DB::table('locales')->where('default', 1)->where('status', 1)->first();
    return $language;
}
function current_language(){
    if(Session::has('applocale')){
        $current_lang = get_current_language(Session::get('applocale'));
        if(!$current_lang){
            $current_lang = get_default_language();
            if(!$current_lang){
                $current_lang = get_current_language(App::getLocale());
            }
        }
    }
    else{
        $current_lang = get_default_language();
        if(!$current_lang){
            $current_lang = get_current_language(App::getLocale());
        }
    }
    return [
        'lang'=>$current_lang,
        'flag'=> $current_lang && $current_lang->flag != '' ? $current_lang->flag : 'placeholder_Flag.jpg'
    ];
}
function is_verified(){
    $settings = App\Models\Setting::first();
    $purchase_code = $settings ? $settings->purchase_code : '';
    if($purchase_code != '' && config('services.license.is_verified')){
        return true;
    }
    return false;
}
function form_buttons(){
    $buttons = '<button type="submit" data-rel="tooltip" data-placement="top" title="'.trans('app.save').'" class="btn btn-sm btn-success"><i class="fa fa-save"></i> '.trans("app.save").'</button>
                <button type="button" data-rel="tooltip" data-placement="top" title="'.trans('app.close').'" data-dismiss="modal" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i> '.trans("app.close").'</button>';
    return $buttons;
}
function yes_no_select(){
    return [
        '0' => trans('app.no'),
        '1' => trans('app.yes')
    ];
}
function statuses(){
    return array(
        '0' => array(
            'status' => 'unpaid',
            'label' => trans('app.unpaid'),
            'class' => 'badge-warning'
        ),
        '1' => array(
            'status' => 'partially_paid',
            'label' => trans('app.partially_paid'),
            'class' => 'badge-primary'
        ),
        '2' => array(
            'status' => 'paid',
            'label' => trans('app.paid'),
            'class' => 'badge-success'
        ),
        '3' => array(
            'status' => 'overdue',
            'label' => trans('app.overdue'),
            'class' => 'badge-danger'
        )
    );
}
function getStatus($field, $value){
    $statuses = statuses();
   foreach($statuses as $key => $status){
       if ( $status[$field] === $value )
           return $key;
   }
   return false;
}
function hasPermission($permission, $show_msg = false): bool
{
    $user = auth('admin')->check() && auth('admin')->user() ? auth('admin')->user() : null;
    if(!is_null($user) && ($user->hasPermission($permission) || $user->HasRole('admin'))){
        return true;
    }
    if($show_msg) {
        flash()->error(trans('app.dont_have_permission'));
    }
    return false;
}
function parse_template($object, $body){
    if (preg_match_all('/\{(.*?)\}/', $body, $template_vars)){
        $replace ='';
        foreach ($template_vars[1] as $var){
            switch (trim($var)){
                case 'invoice_number':
                    if(isset($object->invoice->invoice_no)){
                        $replace = $object->invoice->invoice_no;
                    }
                    break;
                case 'invoice_amount':
                    if(isset($object->invoice->totals['grandTotal'])){
                        $replace = $object->invoice->currency.$object->invoice->totals['grandTotal'];
                    }
                    break;
                case 'client_name':
                    if(isset($object->client->name)){
                        $replace = $object->client->name;
                    }
                    break;
                case 'client_email':
                    if(isset($object->client->email)){
                        $replace = $object->client->email;
                    }
                    break;
                case 'client_number':
                    if(isset($object->client->client_no)){
                        $replace = $object->client->client_no;
                    }
                    break;
                case 'company_name':
                    if(isset($object->settings->name)){
                        $replace = $object->settings->name;
                    }
                    break;
                case 'company_email':
                    if(isset($object->settings->email)){
                        $replace = $object->settings->email;
                    }
                    break;
                case 'company_website':
                    if(isset($object->settings->website)){
                        $replace = $object->settings->website;
                    }
                    break;
                case 'contact_person':
                    if(isset($object->settings->contact)){
                        $replace = $object->settings->contact;
                    }
                    break;
                case 'username':
                    if(isset($object->user->email)){
                        $replace = $object->user->email;
                    }
                    break;
                case 'password':
                    if(isset($object->user->password)){
                        $replace = $object->user->password;
                    }
                    break;
                case 'login_link':
                    if(isset($object->user->login_link)){
                        $replace = $object->user->login_link;
                    }
                    break;
                default:
                    $replace = '';
            }
            $body = str_replace('{' . $var . '}', $replace, $body);
        }
    }
    return $body;
}
function array_multi_subsort($array, $subkey){
    $b = array(); $c = array();
    foreach ($array as $k => $v) {
        $b[$k] = strtolower($v[$subkey]);
    }
    asort($b);
    foreach ($b as $key => $val) {
        $c[] = $array[$key];
    }
    return $c;
}
function currency_convert($from_id,$amount){
    $default_currency = App\Models\Currency::where('default_currency',1)->first();
    $from_currency = App\Models\Currency::find($from_id);
    if($default_currency && $from_currency && is_numeric($from_currency->exchange_rate) && is_numeric($default_currency->exchange_rate)){
        $default_currency_value = $amount / $from_currency->exchange_rate * $default_currency->exchange_rate;
        return $default_currency_value;
    }
    return $amount;
}
function defaultCurrency($symbol = false){
    $currency = App\Models\Currency::where('default_currency',1)->first();
    if($symbol){
        return $currency ? $currency->symbol : '$';
    }
    return $currency ? $currency->code.'('.$currency->symbol.')' : 'USD($)';
}
function defaultCurrencyCode(){
    $currency = App\Models\Currency::where('default_currency',1)->first();
    return $currency ? $currency->code : 'USD';
}
function getCurrencyId($symbol){
    $currency_code = explode("(", $symbol, 2)[0];
    $currency = App\Models\Currency::where('code',$currency_code)->first();
    return $currency->uuid ?? null;
}
function saveConfiguration($values, $configFilename = '.env') {
    if (empty($values) || !is_array($values)) {
        return false;
    }
    $envFile = base_path($configFilename);
    if (!File::exists($envFile)) {
        $existingConfig = [];
    } else {
        $existingConfig = file($envFile);
    }
    $configs = [];
    foreach ($existingConfig as $config) {
        if (!empty(str_replace(' ', '', $config))) {
            $config = str_replace([
                "\r",
                "\n"
            ], ['', ''], $config);
            $configParts = explode('=', $config, 2);
            if (!empty($configParts[1])) {
                if (!array_key_exists($configParts[0], $values)) {
                    $configs[] = $configParts[0].'='.$configParts[1];
                }
            }
        }
    }
    foreach ($values as $key => $value) {
        $value = str_replace('"', '\"', $value);
        if (strpos($values[$key], ' ') !== false) {
            $configs[] = $key.'="'.$value.'"';
        } else {
            $configs[] = $key.'='.$value;
        }
    }
    File::put($envFile, implode("\n", $configs));
    Artisan::call('config:clear');
    return true;
}

function image_url($image){
    return File::exists(config('app.images_path').$image) ? asset(config('app.images_path').$image) : asset($image);
}
function base64_img($image): string
{
    $image_path = $image;
    $type = pathinfo($image_path, PATHINFO_EXTENSION);
    $data = file_get_contents($image_path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}
function float_subtraction($num_1, $num_2): float|int
{
    return ((floor($num_1 * 100) - floor($num_2 * 100)) / 100);
}
function btnCreate($route = '', $mode = 'ajax-modal',$text = 'Create new record', $iconCreate='plus'){
    return '<a href="'.route($route).'" class="btn btn-primary btn-xs" data-toggle="'.$mode.'" data-loading-text="<i class=\'fa fa-spin fa-spinner\'></i> Processing">
        <i class="fa fa-'.$iconCreate.'"></i> '.$text.'
    </a>';
}
function active_dropdown_menu($prefix): bool
{
    return request()->route() && request()->route()->getPrefix() == $prefix;
}
function recur_cycles(){
    return [
      '1' => trans('app.monthly'),
      '2' => trans('app.quarterly'),
      '3' => trans('app.semi_annually'),
      '4' => trans('app.annually'),
    ];
}
function status_select_array(){
    $status_array = [];
    foreach (statuses() as $key=>$status){
        $status_array[$key] = $status['label'];
    }
    return $status_array;
}

function getAdminStaffApplicationCount() {
    try {
        // Count applications that haven't been forwarded by admin staff yet
        return \App\Models\Application::whereIn('status', ['pending'])
            ->whereNull('forwarded_by_admin_staff') 
            ->count();
            
    } catch (\Exception $e) {
        \Log::error('Error getting admin staff application count: ' . $e->getMessage());
        return 0;
    }
}

function getAdminApproverApplicationCount() {
    try {
        return \App\Models\Application::whereIn('status', ['pending'])
            ->where('forwarded_by_admin_staff', 1) 
            ->count();
            
    } catch (\Exception $e) {
        \Log::error('Error getting admin staff application count: ' . $e->getMessage());
        return 0;
    }
}


function getClaimContributionPendingCount() {
    try {
        return \App\Models\ClaimContribution::where('status', 'pending')->count();
    } catch (\Exception $e) {
        \Log::error('Error getting claim contribution pending count: ' . $e->getMessage());
        return 0;
    }
}


function getAgencyApplicationCount() {
    try {
        return \App\Models\Application::join('client_register', 'applications.user_id', '=', 'client_register.client_id')
            ->join('payments', 'applications.id', '=', 'payments.application_id')
            ->where('client_register.accountType', 3)   // agency users
            ->where('applications.status', 'approved')  // approved applications
            ->where('payments.payment_status', 'in_review')     // payment status is in_review
            ->count();
    } catch (\Exception $e) {
        \Log::error('Error getting agency application count: ' . $e->getMessage());
        return 0;
    }
}


function getDepositSubmitNotificationCount() {
    try {
        return \DB::table('notifications')
            ->where('type', 'App\Notifications\DepositReceiptSubmitted')
            ->whereNull('read_at') 
            ->count();
    } catch (\Exception $e) {
        \Log::error('Error getting deposit submit notification count: ' . $e->getMessage());
        return 0;
    }
}



function install_minimum_requirements(){
    return [
        'php' => [
            'check' => version_compare(phpversion(),"8.0.0",">="),
            'success' => 'PHP Version Compatible',
            'error' => 'PHP Version Not Compatible'
        ], 
        'BCMath' => [
            'check' => extension_loaded('BCMath'),
            'success' => 'BCMath Extension Enabled',
            'error' => 'BCMath Extension Disabled'
        ], 
        'Ctype' => [
            'check' => extension_loaded('Ctype'),
            'success' => 'Ctype Extension Enabled',
            'error' => 'Ctype Extension Disabled'
        ], 
        'openssl' => [
            'check' => extension_loaded('openssl'),
            'success' => 'OpenSSL Extension Enabled',
            'error' => 'OpenSSL Extension Disabled'
        ], 
        'mbstring' => [
            'check' => extension_loaded('mbstring'),
            'success' => 'Mbstring Extension Enabled',
            'error' => 'Mbstring Extension Disabled'
        ], 
        'tokenizer' => [
            'check' => extension_loaded('tokenizer'),
            'success' => 'Tokenizer Extension Enabled',
            'error' => 'Tokenizer Extension Disabled'
        ], 
        'XML' => [
            'check' => extension_loaded('XML'),
            'success' => 'XML Extension Enabled',
            'error' => 'XML Extension Disabled'
        ], 
        'images_folder' => [
            'check' => is_writable('assets/images'),
            'success' => 'ASSETS/IMAGES folder is Writable',
            'error' => 'ASSETS/IMAGES folder is not Writable'
        ], 
    ];
}








