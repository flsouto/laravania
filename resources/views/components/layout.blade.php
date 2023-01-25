@props(['title'])
<html>
    <head>
        <title>{{ isset($title) ? $title : 'Larablog'}}</title>
        <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">

    </head>
    <body>
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
            <a class="navbar-brand text-light">
                Larablog
            </a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    @if( !auth()->user() )
                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('signup')}}">Signup</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{route('rooms.create')}}">Create Room</a></li>
                    @endif
                </ul>
            </div>

        </nav>
        <main>

            @if(session('success'))
            <div class="alert alert-success col-md-6 mx-auto text-center mt-3">
                {{session('success')}}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger col-md-6 mx-auto text-center mt-3">
                {{session('error')}}
            </div>
            @endif


            <div class="container">
                {{$slot}}
            </div>
        </main>
    </body>
</html>
