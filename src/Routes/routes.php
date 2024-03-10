<?php

Route::group(['middleware'=>'web'], function(){
	Route::resource('/admin/portfolio', 'Locomotif\Portfolio\Controller\PortfolioController');
});
