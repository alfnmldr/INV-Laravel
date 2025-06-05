Route::get('/admin/dashboard', [
    'middleware' => 'admin',
    'uses' => 'AdminController@dashboard',
]);
