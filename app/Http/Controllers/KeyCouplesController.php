<?php

namespace App\Http\Controllers;

use App\Models\GitFeed;
use App\Models\KeyCouples;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;



class KeyCouplesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     
    public function create(Request $request)
    {

    }
        */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // validate data from request
            $validatedData = $request->validate([
                'githubkey' => 'required|string',
                'gitlabkey' => 'required|string',
            ]);
             var_dump('validated : ' . $validatedData);
            // encrypt key before storage
            $hubKey = Crypt::encrypt($validatedData['githubkey']);
            $labKey = Crypt::encrypt($validatedData['gitlabkey']);

            // create a KeyCouples object using model
            $keyCouple = KeyCouples::create([
                'githubkey' => $hubKey,
                'gitlabkey' => $labKey,
            ]);
            var_dump('keycouple : ' . $keyCouple);
            //store/save this to DB
            $keyCouple->save();
            
            // Call the showActivity method to display the activity
            $this->showActivity($hubKey, $labKey); 
            
        } 
        catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'An error occurred while storing the data.');
        };
    }


    /**
     * Display the activity based on the keys.
     */
    public function showActivity($hubKey, $labKey)
    {
        try {
            // Decrypt the keys to use in API requests
            $decryptedHubKey = Crypt::decrypt($hubKey);
            $decryptedLabKey = Crypt::decrypt($labKey);

            // Fetch GitHub activity (replace with actual GitHub API endpoint and logic)
            $githubResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $decryptedHubKey,
            ])->get('https://api.github.com/user/repos');

            $githubData = $githubResponse->json();
            
            var_dump('hubresp ' . $githubResponse);

            // Fetch GitLab activity (replace with actual GitLab API endpoint and logic)
            $gitlabResponse = Http::withHeaders([
                'PRIVATE-TOKEN' => $decryptedLabKey,
            ])->get('https://gitlab.com/api/v4/user');

            $gitlabData = $gitlabResponse->json();

            // Build HTML content (replace with your HTML content logic)
            $htmlContent = view('activity.show')
                ->with('githubData', $githubData)
                ->with('gitlabData', $gitlabData)
                ->render();

            // Save the data to the gitfeed table
            $gitFeed = new GitFeed([
                'generated_url' => 'YOUR_GENERATED_URL', // replace with your logic to generate the URL
                'html_content' => $htmlContent,
            ]);

            // Attach the keyCouple relationship
            $gitFeed->keyCouple()->associate($keyCouple);
            $gitFeed->save();

            // redirect to the recap view with success message and HTML content
            return view('/showactivity')
                ->with('htmlContent', $htmlContent)
                ->with('success', 'Storage OK');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while fetching API data.');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KeyCouples $keyCouples)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KeyCouples $keyCouples)
    {
        //
    }
}
