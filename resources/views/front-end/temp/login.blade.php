<!DOCTYPE html>
<html lang="en">
@include('front-end.components.header')
<body id="body">

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.html">
            <img src="{{ asset('front-end/assets/images/logo.png') }}" alt="">
          </a>
          <div>
            @if (Session::has('success'))
                <div class="alert alert-success">
                   {{ Session::get('success') }}
                </div>
            @elseif(Session::has('error'))
             <div class="alert alert-danger">
                {{ Session::get('error') }}
             </div>
            @endif
            
          </div>
          <h2 class="text-center">Welcome Back</h2>
          
          <form class="text-left clearfix" action="{{ route('customer.login.process') }}" method="POST" onsubmit="showLoading(this)">
            @csrf
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Password"  value="{{ old('password') }}">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <input type="checkbox" name="remember_me" checked>
              <span>Remember me</span>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" id="submitBtn">
                Login
              </button>
            </div>
          </form>
          <p class="mt-20">New in this site? <a href="{{ route('customer.register') }}">Create New Account</a></p>
          <a href="{{ route('send.email.show') }}">Forgot the your password?</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- JavaScript to handle button loading -->
<script>
  function showLoading(form) {
    const submitButton = form.querySelector("#submitBtn");
    submitButton.disabled = true; // Disable button to prevent multiple submissions
    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking...`;
    return true;
  }
</script>

</body>
</html>
