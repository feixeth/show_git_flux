<?php

namespace App\Http\Controllers;

use App\Models\GitFeed;
use App\Models\KeyCouples;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;



class KeyCouplesController extends Controller
{

    private $keyCoupleId; // to retrieve the key couple on the git feed

    public function store(Request $request)
    {
        try {
            // validate data from request
            $validatedData = $request->validate([
                'githubkey' => 'required|string',
                'gitlabkey' => 'required|string',
            ]);

            // encrypt key before storage
            $hubKey = Crypt::encrypt($validatedData['githubkey']);
            $labKey = Crypt::encrypt($validatedData['gitlabkey']);

            // create a KeyCouples object using model
            $keyCouple = KeyCouples::create([
                'githubkey' => $hubKey,
                'gitlabkey' => $labKey,
            ]);

            //store/save this to DB
            $keyCouple->save();
            
            $this->keyCoupleId = $keyCouple->id;

            // Call the showActivity method to display the activity
            $this->showActivity($hubKey, $labKey, $this->keyCoupleId); 
            
            } catch (\Exception $e) {
                Log::error('Error in showActivity: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'An error occurred while fetching API data.');
            }
    }


    /**
     * Display the activity based on the keys.
     */
        public function showActivity($hubKey, $labKey, $keyCoupleId)
        {
            try {
                // Decrypt the keys to use in API requests
                $decryptedHubKey = Crypt::decrypt($hubKey);
                $decryptedLabKey = Crypt::decrypt($labKey);

                // Fetch GitHub activity
                $githubData = $this->fetchGitHubActivity($decryptedHubKey);

                // Fetch GitLab activity
                $gitlabData = $this->fetchGitLabActivity($decryptedLabKey);

                // Build HTML content
                $htmlContent = view('showactivity')
                    ->with('githubData', $githubData)
                    ->with('gitlabData', $gitlabData)
                    ->render();

                // Log HTML content for debugging
                Log::info('HTML Content:', ['content' => $htmlContent]);

                // Generate a unique URL (you may want to implement your own logic)
                $generatedUrl = md5(now());

                Log::info('Decrypted Hub Key:', ['decryptedHubKey' => $decryptedHubKey]);
                Log::info('Decrypted Lab Key:', ['decryptedLabKey' => $decryptedLabKey]);
                Log::info('Key Couple ID:', ['keyCoupleId' => $keyCoupleId]);

                // Save the data to the GitFeed table
                $gitFeed = GitFeed::create([
                    'generated_url' => $generatedUrl,
                    'html_content' => $htmlContent,
                    'key_couple_id' => $keyCoupleId,
                ]);

                // Attach the keyCouple relationship
                $keyCouple = $this->getKeyCouple($decryptedHubKey, $decryptedLabKey);

                if (!$keyCouple) {
                    return redirect()->back()->with('error', 'Key couple not found.');
                }

                $gitFeed->keyCouple()->associate($keyCouple->id);
                $gitFeed->save();



                // Redirect to the showactivity.blade.php view with success message and generated URL
                return view('showactivity')
                    ->with('htmlContent', $htmlContent)
                    ->with('success', 'Storage OK')
                    ->with('generatedUrl', $generatedUrl);

            } catch (\Exception $e) {
                // Log the exception for debugging
                Log::error('Exception in showActivity:', ['exception' => $e]);
                return redirect()->back()->with('error', 'An error occurred while fetching API data. Check logs for details.');
            }
        }

        protected function fetchGitHubActivity($token)
        {
            return Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get('https://api.github.com/user/repos')
                ->json();
        }

        protected function fetchGitLabActivity($token)
        {
            return Http::withHeaders(['PRIVATE-TOKEN' => $token])
                ->get('https://gitlab.com/api/v4/user')
                ->json();
        }

        protected function getKeyCouple($keyCoupleId)
        {
            try {
                $keyCouple = KeyCouples::findOrFail($this->keyCoupleId);

                return $keyCouple;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                \Log::error("Key Couple Not Found for ID: $keyCoupleId");
                return null; 
            }
        }
}
