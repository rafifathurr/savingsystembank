<html>
@include('layouts.head')
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card o-hidden shadow-lg my-5" style="border-radius:20px !important;">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="{{asset('images/bank_logo.png')}}" style="padding:5px;" width="100%" alt="">
                                    </div>
                                    <br>
                                    <form class="user" method="post" action="{{route('signin.authenticate')}}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" required>
                                        </div>
                                        <p>
                                        </p>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            SIGN IN
                                        </button>
                                        <br>
                                        <div class="col-xs-12">
                                            <center>
                                                Don't have an account? <a href="{{ route('signin.signup') }}">Sign Up</a>
                                            </center>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.scripts')
    @include('layouts.swal')
</body>
</html>
