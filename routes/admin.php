<?php
 Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function() {

	Config::set('Auth.defines','admin');
	Route::get('login', 'AdminAuthController@login');
	Route::post('login', 'AdminAuthController@doLogin');

	Route::get('forgot/password', 'AdminAuthController@forgot_password');
	Route::post('forgot/password', 'AdminAuthController@forgot_password_post');

	Route::get('reset/password/{token}', 'AdminAuthController@reset_password');
	Route::post('reset/password/{token}', 'AdminAuthController@reset_password_post');

	Route::group(['middleware'=>'admin:admin'], function(){

			Route::resource('admin', 'AdminController');
			Route::delete('admin/destroy/all', 'AdminController@destroy_all');


			Route::resource('user', 'UserController');
			Route::delete('user/destroy/all', 'UserController@destroy_all');

			Route::resource('countries', 'CountriesController');
			Route::delete('countries/destroy/all', 'CountriesController@multi_delete');

			Route::resource('cities', 'CitiesController');
			Route::delete('cities/destroy/all', 'CitiesController@multi_delete');

			Route::resource('states', 'StatesController');
			Route::delete('states/destroy/all', 'StatesController@multi_delete');

			Route::resource('trademarks', 'TradeMarksController');
			Route::delete('trademarks/destroy/all', 'TradeMarksController@multi_delete');

			Route::resource('manufacturers', 'ManufacturersController');
			Route::delete('manufacturers/destroy/all', 'ManufacturersController@multi_delete');

			Route::resource('shipping', 'ShippingController');
      		Route::delete('shipping/destroy/all', 'ShippingController@multi_delete');

			Route::resource('departments', 'DepartmentsController');

			Route::resource('malls', 'MallsController');
      		Route::delete('malls/destroy/all', 'MallsController@multi_delete');

      		Route::resource('colors', 'ColorsController');
		    Route::delete('colors/destroy/all', 'ColorsController@multi_delete');

		    Route::resource('sizes', 'SizesController');
		    Route::delete('sizes/destroy/all', 'SizesController@multi_delete');

		    Route::resource('weights', 'WeightsController');
		    Route::delete('weights/destroy/all', 'WeightsController@multi_delete');

		    Route::resource('products', 'ProductsController');
		    Route::delete('products/destroy/all', 'ProductsController@multi_delete');

			Route::get('setting', 'SettingController@setting');
			Route::post('setting', 'SettingController@setting_save');
			

			Route::post('upload/image/{id}', 'ProductsController@upload_file');
			Route::post('delete/image', 'ProductsController@delete_file');

			Route::post('update/image/{id}', 'ProductsController@update_product_image');
			Route::post('delete/product/image/{id}', 'ProductsController@delete_main_image');
			

			Route::post('load/weight/size', 'ProductsController@prepare_weight_size');


			Route::get('/',function(){
				return view('admin.home');
			});

			Route::any('logout','AdminAuthController@logout');

			Route::any('lang/{lang}',function($lang){
				session()->has('lang')? session()->forget('lang'): "";
				$lang == 'ar'? session()->put('lang','ar'): session()->put('lang','en');
				return back();
			});
	});
});
