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

// if there are something needs to be tested with route,
// write it below, before the Admin route.
// TODO: always check if the test route is deleted.

/**
 * Admin route.
 */
Route::group(['prefix' => '/dashboard', 'middleware' => ['auth', 'admin', 'alive'], 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin.admin-template', ['action' => 'home']);
    })->name('index');

    // Manage
    Route::group(['prefix' => '/manage', 'as' => 'manage.'], function () {
        Route::get('/', function () {
            return redirect()->route('admin.index');
        });

        // subforums
        Route::group(['prefix' => '/subforum', 'as' => 'subforum'], function () {
            Route::get('/', function () {
                return view('admin.admin-template', ['action' => 'subforum', 'role' => 'subforum']);
            });

            Route::post('/edit', 'AdminController@editSubforum')->name('.edit');
            Route::post('/create', 'AdminController@createSubforum')->name('.create');
        });

        // reports
        Route::get('report/user', function () {
            return view('admin.admin-template', ['action' => 'management', 'role' => 'user']);
        })->name('user');

        Route::get('report/post', function () {
            return view('admin.admin-template', ['action' => 'management', 'role' => 'post']);
        })->name('post');
    });

    // edit user information
    Route::group(['prefix' => 'edit/user', 'as' => 'edit.user'], function () {
        // this return all the active users.
        Route::get('/', function () {
            return view('admin.admin-template', [
                'action'    => 'editUser',
                'users_raw' => App\UserInformation::getActiveUsers(),
            ]);
        });

        // search engine
        Route::group(['prefix' => '/search', 'as' => '.search'], function () {
            Route::get('/', function () {
                return redirect()->route('admin.edit.user');
            });
            Route::get('/{keyword}', function ($keyword) {
                if (!empty(App\User::search($keyword)->total() > 0)) {
                    return view('admin.admin-template', [
                        'action'    => 'editUser',
                        'keyword'   => $keyword,
                        'users_raw' => App\User::search($keyword),
                    ]);
                }

                return redirect()->route('admin.edit.user')->withErrors(['class' => 'warning', 'content' => 'Không tìm thấy người dùng này!']);
            })->name('.result');

            Route::post('/', 'SearchController@adminSearchEngine');
        });
    });

    // review user report.
    Route::post('/censor/user', 'AdminController@reviewUserReport')->name('censor.user');
    // edit user information
    Route::post('/edit/user', 'AdminController@editUserInformation')->name('edit.user.save');
});

/*
 * User (Profile, Edit Profile) route
 */
Route::group(['prefix' => '/user', 'middleware' => ['auth', 'alive'], 'as' => 'user.'], function () {
    Route::get('/', function () {
        return redirect()->route('user.edit');
    });
    Route::group(['prefix' => '/profile', 'as' => 'profile.'], function () {
        Route::get('/', 'ProfileController@home')->name('home');
        Route::group(['prefix' => '/{username}', 'where' => ['username' => '^[A-Za-z0-9._]+$'], 'as' => 'username'], function () {
            Route::get('/', 'ProfileController@profile');
            Route::post('/follow', 'ProfileController@follow')->name('.follow');
        });
    });
    Route::get('/edit', 'ProfileController@edit')->name('edit');
    Route::post('/edit/password', 'ProfileController@editPassword')->name('edit.password');
});

/*
 * Notification route
 */
Route::group(['prefix' => '/notify', 'as' => 'notify.', 'middleware' => ['auth', 'alive']], function () {
    Route::get('/', function () {
        return view('notify');
    })->name('home');
    Route::get('/{notify_id}', 'NotifyController@notify')->where('notify_id', '^[0-9]+$')->name('notifies');
});

/*
 * Search route
 * Search for profile: http://example.com/search/profile/loremipsum
 * Search for post   : http://example.com/search/post/loremipsum
 */
Route::group(['prefix' => '/search', 'middleware' => ['auth', 'alive'], 'as' => 'search'], function () {
    Route::get('/', function () {
        return view('search', ['have_results' => false]);
    })->name('.home');
    Route::get('/{action}/{keyword}', 'SearchController@search');
    Route::post('/search', 'SearchController@searchWithKeyword')->name('.keyword');
});

/*
 * Report route
 * Report a profile : http://example.com/report/profile/johndoe
 * Report a post    : http://example.com/report/post/1
 */
Route::group(['prefix' => '/report', 'middleware' => ['auth', 'alive'], 'as' => 'report.'], function () {
    Route::get('/profile/{username}', 'ReportController@profile')->where('username', '^[A-Za-z0-9._]+$')->name('profile');
    Route::get('/post/{post_id}', 'ReportController@post')->where('post_id', '^[0-9]+$')->name('post');
    Route::post('/', 'ReportController@handle')->name('handle');
});

/*
 * Forum route
 * basic cheatsheet for a forum url:
 * a thread: http://example.com/forum/thread/1/lorem-ipsum-dolor-sit-amet.html
 * a post  : http://example.com/forum/post/1/lorem-ipsum-dolor-sit-amet.html
 */
Route::prefix('/forum')->group(function () {
    Route::get('/', 'ForumController@home')->name('forum');
    Route::get('/{forum_category}', 'ForumController@category')->where('forum_category', '^[A-Za-z0-9.-]+$')->name('category');
    Route::get('/thread/{thread_id}/lorem-ipsum-dolor-sit-amet.html', 'ForumController@thread')->where('thread_id', '^[0-9]+$')->name('thread');
    Route::get('/post/{post_id}/lorem-ipsum-dolor-sit-amet.html', 'ForumController@post')->where('post_id', '^[0-9]+$')->name('post');
    Route::post('/create/post', 'ForumController@createPost')->middleware('auth', 'alive')->name('createPost');
    Route::post('/create/thread', 'ForumController@createThread')->middleware('auth', 'alive', 'confirmed')->name('createThread');
});

// Home
Route::get('/', 'HomeController@home');

Route::get('/home', 'HomeController@home');

// Register
Route::get('/register', function () {
    return view('register');
})->middleware('guest')->name('register');

Route::post('/register', 'RegisterController@register');

// Login
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', 'LoginController@login');

Route::post('/logout', 'LoginController@logout')->name('logout');
