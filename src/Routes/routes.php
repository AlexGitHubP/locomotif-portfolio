<?php

Route::group(['middleware'=>'web'], function(){
	Route::resource('/admin/portfolio', 'Locomotif\Portolio\Controller\PortolioController');
});
