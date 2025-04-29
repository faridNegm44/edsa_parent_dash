<?php
Route::get('/dashboard/login', 'IndexController@login');
Route::post('/dashboard/login_post', 'IndexController@login_post');

Route::get('/dashboard/parent/register', 'ParentController@register_get');

Route::post('/dashboard/parent/register', 'ParentController@register_post', (['verify' => true]));

Route::get('/dashboard/forget_password', 'IndexController@forget_password');
Route::get('/dashboard/not_auth', 'IndexController@not_auth');

Route::group(['prefix' => 'dashboard', 'middleware' => 'checkLogin'], function(){
    Route::get('/', 'IndexController@index');

    Route::get('/logout', 'IndexController@logout');

    // Parents Route
    Route::group(['prefix' => 'parents'], function(){
        Route::get('/', 'ParentController@index');
        Route::get('create', 'ParentController@create');
        Route::get('edit/{id}', 'ParentController@edit');
        Route::post('store', 'ParentController@store');
        Route::post('update/{id}', 'ParentController@update');
        Route::get('destroy/{id}', 'ParentController@destroy');

        Route::get('/datatable_parents' , 'ParentController@datatable_parents');
    });

    // Parents Payments Route
    Route::group(['prefix' => 'parents_payments'], function(){
        Route::get('/', 'ParentsPaymentController@index');
        Route::get('create', 'ParentsPaymentController@create');
        Route::get('edit/{id}', 'ParentsPaymentController@edit');
        Route::post('store', 'ParentsPaymentController@store');
        Route::post('update/{id}', 'ParentsPaymentController@update');
        Route::get('destroy/{id}', 'ParentsPaymentController@destroy');

        Route::get('/datatable_parents_payments' , 'ParentsPaymentController@datatable_parents_payments');

    });

    // Users Route
    Route::group(['prefix' => 'users', 'middleware' => 'checkAdmin'], function(){
        Route::get('/', 'UserController@index');
        Route::get('create', 'UserController@create');
        Route::get('edit/{id}', 'UserController@edit');
        Route::post('store', 'UserController@store');
        Route::post('update/{id}', 'UserController@update');
        Route::get('destroy/{id}', 'UserController@destroy');

        Route::get('/datatable_users' , 'UserController@datatable_users');

    });

    // parent_problems Route
    Route::group(['prefix' => 'parent_problems'], function(){
        Route::get('/', 'ParentProblemsController@index');
        Route::get('create', 'ParentProblemsController@create');
        Route::get('reference/{id}', 'ParentProblemsController@reference');
        Route::post('reference/store/{id}', 'ParentProblemsController@reference_store');
        Route::get('edit/{id}', 'ParentProblemsController@edit');
        Route::post('store', 'ParentProblemsController@store');
        Route::post('update/{id}', 'ParentProblemsController@update');
        Route::get('update_problem_rating/{id}', 'ParentProblemsController@update_problem_rating');
        Route::get('update_problem_status/{id}', 'ParentProblemsController@update_problem_status');
        Route::get('update_staff_rating/{id}', 'ParentProblemsController@update_staff_rating');
        Route::get('destroy/{id}', 'ParentProblemsController@destroy');


        // Datatable Area
        Route::get('/datatable_parent_problems' , 'ParentProblemsController@datatable_parent_problems');
        Route::get('/datatable_parent_problems_urgent' , 'ParentProblemsController@datatable_parent_problems_urgent');
        Route::get('/datatable_parent_problems_waiting' , 'ParentProblemsController@datatable_parent_problems_waiting');
        Route::get('/datatable_parent_problems_canceled' , 'ParentProblemsController@datatable_parent_problems_canceled');
        Route::get('/datatable_parent_problems_resolved' , 'ParentProblemsController@datatable_parent_problems_resolved');


        // Comments Area
        Route::post('store_comment/{id}', 'ParentProblemsController@store_comment');
        Route::get('edit/comment/{id}', 'ParentProblemsController@edit_comment');
        Route::post('update_comment/{id}', 'ParentProblemsController@update_comment');
        Route::get('delete/comment/{id}', 'ParentProblemsController@delete_comment');


        // Report Area
        Route::get('report/between_dates', 'ParentProblemsController@between_dates');
        Route::post('report/between_dates_post', 'ParentProblemsController@between_dates_post');

        Route::get('report', 'ParentProblemsController@parent');
        Route::post('report/parent_post', 'ParentProblemsController@parent_post');

        Route::get('report/staff', 'ParentProblemsController@staff');
        Route::post('report/staff_post', 'ParentProblemsController@staff_post');
    });

    // noti_to_parent Route
    Route::group(['prefix' => 'noti_to_parent'], function(){
        Route::get('/', 'NotiToParentController@index');
        Route::get('/create', 'NotiToParentController@create');
        Route::get('edit/{id}', 'NotiToParentController@edit');
        Route::get('edit_group_id/{id}', 'NotiToParentController@edit_group_id');
        Route::post('store', 'NotiToParentController@store');
        Route::post('update/{id}', 'NotiToParentController@update');
        Route::post('update_group_id/{id}', 'NotiToParentController@update_group_id');
        Route::get('destroy/{id}', 'NotiToParentController@destroy');
        Route::get('destroy_group_id/{id}', 'NotiToParentController@destroy_group_id');
        Route::get('change_readed/{id}', 'NotiToParentController@change_readed');

        Route::get('/datatable_noti_to_parent' , 'NotiToParentController@datatable_noti_to_parent');

    });

    // noti_to_class Route
    Route::group(['prefix' => 'noti_to_class'], function(){
        Route::get('/', 'NotiToClassController@index');
        Route::get('/create', 'NotiToClassController@create');
        Route::get('edit/{id}', 'NotiToClassController@edit');
        Route::get('edit_group_id/{id}', 'NotiToClassController@edit_group_id');
        Route::post('store', 'NotiToClassController@store');
        Route::post('update/{id}', 'NotiToClassController@update');
        Route::post('update_group_id/{id}', 'NotiToClassController@update_group_id');
        Route::get('destroy/{id}', 'NotiToClassController@destroy');
        Route::get('destroy_group_id/{id}', 'NotiToClassController@destroy_group_id');
        Route::get('change_readed/{id}', 'NotiToClassController@change_readed');

        Route::get('/datatable_noti_to_class' , 'NotiToClassController@datatable_noti_to_class');

    });

    // Students Route
    Route::group(['prefix' => 'students'], function(){
        Route::get('/', 'StudentController@index');
        Route::get('create', 'StudentController@create');
        Route::get('edit/{id}', 'StudentController@edit');
        Route::get('/student_desires/{id}', 'StudentController@student_desires');
        Route::post('store', 'StudentController@store');
        Route::post('update/{id}', 'StudentController@update');
        Route::get('destroy/{id}', 'StudentController@destroy');
        Route::post('destroy_desire_to_student/{id}/{student_id}', 'StudentController@destroy_desire_to_student');

        Route::get('/datatable_students' , 'StudentController@datatable_students');
        Route::get('/attendance_and_absence_report_for_students' , 'StudentController@attendance_and_absence_report_for_students');
        Route::post('/attendance_and_absence_report_for_students' , 'StudentController@attendance_and_absence_report_for_students_post');

        Route::get('/students_rates' , 'StudentController@students_rates');
        Route::get('/get_students_to_rates' , 'StudentController@get_students_to_rates');
        Route::post('/students_rates' , 'StudentController@students_rates_post');


        // students_desires
        Route::get('/desires', 'StudentController@index_student_desires');
        Route::get('/create_desires', 'StudentController@create_desires');
        Route::post('/get_mat_after_change_years/{id}/{student_id}', 'StudentController@get_mat_after_change_years');
        Route::get('view_desires/{id}', 'StudentController@view_desires');
        Route::get('edit_desires/{id}', 'StudentController@edit_desires');
        Route::post('store_desires', 'StudentController@store_desires');
        Route::post('update_desires/{id}', 'StudentController@update_desires');
        Route::post('destroy_desires/{id}', 'StudentController@destroy_desires');

        Route::get('/datatable_students_desires' , 'StudentController@datatable_students_desires');
    });



    // Bill Duew Route
    Route::group(['prefix' => 'bill_dues'], function(){
        Route::get('/', 'BillDuesController@index');
        Route::post('show/{id}', 'BillDuesController@show');
        Route::post('store', 'BillDuesController@store');
        Route::post('update/{id}', 'BillDuesController@update');
        Route::get('destroy/{id}', 'BillDuesController@destroy');

        Route::get('/datatable_parents' , 'BillDuesController@datatable_parents');
    });




    // Count Of Shares Route
    // Route::group(['prefix' => 'count_of_shares'], function(){
    //     Route::get('/', 'MatsAndSharesController@index');
    //     Route::get('create', 'MatsAndSharesController@create');
    //     Route::get('edit/{id}', 'MatsAndSharesController@edit');
    //     Route::post('store', 'MatsAndSharesController@store');
    //     Route::post('update/{id}', 'MatsAndSharesController@update');
    //     Route::delete('destroy/{id}', 'MatsAndSharesController@destroy');

    //     Route::get('datatable_count_of_shares' , 'MatsAndSharesController@datatable_count_of_shares');
    // });


    // Route::group(['prefix' => 'dashboard'], function(){
//     Route::get('/the_cost', 'CostController@index');
//     Route::get('/cost/get_mat_after_change_years/{id}/{section_id}', 'CostController@get_mat_after_change_years');
//     Route::get('get_add_form', 'ParentController@get_add_form');
//     Route::get('get_edit_form/{id}', 'ParentController@get_edit_form');
//     Route::post('save', 'ParentController@store');
//     Route::post('update/{id}', 'ParentController@update');
//     Route::delete('dalete/{id}', 'ParentController@destroy');

//     Route::get('datatable_tags' , 'ParentController@datatable_tags');
// });
});
