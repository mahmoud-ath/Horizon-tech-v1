<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Issues;
use App\Models\History;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Theme;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboarduser');
    }
    public function subscription()
    {
        // Fetch subscription data or perform any logic
        return redirect()->route('user.subscription'); // Assuming you have a `subscription.blade.php` view
    }

    public function myArticles()
    {
        // Fetch articles created by the authenticated user
        $articles = Article::where('user_id', auth()->id())->get();
        return view('user.myArticle', compact('articles')); // Assuming you have a `my-articles.blade.php` view
    }
    public function browsingHistory()
    {
        // Fetch browsing history for the authenticated user
        $history = History::where('user_id', auth()->id())->get();
        return view('user.browsing-history', compact('history')); // Assuming you have a `browsing-history.blade.php` view
    }






    // Route to handle the user article proposal
    public function showProposalForm()
{
    $themes = Theme::all(); // Assuming you are passing themes to the view
    return view('user.propose-article', compact('themes'));
}
public function submitArticle(Request $request)
{
    // Validate the incoming request data
    // - title: Required, must be a string, max 255 characters
    // - theme_id: Required, must be an array (for multiple themes)
    // - imagepath: Required, must be an image file (jpeg, png, jpg, gif), max 2MB
    // - description: Required, must be a string, max 1000 characters
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'theme_id' => 'required|array',
        'imagepath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:1000',
    ]);

    // Handle the file upload for the image (store the image in the 'public' disk and get the file path)
    // The image will be saved in the 'storage/app/public' folder and accessible via URL
    $imagePath = $request->file('imagepath')->store('article_images', 'public');

    // Create a new Article instance
    $article = new Article();

    // Assign the validated form data to the article fields
    // - title: From the validated title
    // - theme_id: Store the selected theme(s) as a comma-separated string
    // - imagepath: The path of the uploaded image
    // - description: From the validated description
    // - status: Set the initial status to 'pending'
    $article->title = $validated['title'];
    $article->theme_id = implode(',', $validated['theme_id']); // Save multiple selected themes as a comma-separated string
    $article->imagepath = $imagePath; // Store the path to the uploaded image
    $article->description = $validated['description'];
    $article->status = 'pending'; // Default status is 'pending' when the article is submitted
    $article->save(); // Save the article to the database
    if ($article->save()) {
        dd('Article successfully saved!');
    } else {
        dd('Failed to save article.');
    }
    // Redirect back to the propose article page with a success message
    return redirect()->route('user.proposearticle')->with('success', 'Article proposé avec succès!');
    dd($request->all());

}


    public function settings()
    {
        // Your logic to retrieve and display user settings
        return view('user.settings'); // Ensure you have a `settings.blade.php` view file
    }
    
    public function showUserProfile()
{
    // Assuming the user is authenticated
    $user = Auth::user(); // Fetch the authenticated user's data
    return view('user.dashboarduser', compact('user')); // Pass the user data to the view
 }
    public function index()
    {
        // Get authenticated user
        $user = Auth::user();
        
        // Get recommended articles based on user subscriptions
        $recommendedArticles = Article::whereHas('themes', function($query) use ($user) {
            $query->whereIn('theme_id', $user->subscriptions->pluck('theme_id'));
        })
        ->where('status', 'Published')
        ->latest()
        ->take(112)
        ->get();

        // Get magazine issues
        $magazineIssues = Issues::where('status', 'Public')
            ->latest()
            ->take(10)
            ->get();

        // Get user subscriptions
        $subscriptions = $user->subscriptions->pluck('theme_id');
        dd($magazineIssues);

        return view('user.dashboard', compact('user', 'recommendedArticles', 'magazineIssues', 'subscriptions'));
    }

       
    public function showSubscriptions()
    {
        $themes = Theme::all(); // Récupère tous les thèmes
        return view('user.subscriptions', compact('themes'));
    }
    public function toggleSubscription(Request $request)
    {
        $subscription = Subscription::where('user_id', Auth::id())->where('theme', $request->theme)->first();
        if ($subscription) {
            $subscription->delete();
        } else {
            Subscription::create([
                'user_id' => Auth::id(),
                'theme' => $request->theme,
            ]);
        }

        return response()->json(['status' => 'success']);
    }
   

}
