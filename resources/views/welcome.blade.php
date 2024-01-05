
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Show Git Activity</title>

        @vite(['resources/scss/app.scss','resources/css/app.css', 'resources/js/app.js', 'resources/js/showkey_script.js'])
        
    </head>
    <body>

       <header>
            <div>
                <h1>
                    Resume all your git activity
                </h1>

            </div>
       </header>
       <main>
        <div class="gradient"></div>
            <div class="container">
                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="keyform">
                    <form method="POST" action="/create_couple">
                        @csrf
                    <div class="githubpart">
                        <label for="githubkey">
                            
                        </label>
                            <input name="githubkey" type="password" id="gitHubInput" placeholder="Paste your Github PAT here" required>
                            <input class="showHubButton" type="button" value="Show/Hide">
                    </div>
                        <br>
                    <div class="gitlabpart">
                        <label for="gitlabkey">
                        </label>
                            <input name="gitlabkey" type="password" id="gitLabInput" placeholder="Paste your Gitlab PAT here"  required>
                            <input class="showLabButton" type="button" value="Show/Hide" >
                    </div>
                        <br>
                    <button class="keysubmit" type="submit" >Get your activity!</button>
                    </form>
                </div>
            </div>
       </main>
       <footer>

       </footer>
    </body>
    @vite('resources/js/app.js')
</html>
