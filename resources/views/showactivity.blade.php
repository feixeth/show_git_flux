
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
                    Your activity recap'
                </h1>
            </div>
       </header>
       <main>
        <div class="container">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div>
                    
                </div>
            </div>
        </div>
       </main>
       <footer>

       </footer>
    </body>
</html>
