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

//Route::get('/test', function () {
//    phpinfo();
//    \Illuminate\Support\Facades\Redis::set('name', 'Taylor');
//    echo \Illuminate\Support\Facades\Redis::get('name');
//    \Illuminate\Support\Facades\Cache::put('name', 'liangguohao',1);
//    echo \Illuminate\Support\Facades\Cache::get('name');
//    $admins = \App\Admins::all();
//    \Illuminate\Support\Facades\Cache::put('admins', $admins,1);
//    $cache = \Illuminate\Support\Facades\Cache::get('admins');
//    dd($cache[0]->password);
//    class TEST{
//        public $code =false ;
//    }
//    $text = new TEST();
//    dd(@$text->code);
//});
Route::get('/', 'SportController@index');
Route::get('/article/{one}', 'SportController@article');
Route::get('/article/{one}/{two}', 'SportController@articles');

Route::any('/wechat', 'WechatController@serve');


Route::group(['prefix' => 'admin'], function (){
    Route::get('login','Admin\LoginController@showLoginForm');
    Route::post('login', 'Admin\LoginController@login');

    Route::post('logout', 'Admin\LoginController@logout');

    Route::post('createadmin','Admin\AdminController@createAdmin');
    Route::post('deleteadmin/{id}','Admin\AdminController@deleteAdmin');
    Route::post('activeadmin/{id}','Admin\AdminController@activeAdmin');

    Route::get('register', 'Admin\RegisterController@showRegistrationForm');
    Route::post('register', 'Admin\RegisterController@register');
});

Route::group(['middleware' => 'admin', 'prefix' => 'backstage'], function (){
    Route::get('/', 'Backstage\ManageController@home');
    Route::get('home', 'Backstage\ManageController@home');
    Route::get('photo', 'PhotoController@photo');
    Route::post('photo', 'PhotoController@createPhoto');
    Route::get('photo/edit/{id}', 'PhotoController@editForm');
    Route::post('photo/edit', 'PhotoController@edit');

    Route::get('customer', 'CustomerController@index');
    Route::post('customer', 'CustomerController@create');
    Route::get('customer/edit/{id}', 'CustomerController@editForm');
    Route::post('customer/edit', 'CustomerController@edit');

    Route::get('adminlist', 'Admin\AdminController@adminList');
    Route::get('adminform','Admin\AdminController@adminForm');

    Route::get('siteconfig','Backstage\SiteController@siteConfig');
    Route::get('sitepicture','Backstage\SiteController@sitePicture');
    Route::get('sitecarousel','Backstage\SiteController@siteCarousel');
    Route::get('sitenavigation','Backstage\SiteController@siteNavigation');
    Route::get('editnavigation/{id}','Backstage\SiteController@editNavigation');
    Route::post('editnavigation','Backstage\SiteController@updateNavigation');
    Route::get('friendship', 'Backstage\SiteController@friendShip');
    Route::post('friendship', 'Backstage\SiteController@handleFriendShip');

    Route::get('course','CourseController@courseConfig');
    Route::get('createcourse', 'CourseController@courseForm');
    Route::get('courselist', 'CourseController@courseList');
    Route::get('createnew', 'NewController@newForm');
    Route::get('newlist', 'NewController@newList');
    Route::get('newconfig', 'NewController@config');

    Route::get('createcoach', 'CoachController@coachForm');
    Route::get('coachclassify', 'CoachController@coachclassify');
    Route::get('coachlist', 'CoachController@coachList');

    Route::get('createactivity', 'ActivityController@createForm');
    Route::get('activitylist', 'ActivityController@showList');

    Route::get('createknowledge', 'KnowledgeController@createForm');
    Route::get('knowledgelist', 'KnowledgeController@show');

});

Route::group(['middleware' => 'admin', 'prefix' => 'site'], function () {
    Route::post('saveconfig','Backstage\SiteController@saveConfig');
    Route::post('savepicture','Backstage\SiteController@savePicture');
    Route::post('savecarouserl','Backstage\SiteController@saveCarouserl');
    Route::post('savecarouselurl','Backstage\SiteController@saveCarouselUrl');
    Route::post('deletecarousel/{id}','Backstage\SiteController@deleteCarousel');
    Route::post('savenavigation','Backstage\SiteController@saveNavigation');
    Route::post('savenavigationinfo','Backstage\SiteController@saveNavigationInfo');
    Route::post('createchildnavigation','Backstage\SiteController@createChildNavigation');
    Route::post('childnavigation','Backstage\SiteController@childNavigation');

});

Route::group(['middleware' => 'admin', 'prefix' => 'course'], function () {
//    Route::post('createcourse', 'CourseController@creatCourse');
    Route::get('createcourse', 'CourseController@courseForm');
    Route::post('savepicture', 'CourseController@savePicture');
    Route::post('createcourse', 'CourseController@createCourse');
    Route::post('editcourse', 'CourseController@editCourse');
});

Route::group(['middleware' => 'admin', 'prefix' => 'new'],function (){
    Route::post('createnew', 'NewController@createNew');
    Route::get('edit/{id}', 'NewController@editForm');
    Route::post('edit', 'NewController@edit');
    Route::get('delete/{id}', 'NewController@delete');
    Route::get('status/{id}', 'NewController@status');
    Route::post('savefile', 'NewController@saveFile');

});

Route::group(['middleware' => 'admin', 'prefix'=> 'coach'], function(){
   Route::post('createclassify', 'CoachController@createClassify');
   Route::post('editclassify', 'CoachController@editClassify');
   Route::post('uploadpicture', 'CoachController@uploadPicture');
   Route::post('croppicture', 'CoachController@cropPicture');
   Route::post('createcoach', 'CoachController@createCoach');
   Route::post('edit', 'CoachController@edit');
   Route::get('edit/{id}', 'CoachController@editForm');
});

Route::group(['middleware' => 'admin', 'prefix'=> 'activity'], function(){
    Route::get('edit/{id}', 'ActivityController@editForm');
    Route::post('edit', 'ActivityController@edit');
});


Route::resource('activity', 'ActivityController', ['except' =>
    ['index', 'create', 'edit']
]);

Route::group(['middleware' => 'admin', 'prefix'=> 'knowledge'], function(){
    Route::post('create', 'KnowledgeController@create');
    Route::get('edit/{id}', 'KnowledgeController@editForm');
    Route::post('edit', 'KnowledgeController@edit');
});