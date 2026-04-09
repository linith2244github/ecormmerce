<!DOCTYPE html>
<html lang="en">
@include('front-end.components.header')
<body id="body">

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
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
          <h2 class="text-center">Reset Password</h2>
          
          <form class="text-left clearfix" action="{{ route('reset.password.process') }}" method="POST" onsubmit="showLoading(this)">
            @csrf
            <div class="form-group">
              <input type="hidden" value="{{ $tokenData->token }}" name="token">
              <input type="hidden" value="{{ $tokenData->code }}" name="code">
              <input type="password" class="form-control" name="password" placeholder="New Password" value="{{ old('password') }}">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password"  value="{{ old('confirm_password') }}">
              @error('confirm_password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

           
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" id="submitBtn">
                  Reset Password
              </button>
            </div>
          </form>
          
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
