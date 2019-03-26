<?php

	Route::get('cliente/saldo/{id}','CustomerCrudController@get_saldo');
	Route::get('producto/todos','ItemCrudController@get_items');

	CRUD::resource('clientes', 'CustomerCrudController');
	CRUD::resource('productos', 'ItemCrudController');
	CRUD::resource('pedidos', 'TransactionHoldCrudController');
	CRUD::resource('user', 'UserCrudController');