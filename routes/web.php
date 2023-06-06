<?php

use App\Mail\TestMailNew;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

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
Route::get('/run', function () {
    Artisan::call("cache:clear");
     Artisan::call("configcache");
});
Route::post('/some', function (Request $request) {
    dd($request);
    // return view('admin.dashboard');
    // dd(Hash::make('1234'));
    // return view('admin.notificationmethod');
});

// Route::redirect('/', '/auth/login', 301);
Route::view('/', 'welcome');
Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@handellogin')->name('adminhandellogin');
    Route::get('/resetpassword', 'AuthController@resetpassword')->name('resetpassword');
    Route::post('/resetpassword', 'AuthController@handelresetpassword')->name('handelresetpassword');
    Route::get('/mailsuccess', 'AuthController@mailsuccess')->name('mailsuccess');
    Route::get('/recovery/{email}/{token}', 'AuthController@recovery');
    Route::post('/recovery', 'AuthController@recoveryhandel')->name('handelrecoveryhandel');
    Route::get('/logout', 'AuthController@logout')->name('logout');
});

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('admindashboard');
    Route::get('/profile', 'DashboardController@profile')->name('adminprofile');
    
    Route::post('/updateprofile', 'DashboardController@updateprofile')->name('adminupdateprofile');
    Route::get('/changepassword', 'DashboardController@changepassword')->name('adminchangepassword');
    Route::post('/userchangepassword', 'DashboardController@userchangepassword')->name('userchangepassword');
    Route::get('/notificationmethods', 'DashboardController@notificationmethods')->name('adminnotificationmethods');
    Route::get('/levels', 'DashboardController@levels')->name('adminlevels');
    Route::post('/configurationupdate', 'DashboardController@configurationupdate')->name('adminconfigurationupdate');
    Route::get('/configureactions', 'DashboardController@configurationactions')->name('configurationactions');
    Route::post('/configureactionshandel', 'DashboardController@configureactionshandel')->name('configureactionshandel');
    #employee routes for admin
    Route::post('/resolvecomplaintadmin', 'DashboardController@resolvecomplaintadmin')->name('resolvecomplaintadmin');

    Route::get('/employee', 'EmployeeController@index')->name('adminemployee');
    Route::post('/employee', 'EmployeeController@store')->name('handelemployee');
    Route::get('/editemployee/{id}', 'EmployeeController@edit')->name('editemployee');
    Route::post('/editemployee/{id}', 'EmployeeController@update')->name('updateemployee');
    // Upload Logo
    Route::get('/uploadlogoview', 'DashboardController@uploadlogoview')->name('uploadlogo');
    Route::post('/uploadlogoview', 'DashboardController@uploadlogo');

        // Routes for total comlaints and enq
        Route::get('/totalcomplaints', 'DashboardController@totalcomplaints')->name('totalcomplaints');
        Route::get('/totalinq', 'DashboardController@totalinq')->name('totalinq');
        
    #manage department routes for admin
    Route::group(['prefix' => 'department'], function () {
        Route::get('/', 'DepartmentController@index')->name('deparment');
        Route::post('/', 'DepartmentController@create')->name('createdeparment');
        Route::post('/departmentchangestatus', 'DepartmentController@departmentchangestatus');
        Route::get('/update/{id}', 'DepartmentController@edit')->name('updatedeparment');
        Route::post('/update/{id}', 'DepartmentController@update');
        Route::delete('/delete/{id}', 'DepartmentController@delete');
    });
    Route::group(['prefix' => 'inquirytype'], function () {
        Route::get('/', 'InquiryTypeController@index')->name('inquirytype');
        Route::post('/', 'InquiryTypeController@create');
        Route::post('/changestatus', 'InquiryTypeController@changestatus');
        Route::get('/update/{id}', 'InquiryTypeController@edit')->name('inquirytypeupdate');
        Route::post('/update/{id}', 'InquiryTypeController@update');
        Route::delete('/delete/{id}', 'InquiryTypeController@delete')->name('inquirytypedelete');

    });

    Route::group(['prefix' => 'complainttype'], function () {
        Route::get('/', 'ComplaintTypeController@index')->name('complainttype');
        Route::post('/', 'ComplaintTypeController@create');
        Route::get('/update/{id}', 'ComplaintTypeController@edit')->name('editcomplainttype');
        Route::post('/update/{id}', 'ComplaintTypeController@update');
        Route::post('/changestatus', 'ComplaintTypeController@changestatus');
        Route::delete('/delete/{id}', 'ComplaintTypeController@delete');
    });

});

Route::group(['prefix' => 'frontoffice', 'namespace' => 'frontoffice', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('frontofficedashboard');
    Route::post('/dashboard', 'DashboardController@addcustomercomplaint');

    Route::post('/editcomplaint/{id}', 'DashboardController@editcomplaint')->name('editcomplaint');
    Route::get('/editcomplaint/{id}', 'DashboardController@showcomplaint')->name('editcomplaint');
    Route::post('/createcomplaint', 'DashboardController@createcomplaint')->name('createcomplaint');
    Route::post('/createinquiry', 'DashboardController@createinquiry')->name('createinquiry');
    Route::get('/reports', 'DashboardController@reports')->name('frontofficereoports');
    Route::get('/inquiry', 'DashboardController@inquiry')->name('inquirydashboard');
    Route::get('/customercomplaintslist', 'DashboardController@customercomplaintslist')->name('customercomplaintslist');
    Route::post('/customercomplaintslist', 'DashboardController@addcustomercomplaint');
    Route::post('/resolvecomplaint', 'DashboardController@resolvecomplaint')->name('resolvecomplaintfront');
    Route::post('/resolveinquiry', 'DashboardController@resolveinquiry')->name('resolveinquiryfront');
    Route::get('/transferinquiry/{text?}/{trans}/{userid}', 'DashboardController@transferinquiry');
    Route::get('/showprofile', 'DashboardController@showprofile')->name('frontofficeprofile');
    Route::get('/changepassword', 'DashboardController@changepassword')->name('frontchangepassword');
    Route::get('/frontofficetrackcomplaint', 'DashboardController@trackcomplaintform')->name('frontofficetrackcomplaint');
    Route::get('/frontofficetrackinquiry', 'DashboardController@trackinquiryform')->name('frontofficetrackinquiry');
    //Route::get('/whatsappTesting', 'DashboardController@whatsappTest')->name('whatsappTesting');

});

Route::group(['prefix' => 'jassociates', 'namespace' => 'jlevel', 'middleware' => 'auth'], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('jdashboard');
    Route::get('/complaint', 'DashboardController@complaint')->name('jcomplaint');
    Route::get('/inquiry', 'DashboardController@inquiry')->name('jinquiry');
    Route::get('/transfer/{text?}/{trans}/{userid}', 'DashboardController@transfer');
    Route::get('/transferinquiry/{text?}/{trans}/{userid}', 'DashboardController@transferinquiry');
    Route::post('/complainteresolve', 'DashboardController@complainteresolve')->name('jcomplainteresolve');
    Route::post('/resolveinquiry', 'DashboardController@resolveinquiry')->name('resolveinquiry');
    Route::post('/resolvecomplaint', 'DashboardController@resolvecomplaint')->name('resolvecomplaint');
    Route::get('/showprofile', 'DashboardController@showprofile')->name('juniorprofile');
    Route::get('/changepassword', 'DashboardController@changepassword')->name('juniorchangepassword');
});
Route::group(['prefix' => 'sassociates', 'namespace' => 'slevel', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('sdashboard');
    Route::get('/complaint', 'DashboardController@complaint')->name('scomplaint');
    Route::get('/inquiry', 'DashboardController@inquiry')->name('sinquiry');
    Route::post('/resolvecomplaintslevel', 'DashboardController@resolvecomplaintslevel')->name('resolvecomplaintslevel');
    Route::post('/resolveinquiryslevel', 'DashboardController@resolveinquiryslevel')->name('resolveinquiryslevel');
    Route::get('/closecomplaints', 'DashboardController@closecomplaints')->name('closecomplaints');
    Route::post('/closecomplaints', 'DashboardController@updateclosecomplaint');
    Route::get('/closeinquirys', 'DashboardController@closeinquirys')->name('closeinquirys');
    Route::post('/closeinquirys', 'DashboardController@updatecloseinquirys');
    Route::get('/showprofile', 'DashboardController@showprofile')->name('seniorprofile');
    Route::get('/changepassword', 'DashboardController@changepassword')->name('seniorchangepassword');
});

Route::group(['prefix' => 'ceo', 'namespace' => 'ceo', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('ceo');
    Route::get('/complaint', 'DashboardController@complaint')->name('ceocomplaint');
    Route::get('/inquiry', 'DashboardController@inquiry')->name('ceoinquiry');
    Route::get('/trackcomplaintceo', 'DashboardController@trackcomplaintform')->name('ceotrackcomplaint');
    Route::get('/trackinquiryceo', 'DashboardController@trackinquiryform')->name('ceotrackinquiry');
    Route::get('/showprofile', 'DashboardController@showprofile')->name('ceoprofile');
    Route::get('/changepassword', 'DashboardController@changepassword')->name('ceochangepassword');
});
Route::group(['prefix' => 'customerrelation', 'middleware' => 'auth'], function () {
    Route::view('/', 'customerrelation.index');

});

Route::get('/createcomplaint', 'TestController@createcomplaint');

// customer tracking
Route::get('/trackcomplaint', 'TrackingController@trackcomplaintview');
// Route::post('/trackcomplaint', 'TrackingController@trackcomplaint');
Route::get('/trackinquiry', 'TrackingController@trackinquiryview');
Route::post('/trackinquiry', 'TrackingController@trackinquiry');

// customer complaint form
Route::get('/customercomplaintform', 'CustomerComplaintController@customercomplaintform');
Route::post('/customercomplaintform', 'CustomerComplaintController@registercustomercomplaint');

// customer inquiry form
Route::get('/customerinquiryform', 'CustomerComplaintController@customerinquiryform');
Route::post('/customerinquiryform', 'CustomerComplaintController@registercustomerinquiry');

// Route::get('testpusher', function () {
//     event(new App\Events\ComplaintCreated());
//     return "Event has been sent!";
// });

Route::get('testpusherview', function () {
    return view('testpusher');
});

// clear notification
Route::get('/clearnotification/{id}', 'NotificationController@clearnotification');

Route::get('/testemail1', function () {
     Mail::send(new TestMailNew());
});
Route::get('/smstest', function () {
$mobilenumber = '8955465824';
$msgid = 1;

$message ="Dear Sir/Ma'am,

A new enquiry No. 112233 has been registered in the system.

Please check the Bikaji Grievance Management Portal for faster resolution by clicking on this link: http://care.bikaji.com/auth/login";

$msg = rawurlencode($message);
$header=rawurlencode('New Enquiry Alert: Bikaji Grievance manegement portal');
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://media.smsgupshup.com/GatewayAPI/rest',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => "method=SendMessage&userid=2000198849&password=*Us9jRXz&msg=$msg&msg_type=TEXT&format=json&v=1.1&auth_scheme=plain&send_to=8955465824&isTemplate=true&footer=Bikaji%20Foods%20International%20Limited&header=$header",
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
exit;
   

    // Mail::send(new SmsTrait());
});

// Route::get('/testsms', 'TestController@testsms')->name('testsms');


// Routs for state  and city 

Route::get('state','TestController@state')->name('state');
Route::post('city','TestController@city')->name('city');