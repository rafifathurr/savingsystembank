<html>
@include('layouts.head')
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card o-hidden shadow-lg my-3" style="border-radius:20px !important;">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="{{asset('images/bank_logo.png')}}" style="padding:5px;" width="100%" alt="">
                                    </div>
                                    <br>
                                    <form class="user" method="post" action="{{route('signin.register')}}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control form-control-user"
                                                placeholder="Enter Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="phone" class="form-control form-control-user"
                                                placeholder="Enter Phone Number" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="c_password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Confirm Password" required>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            REGISTER
                                        </button>
                                        <br>
                                        <div class="col-xs-12">
                                            <center>
                                                Have an account? <a href="{{ route('signin.index') }}">Sign In</a>
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
