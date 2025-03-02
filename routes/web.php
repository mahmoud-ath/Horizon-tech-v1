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
use App\Http\Controllers\ModeratorDashboardController;
use App\Http\Controllers\ModeratorArticlesController;
use App\Http\Controllers\ModeratorSubscribersController;
use App\Http\Controllers\ModeratorSettingsController;
use App\Http\Controllers\ModeratorChatController;
use App\Http\Controllers\UserProposalController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserArticleController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\UserHistoryController;
use App\Http\Controllers\ModeratorProposalController;
use App\Http\Controllers\AdminThemeController;
use App\Http\Controllers\AdminIssueController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminCreateArticleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;


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
    Route::get('/moderator/dashboard', [ModeratorDashboardController::class, 'dashboard'])->name('moderatorhome');

    // Routes for managing articles
    Route::get('/moderator/articles', [ModeratorArticlesController::class, 'index'])->name('moderator.articles.index');
    Route::get('/moderator/articles/{id}', [ModeratorArticlesController::class, 'show'])->name('moderator.articles.show');
    Route::delete('/moderator/articles/{id}', [ModeratorArticlesController::class, 'destroy'])->name('moderator.articles.destroy');
    Route::post('/moderator/articles/{id}/publish', [ModeratorArticlesController::class, 'publish'])->name('moderator.articles.publish');

    // Routes for managing subscribers
    Route::get('/moderator/subscribers', [ModeratorSubscribersController::class, 'index'])->name('moderator.subscribers.index');
    Route::get('/moderator/subscribers/{id}', [ModeratorSubscribersController::class, 'show'])->name('moderator.subscribers.show');
    Route::delete('/moderator/subscribers/{id}', [ModeratorSubscribersController::class, 'destroy'])->name('moderator.subscribers.destroy');

    // Routes for managing conversations
    Route::get('/moderator/conversations', [ModeratorChatController::class, 'index'])->name('moderator.conversations.index');
    Route::delete('/moderator/conversations/{id}', [ModeratorChatController::class, 'destroy'])->name('moderator.conversations.destroy');

    // Routes for managing proposals
    Route::get('/moderator/proposals', [ModeratorProposalController::class, 'index'])->name('moderator.proposals.index');
    Route::delete('/moderator/proposals/{id}', [ModeratorProposalController::class, 'destroy'])->name('moderator.proposals.destroy');
    Route::post('/moderator/proposals/{id}/propose-edit', [ModeratorProposalController::class, 'proposeEdit'])->name('moderator.proposals.proposeEdit');

    // Profile Update Route
    Route::put('/moderator/profile/update', [ModeratorSettingsController::class, 'update'])->name('moderator.profile.update');
    Route::get('/moderator/settings', [ModeratorSettingsController::class, 'settings'])->name('moderator.settings');
});



//admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('adminhome', [AdminDashboardController::class, 'index'])->name('admin.adminhome');

        Route::get('articles', [AdminArticleController::class, 'index'])->name('admin.articles.index');
        Route::post('/articles/switch-status/{id}', [AdminArticleController::class, 'switchStatus'])->name('admin.articles.switchStatus');
        Route::post('/articles/remove/{id}', [AdminArticleController::class, 'remove'])->name('articles.remove');
        Route::get('/articles/{id}', [AdminArticleController::class, 'show'])->name('articles.show');
        Route::post('/admin/articles/assign-issue', [AdminArticleController::class, 'assignIssue'])->name('articles.assignIssue');

        Route::get('/admin/articles/create', [AdminCreateArticleController::class, 'create'])->name('admin.articles.create');
        Route::post('/admin/articles/store', [AdminCreateArticleController::class, 'store'])->name('admin.articles.store');
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::put('/users/{id}/switch-role', [AdminUserController::class, 'switchRole'])->name('admin.users.switchRole');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        // themes route
        Route::get('themes', [AdminThemeController::class, 'index'])->name('admin.themes.index');
        Route::post('themes', [AdminThemeController::class, 'store'])->name('admin.themes.store');
        Route::post('themes/update-responsible/{id}', [AdminThemeController::class, 'updateResponsible'])->name('updateResponsible');
        Route::post('themes/toggle-status/{id}', [AdminThemeController::class, 'toggleStatus'])->name('toggleStatus');
        Route::delete('themes/{id}', [AdminThemeController::class, 'destroy'])->name('admin.themes.destroy');

        // numbers routes
        Route::get('issues', [AdminIssueController::class, 'index'])->name('admin.issues.index');
        Route::post('issues', [AdminIssueController::class, 'store'])->name('admin.issues.store');
        Route::patch('issues/{issue}/updateStatus', [AdminIssueController::class, 'updateStatus'])->name('admin.issues.updateStatus');
        Route::delete('issues/{issue}', [AdminIssueController::class, 'destroy'])->name('admin.issues.destroy');
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
Route::get('/user/dashboarduser', [DashboardUserController::class, 'index'])->name('user.dashboarduser');
// User Subscription Routes
Route::get('/user/subscription', [UserSubscriptionController::class, 'index'])->name('user.subscription');
Route::post('/admin/toggle-subscription', [UserSubscriptionController::class, 'toggleSubscription'])->name('user.toggleSubscription');
/*Route::get('/user/browsing-history', [UserController::class, 'browsingHistory'])->name('user.browsing-history');*/
// User History Route
Route::get('/user/browsing-history', [UserHistoryController::class, 'index'])->name('user.browsing-history');
// User Settings Routes
Route::put('/settings/update', [UserSettingsController::class, 'update'])->name('user.settings.update');
Route::get('/user/settings', [UserController::class, 'settings'])->name('user.settings');

// User Article Proposal Routes
Route::get('/user/proposearticle', [UserProposalController::class, 'create'])->name('user.proposearticle');
Route::post('/submit-article', [UserProposalController::class, 'store'])->name('submit-article');

// User Articles Routes
Route::get('/my-articles', [UserArticleController::class, 'myArticles'])->name('user.myarticles');
Route::get('/article/{id}', [UserArticleController::class, 'show'])->name('userarticle.show');
Route::put('/articles/{id}', [UserArticleController::class, 'update'])->name('articles.update');/*



//TEST A VERIFIE

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/user', [userController::class, 'index'])->name('user.dashboard');
Route::post('/toggle-subscription', [userController::class, 'toggleSubscription'])->name('user.toggleSubscription');





// Other routes...

Route::get('/user/dashboard', [UserController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth');
Route::post('/toggle-subscription', [UserController::class, 'toggleSubscription']);

*/

