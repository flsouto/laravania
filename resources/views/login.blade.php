@section('form')
<form method="POST" action="{{route('login.store')}}">
    @csrf
    <div class="form-group">
        <label>Email:</label>
        <input class="form-control" name="email" required type="email" value="" />
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input class="form-control" name="password" required type="password" value="" />
    </div>
    <button class="btn btn-primary">Login</button>
</form>
@endsection

<x-layout>
    <div class="row">
        <div class="col-4 mx-auto mt-5">
            <div class="card">
                <div class="card-head">
                    <img class="card-img-top" src="https://picsum.photos/300/100" />
                </div>
                <div class="card-body">
                    @yield('form')
                </div>
                <div class="card-footer text-center">
                    Not a member? <a href="{{route('signup')}}">Signup</a> instead.
                </div>
            </div>
        </div>
    </div>
</x-layout>
