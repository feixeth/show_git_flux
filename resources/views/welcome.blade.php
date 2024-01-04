
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Show Git Activity</title>
    </head>
    <body>
       <header>
            <div>
                <h1>
                    Show all your git activity
                </h1>
            </div>
       </header>
       <main>
            <div class="container">
                <div class="title">
                    <h2>Board</h2>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="keyform">
                    <form method="POST" action="/create_couple">
                        @csrf
                    <label for="githubkey">
                        GitHub Key
                    </label>
                        <input name="githubkey" type="password" required>
                            <br>

                    <label for="gitlabkey">
                        GitLab Key
                    </label>
                        <input name="gitlabkey" type="password" required>
                            <br>

                    <button class="keysubmit" type="submit" >Get your activity!</button>
                    </form>
                </div>
            </div>
       </main>
       <footer>

       </footer>
    </body>
</html>
