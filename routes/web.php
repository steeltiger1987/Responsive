<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['locale']], function(){

    Route::get('/', function () {

        if(\Illuminate\Support\Facades\App::isLocale('en')){
            return view('welcome_en');
        } else {
            return view('welcome');
        }
    });

    Route::get('/terms-and-conditions.html', function(){
        return view('public.terms-and-conditions');
    });

    Route::get('/privacy-policy.html', function(){
        return view('public.privacy-policy');
    });

    Route::get('/freelancers.html', function(){
        return view('public.privacy-policy');
    });

    Route::get('/contact-us', function(){
        return redirect('/');
    });

    Route::get('/index.html', function(){
        return redirect('/');
    });

    Auth::routes();

    /*Account*/
    Route::group(['middleware' => ['auth']], function () {
        Route::match(['get', 'post'], '/account/billing-info', 'AccountsController@billingInfo');
        Route::match(['get', 'post'], '/account/billing-info/first', 'AccountsController@billingInfoFirst');

        Route::get('/account/register/step/2', 'MoversController@showRegisterSecondStep');
        Route::post('/account/register/step/2', 'MoversController@finishRegistration');
        Route::get('/account/details', 'AccountsController@personalDetailsForm');
        Route::post('/account/details/save', 'AccountsController@personalDetailsSave');
        Route::get('/account', 'AccountsController@account')->middleware('mover_registration');
        Route::get('/account/preferences', 'PreferencesController@home');
        Route::post('/preferences/account/action', 'PreferencesController@action');
        Route::get('/account/mover/add-car', 'MoversController@addCarForm');
        Route::post('/account/mover/add-car', 'MoversController@addCar');

        Route::get('/account/mover/car/delete/{id}', 'MoversController@deleteCar');
        Route::get('/account/mover/car/edit/{id}', 'MoversController@carEdit');
        Route::post('/account/mover/car/edit/{id}', 'MoversController@updateCar');
        Route::get('/movers/profile/{id}/{order_id?}', 'MoversController@showProfile');

        Route::get('/orders/prolong/{id}', 'OrdersController@prolongOrder');
        Route::match(['get', 'post'], '/orders/cancel/{id}', 'OrdersController@cancelOrder');
        Route::get('/orders/show/{id?}', 'OrdersController@show');
        Route::get('/orders/bid/{id}', 'OrdersController@showBidForm')->middleware(['billing_info', 'mover_registration']);
        Route::post('/orders/bid/create', 'OrdersController@makeBid');
        Route::match(['get', 'post'], '/orders/bid/edit/{id}', 'OrdersController@editBid');
        Route::get('/orders/bid/{bid_id}/cancel', 'OrdersController@cancelBid');
        Route::post('/orders/create_job', 'JobsController@createJob');
        Route::get('/orders/{order_id}/mover/{mover_id}/bid/{bid_id}/approve', 'JobsController@approveOrder');
        Route::get('/review/{job_id}', 'JobsController@reviewJob');
        Route::get('/job/end/{job_id}', 'JobsController@endJob');
        Route::get('/jobs', 'JobsController@show');
    });

    Route::get('/items/modal/{id?}', 'OrdersController@itemsModal');

    /*Order create*/
    Route::match(['get', 'post'], '/orders/create/', 'OrdersController@create');

    /*Registration*/
    Route::get('/client/register', 'Auth\RegisterController@showForm');
    Route::get('/mover/register', 'Auth\RegisterController@showForm');

    Route::post('/client/register', 'Auth\RegisterController@register');
    Route::post('/mover/register', 'Auth\RegisterController@register');

    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('register', 'Auth\RegisterController@showSelectPage');
});


Route::group(['prefix' => 'payments'], function () {
    Route::get('success', 'PaymentsController@success');
    Route::get('cancel', 'PaymentsController@cancel');
    Route::get('error', 'PaymentsController@error');
    Route::get('notification', 'PaymentsController@notification');
});







/*
 * AJAX CALLS
 * This part is for calling ajax.
 **/

Route::group(['prefix' => 'ajax'], function () {
    //Create item
    Route::post('orders/item/create', 'OrdersController@createItemAjax');
    Route::post('orders/item/delete/{item_id}', 'OrdersController@deleteItemAjax');
    Route::post('orders/item/upload', 'OrdersController@uploadFileAjax');
    Route::match(['post', 'get'], 'order/{id}/items', 'OrdersController@getItemsAjax');
    Route::post('orders/prolong', 'OrdersController@updateExpiration');
    Route::post('orders/review', 'MoversController@review');

    Route::post('preferences/region/remove', 'PreferencesController@removeRegion');
    Route::post('preferences/region/add', 'PreferencesController@addRegion');

});

/**
 * Languages
 */

Route::get('/en', function(){
    Session::set('locale', 'en');

    return redirect('/');
});

Route::get('/cz', function(){
    Session::set('locale', 'cz');

    return redirect('/');
});



/*
 * Admin
 */


Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'allow_if_admin'], function () {
        Route::get('/', 'Admin\IndexController@index');
        Route::get('/customer-list', 'Admin\IndexController@customers_list');
        Route::get('/movers-list', 'Admin\IndexController@movers_list');
        Route::get('/orders-list', 'Admin\IndexController@orders_list');
        Route::get('/payments', 'Admin\IndexController@payments');
        Route::get('/settings', 'Admin\IndexController@settings');
        Route::post('/settings/save', 'Admin\IndexController@settingsSave');
        Route::get('/account/mover/topup', 'Admin\IndexController@topUp');
        Route::post('/login', 'Admin\IndexController@login');
        Route::post('/account/mover/make/payment', 'Admin\IndexController@makePayment');
        Route::get('/mover/{id}', 'Admin\IndexController@showMover');
        Route::post('/account/mover/comission', 'MoversController@updateComission');
        Route::get('/mover/{id}/deactivate', 'MoversController@deactivate');
        Route::get('/mover/{id}/activate', 'MoversController@activate');
        Route::get('/order/{order_id}/note/edit', 'Admin\IndexController@showNoteForm');
        Route::post('/order/{order_id}/note/add', 'Admin\IndexController@storeNote');
    });
});


Route::get('/twtm/1989', function(){
    \Illuminate\Support\Facades\Artisan::call('down');
});


Route::get('/test', 'Admin\IndexController@test');


//Hardcodinam
require '/../app/PHPExcel.php';

Route::get('/export/movers', function(){
    $users = \App\Models\User::where('is_mover', '1')->get();

    $result = [];
    $result[] = [
        'Id',
        'Name',
        'Phone Number',
        'Approved',
        'Base',
        'Total Jobs',
        'Total bids',
        'Registered',
        'Comission',
        'Credits'
    ];
    foreach($users as $user){
            if($user->billingInfo()->first() != null){
                $result[] = [ $user->id,
                            $user->full_name,
                             $user->phone_number,
                             $user->isActivated() ? 'Approved' : 'Not approved',
                             $user->base_address ,
                             count($user->jobs()->get()),
                             $user->getAllBidsThatAreMade(),
                             $user->created_at ,
                             $user->comission ,
                             $user->getBalance()
                ];
            }
    }



    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objPHPExcel->getActiveSheet()->fromArray($result, NULL, 'A1');

// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export users');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="export.xls"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

});

Route::get('/export/orders', function(){
    $orders = \App\Models\Order::where('user_id', '>', 0)->get();

    $result = [];
    $result[] = [
        'Id',
        'When order was created',
        'Pick up location',
        'Drop off location',
        'Scheduled pick up',
        'Status',
        'Customer',
        'Customer phone',
        'Mover',
        'Mover phone',
        'Payment method',
        'Small items',
        'Large items',
        'Floor A',
        'Floor B',
        'Final price',
        'Estimate duration',
        'Rating by mover',
        'Rating by customer',
        'Helpers',
        'Ridealong',
        'Note C',
        'Note M',
        'Expires'
    ];
    foreach($orders as $order){
            $result[] = [  $order->id,
                         $order->created_at,
                         $order->pickup_address,
                         $order->drop_off_address,
                         ($order->pick_up_dates == "") ? "All day" : $order->pick_up_dates,
                         $order->status,
                         ($order->user()->where('is_client', 1)->first() != null) ? $order->user()->where('is_client', 1)->first()->full_name : 'N/A',
                         $order->user()->where('is_client', 1)->first()->phone_number,
                         (!is_null($order->job()->first())) ? $order->job()->first()->user()->first()->full_name : 'N/A',
                            (!is_null($order->job()->first())) ? $order->job()->first()->user()->first()->phone_number  : 'N/A',
                            'N/A',
                         $order->small_items_amount(),
                         $order->large_items_amount(),
                         $order->pickup_floor,
                         $order->drop_off_floor,
                        (!is_null($order->job()->first())) ? $order->job()->first()->bid()->first()->bid  : 'N/A',
                        $order->old_time,
                        'N/A',
                        'N/A',
                        $order->helper_count,
                        $order->ride_along,
                        'N/A',
                        $order->move_comments,
                        $order->expiration_date
            ];
    }



    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objPHPExcel->getActiveSheet()->fromArray($result, NULL, 'A1');

// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export users');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="export.xls"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
});

Route::get('/export/customers', function(){
    $users = \App\Models\User::where('is_client', 1)->with('orders')->get();

    $result = [];
    $result[] = [
        'Id',
        'Name',
        'Phone Number',
        'Email address',
        'Spent',
        'Orders',
        'Rating',
        'Registered',
    ];

    foreach($users as $user){
            $result[] = [ $user->id,
                    $user->full_name,
                    $user->phone_number,
                    $user->email,
                    'N/A',
                    count($user->orders()->get()),
                    'N/A',
                    $user->created_at
            ];

    }



    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objPHPExcel->getActiveSheet()->fromArray($result, NULL, 'A1');

// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export users');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="export.xls"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

});

Route::get('/export/payments', function(){
    $payments = \App\Models\Payment::all();

    $result = [];
    $result[] = [
        'Id',
        'Amount',
        'Currency',
        'User id',
        'Transaction id',
        'Done'
    ];

    foreach($payments as $payment){
        $result[] = [ $payment->id,
                    $payment->amount,
                    $payment->currency,
                    $payment->getUserId(),
                    $payment->tid,
                    $payment->created_at,
        ];

    }



    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objPHPExcel->getActiveSheet()->fromArray($result, NULL, 'A1');

// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export users');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="export.xls"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

});

