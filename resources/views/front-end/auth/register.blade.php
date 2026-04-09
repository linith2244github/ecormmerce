<!DOCTYPE html>
<html lang="en">
@include('front-end.components.header')
<body id="body">
<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo">
            <img src="images/logo.png" alt="">
          </a>
          <h2 class="text-center">Create Your Account</h2>
          <form class="text-left clearfix" action="{{ route('customer.register.process') }}" method="POST" onsubmit="showLoading(this)">

            @csrf

            <div class="form-group">
              <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}">
              @error('name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                @error('phone')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

            <div class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Password">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
              @error('confirm_password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>


            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" id="submitBtn">
                Sign Up
              </button>
            </div>
          </form>
          <p class="mt-20">Already have an account? <a href="{{ route('customer.login') }}">Login</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function showLoading(form) {
    const submitButton = form.querySelector("#submitBtn");
    submitButton.disabled = true;
    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`;
    return true;
  }
</script>
</body>
</html>
