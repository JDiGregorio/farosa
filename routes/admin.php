<?php
	Route::get('crear-permisos/','PermissionCrudController@crear_permisos');
	Route::get('clientes/{id}','CustomerCrudController@get_customer');
	Route::get('productos/todos','ItemCrudController@get_items');
	Route::get('productos/{id}','ItemCrudController@get_item');
	Route::get('cliente/saldo/{id}','CustomerCrudController@get_saldo');
	
	CRUD::resource('clientes', 'CustomerCrudController');
	CRUD::resource('productos', 'ItemCrudController');
	CRUD::resource('pedidos', 'TransactionHoldCrudController');
	CRUD::resource('user', 'UserCrudController');
	CRUD::resource('role', 'RoleCrudController');