<?php

namespace App\Http\Controllers;

use App\Models\GitFeed;
use Illuminate\Http\Request;

class GitFeedController extends Controller
{


    /**
     * Display the specified resource.
     */
    public function showGitFeed($token)
    {
        try {
            // Find the GitFeed entry based on the token
            $gitFeed = GitFeed::where('generated_url', $token)->first();

            if (!$gitFeed) {
                return view('errors.404'); // Or any other error view
            }

            // Display the GitFeed content
            return view('activity.show')
                ->with('htmlContent', $gitFeed->html_content)
                ->with('generatedUrl', $gitFeed->generated_url);
        } catch (\Exception $e) {
            return view('errors.500'); // Or any other error view
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GitFeed $gitFeed)
    {
        //
    }
}
