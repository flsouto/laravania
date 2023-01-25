@section('form')
<form method="POST" action="{{route('signup.store')}}">
    @csrf
    <div class="form-group">
        <label>Name:</label>
        <input class="form-control" name="name" value="{{ old('name') }}" />
        <x-fld-error field="name" />
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input class="form-control" name="email" required type="email" value="{{ old('email') }}" />
        <x-fld-error field="email" />
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input class="form-control" name="password" required type="password" value="" />
    </div>
    <div class="form-group">
        <label>Confirmation:</label>
        <input class="form-control" name="password_confirmation" required type="password" value="" />
        <x-fld-error field="password" />

    </div>
    <button class="btn btn-primary">Signup</button>
</form>
@endsection

<x-layout>
    <div class="row">
        <div class="col-4 mx-auto mt-5">
            <div class="card">
                <div class="card-body">
                    @yield('form')
                </div>
                <div class="card-footer text-center">
                    Already a member? <a href="{{route('login')}}">Login</a> instead.
                </div>
            </div>
        </div>
    </div>
</x-layout>
