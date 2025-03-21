<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\AdminThemeController;
use App\Http\Controllers\AdminIssueController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminCreateArticleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/user/dashboarduser', [UserController::class, 'index'])->middleware('auth');

//route accueil
Route::get('/', [IssueController::class, 'index'])->name('/.index');
//a-propos
Route::get('/a_propos', function () {
    return view('accueil.a_propos');
});
//contact us
Route::get('/contact_us', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact_us', [ContactController::class, 'storeMessage'])->name('contact.store');
//after login
Route::get('/home', [HomeController::class, 'index']);
// Default Breeze routes (login, registration, etc.)
require __DIR__ . '/auth.php';




// gestion  des articles
// themes
Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');

// Page articles d'un nombre
Route::get('/numbers/{issue_id}', [IssueController::class, 'showArticlesByIssue'])->name('issue.articles')->middleware('auth.custom');
// Page article d'un nombre

Route::get('/numbers/{issue_id}/{article_id}', [IssueController::class, 'showArticle'])->name('issue.article')->middleware('auth.custom');
Route::post('/numbers/{issue_id}/{article_id}/comment', [IssueController::class, 'storeComment'])->middleware('auth.custom');
Route::post('/numbers/{issue_id}/{article_id}/rate', [IssueController::class, 'rateArticle'])->middleware('auth.custom');
// Route to display articles based on theme ID
Route::get('/themes/{themeId}', [ArticleController::class, 'index'])->middleware('auth.custom');
//search routes

Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Route to display a specific article
Route::get('/themes/{themeId}/articles/{articleId}', [ArticleController::class, 'show'])
    ->middleware(['auth.custom', 'log.article.access'])
    ->name('article.show');
// Update the theme subscription route to include auth.custom middleware
Route::post('/themes/toggleSubscription', [ThemeController::class, 'toggleSubscription'])
    ->name('themes.toggleSubscription')
    ->middleware('auth.custom');
    
// Route to handle comment and ratings submission for a specific article
Route::group(['prefix' => 'themes/{themeId}/articles/{articleId}'], function () {
    Route::post('comments', [ArticleController::class, 'storeComment']);
});

Route::post('articles/{articleId}/ratings', [ArticleController::class, 'storeRating']); // Add this route





// responsable


// Moderator Routes
Route::middleware(['auth', 'moderator'])->group(function () {
    Route::get('/moderator/dashboard', [ModeratorController::class, 'dashboard'])->name('moderatorhome');

    // Routes for managing articles
    Route::get('/moderator/articles', [ModeratorController::class, 'index'])->name('moderator.articles.index');
    Route::get('/moderator/articles/{id}', [ModeratorController::class, 'show'])->name('moderator.articles.show');
    Route::delete('/moderator/articles/{id}', [ModeratorController::class, 'destroy'])->name('moderator.articles.destroy');
    Route::post('/moderator/articles/{id}/publish', [ModeratorController::class, 'publish'])->name('moderator.articles.publish');

    // Routes for managing subscribers
    Route::get('/moderator/subscribers', [ModeratorController::class, 'indexsub'])->name('moderator.subscribers.index');
    Route::get('/moderator/subscribers/{id}', [ModeratorController::class, 'showsub'])->name('moderator.subscribers.show');
    Route::delete('/moderator/subscribers/{id}', [ModeratorController::class, 'destroysub'])->name('moderator.subscribers.destroy');

    // Routes for managing conversations
    Route::get('/moderator/conversations', [ModeratorController::class, 'indexchat'])->name('moderator.conversations.index');
    Route::delete('/moderator/conversations/{id}', [ModeratorController::class, 'destroychat'])->name('moderator.conversations.destroy');

    // Routes for managing proposals
    Route::get('/moderator/proposals', [ModeratorController::class, 'indexpropose'])->name('moderator.proposals.index');
    Route::delete('/moderator/proposals/{id}', [ModeratorController::class, 'destroypropose'])->name('moderator.proposals.destroy');
    Route::post('/moderator/proposals/{id}/propose-edit', [ModeratorController::class, 'proposeEdit'])->name('moderator.proposals.proposeEdit');

    // Profile Update Route
    Route::put('/moderator/profile/update', [ModeratorController::class, 'update'])->name('moderator.profile.update');
    Route::get('/moderator/settings', [ModeratorController::class, 'settings'])->name('moderator.settings');
});



//admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('adminhome', [AdminController::class, 'dashboard'])->name('admin.adminhome');

        Route::get('articles', [AdminController::class, 'index'])->name('admin.articles.index');
        Route::post('/articles/switch-status/{id}', [AdminController::class, 'switchStatus'])->name('admin.articles.switchStatus');
        Route::post('/articles/remove/{id}', [AdminController::class, 'remove'])->name('articles.remove');
        Route::get('/articles/{id}', [AdminController::class, 'show'])->name('articles.show');
        Route::post('/admin/articles/assign-issue', [AdminController::class, 'assignIssue'])->name('articles.assignIssue');

        Route::get('/admin/articles/create', [AdminController::class, 'create'])->name('admin.articles.create');
        Route::post('/admin/articles/store', [AdminController::class, 'store'])->name('admin.articles.store');
        
        Route::get('/users', [AdminController::class, 'indexuser'])->name('admin.users.index');
        Route::put('/users/{id}', [AdminController::class, 'updateuser'])->name('admin.users.update');
        Route::put('/users/{id}/switch-role', [AdminController::class, 'switchRole'])->name('admin.users.switchRole');
        Route::delete('/users/{id}', [AdminController::class, 'destroyuser'])->name('admin.users.destroy');

        // themes route
        Route::get('themes', [AdminController::class, 'indextheme'])->name('admin.themes.index');
        Route::post('themes', [AdminController::class, 'storetheme'])->name('admin.themes.store');
        Route::post('themes/update-responsible/{id}', [AdminController::class, 'updateResponsible'])->name('updateResponsible');
        Route::post('themes/toggle-status/{id}', [AdminController::class, 'toggleStatustheme'])->name('toggleStatus');
        Route::delete('themes/{id}', [AdminController::class, 'destroytheme'])->name('admin.themes.destroy');

        // numbers routes
        Route::get('issues', [AdminController::class, 'indexnumber'])->name('admin.issues.index');
        Route::post('issues', [AdminController::class, 'storenumber'])->name('admin.issues.store');
        Route::patch('issues/{issue}/updateStatus', [AdminController::class, 'updateStatusnumber'])->name('admin.issues.updateStatus');
        Route::delete('issues/{issue}', [AdminController::class, 'destroynumber'])->name('admin.issues.destroy');
        // messages
        Route::get('/messages', [ContactController::class, 'showMessages'])->name('admin.messages');

        // Settings routes
        Route::get('/settings', [AdminSettingsController::class, 'settings'])->name('admin.settings');
        Route::put('/settings/update', [AdminSettingsController::class, 'update'])->name('admin.updateSettings');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// User Dashboard Routes
Route::get('/user/dashboarduser', [ UserManagerController::class, 'index'])->name('user.dashboarduser');
// User Subscription Routes
Route::get('/user/subscription', [UserManagerController::class, 'indexsub'])->name('user.subscription');
Route::post('/admin/toggle-subscription', [UserManagerController::class, 'toggleSubscription'])->name('user.toggleSubscription');
/*Route::get('/user/browsing-history', [UserController::class, 'browsingHistory'])->name('user.browsing-history');*/
// User History Route
Route::get('/user/browsing-history', [UserManagerController::class, 'indexhistory'])->name('user.browsing-history');
// User Settings Routes
Route::put('/settings/update', [UserManagerController::class, 'updatedata'])->name('user.settings.update');
Route::get('/user/settings', [UserManagerController::class, 'settings'])->name('user.settings');

// User Article Proposal Routes
Route::get('/user/proposearticle', [UserManagerController::class, 'create'])->name('user.proposearticle');
Route::post('/submit-article', [UserManagerController::class, 'store'])->name('submit-article');

// User Articles Routes
Route::get('/my-articles', [UserManagerController::class, 'myArticles'])->name('user.myarticles');
Route::get('/article/{id}', [UserManagerController::class, 'show'])->name('userarticle.show');
Route::put('/articles/{id}', [UserManagerController::class, 'update'])->name('articles.update');




