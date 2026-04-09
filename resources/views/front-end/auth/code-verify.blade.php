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
          <h2 class="text-center">Code verify with email</h2>
          
          <form class="text-left clearfix" action="{{ route('code.verify.process') }}" method="POST" onsubmit="showLoading(this)">


            @csrf
            <div class="form-group mb-5">
              <input type="hidden" class=" form-control" name="token" value="{{ $tokenData->token }}" id="">
              <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Enter code from your email">
              @error('code')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
           

            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" id="submitBtn">
                 Send
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
