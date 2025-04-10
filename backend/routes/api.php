<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobListingsController;
use App\Http\Controllers\JobListingsAutoController;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\RoleMiddleware;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;



//Route::middleware(['auth:api', 'role:employer'])->resource('job-listings', JobListingController::class);
//Route::middleware(['auth:api', 'role:job seeker'])->get('/external-jobs', [JobListingsAutoController::class, 'getJobs']);
/*
Route::middleware([CorsMiddleware::class])->group(function () {
    Route::middleware([RoleMiddleware::class.':employer'])->group(function() {
        
    });
});
*/


Route::middleware('auth:api')->group(function () {
    Route::middleware([RoleMiddleware::class.':employer'])->group(function() {
        Route::post('job-listings', [JobListingsController::class, 'store']);
    });
    Route::get('all-jobs', [JobListingsAutoController::class, 'getJobs']);
});

Route::get('/create-default-user' , function() {
    
    $user = User::create([
        'email' => 'kenjos75@gmail.com',
        'name' => "kenneth",
        'password' => bcrypt('wanted12345')
    ]);

    $user->assignRole('job-seeker');

    return response()->json([
      'user' => $user  
    ]);


});

Route::get('/create-other-users' , function() {
    
    $user = User::create([
        'email' => 'employer@gmail.com',
        'name' => "employer",
        'password' => bcrypt('wanted12345')
    ]);

    $user->assignRole('employer');

    $anotherUser = User::create([
        'email' => 'jobmoderator@gmail.com',
        'name' => "job moderator",
        'password' => bcrypt('wanted12345')
    ]);

    $anotherUser->assignRole('job-board-moderator');

    return response()->json([
      'status' => 'ok'  
    ]);

});



Route::get('/create-default-permission', function() {

    //general admin permission
    $dashboardPermission = Permission::create(['name' => 'dashboard permission', 'guard_name' => 'api']);

    //role for job moderator
    $role = Role::create(['name' => 'job-board-moderator', 'guard_name' => 'api']);
    $approveJobs = Permission::create(['name' => 'approve jobs', 'guard_name' => 'api']);
    $role->givePermissionTo($approveJobs, $dashboardPermission);

    $role = Role::create(['name' => 'employer', 'guard_name' => 'api']);
    $createJobs = Permission::create(['name' => 'create jobs', 'guard_name' => 'api']);
    $editJobs = Permission::create(['name' => 'edit jobs', 'guard_name' => 'api']);
    $deleteJobs = Permission::create(['name' => 'delete jobs', 'guard_name' => 'api']);
    $role->givePermissionTo($createJobs, $editJobs, $deleteJobs, $dashboardPermission);

    $role = Role::create(['name' => 'job-seeker', 'guard_name' => 'api']);
    $seekJobs = Permission::create(['name' => 'seek jobs', 'guard_name' => 'api']);
    $role->givePermissionTo($seekJobs, $dashboardPermission); // assign permission to role
    
    return response()->json([
        'message' => 'permission created successfully'
    ]);
    //$user->assignRole('admin'); // assign role to user
});






Route::prefix('auth')->middleware([CorsMiddleware::class])->group(function () {
    // Public route
    Route::post('/login', [AuthController::class, 'login']);

    
    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});

