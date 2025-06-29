<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password | {{config('app.name') }}</title>
    @include('includes.script')
    

    <!-- FAVICON -->
    <link href="{{ asset('images/LOGO. REV2.png') }}" rel="shortcut icon" />
    
    <style>
        .btn-primary{
           color: #fff; background-color: #4A148C; border-color: #4A148C;
        }
        .btn-primary:hover {
            background-color: #6b18d0;
            border-color: #6b18d0;
        }
        a{
          color: #4a148c;
        }
        a:hover{
           color: #6b18d0;
        }
    </style>
</head>
<body >
    <!-- Password Reset 13 - Bootstrap Brain Component -->
<section class="bg-light py-3 py-md-5 d-flex justify-content-center align-items-center vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 ">
            @include('includes.notification')
            <div class="text-center mb-3">
              
                <img src="{{asset('images\uNiv4bD.png')}}" alt="Reset Password Amazing Grace" width="175" height="175">
     
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Masukkan email yang digunakan pada akun admin Amazing Grace anda</h2>
            <form action="{{route('password.email')}}" method="post">
                @csrf
              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="mt-3 inputbox">

                    <input type="text" class="form-control" name="email" placeholder="Email">                       
                    <i class="fa fa-user"></i>
                    
                </div>
                </div>
                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lock btn-lg" type="submit" >Reset Password</button>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex gap-2 justify-content-between" >
                    <a href="{{route('login')}}" class=" text-decoration-none" >Log In</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>