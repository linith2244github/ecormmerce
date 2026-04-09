@extends('front-end.components.master')
@section('contents')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Checkout</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">checkout</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="page-wrapper">
   <div class="checkout shopping">
      <div class="container">
         <div class="row">
            <div class="col-md-8">
               <div class="block billing-details">
                  <h4 class="widget-title">Billing Details</h4>
                  <form class="checkout-form">
                     <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" placeholder="">
                     </div>
                     <div class="form-group">
                        <label for="user_address">Address</label>
                        <input type="text" class="form-control" id="user_address" placeholder="">
                     </div>
                     <div class="checkout-country-code clearfix">
                        <div class="form-group">
                           <label for="user_post_code">Zip Code</label>
                           <input type="text" class="form-control" id="user_post_code" name="zipcode" value="">
                        </div>
                        <div class="form-group" >
                           <label for="user_city">City</label>
                           <input type="text" class="form-control" id="user_city" name="city" value="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="user_country">Country</label>
                        <input type="text" class="form-control" id="user_country" placeholder="">
                     </div>
                  </form>
               </div>
               <div class="block">
                  <h4 class="widget-title">Payment Method</h4>
                  <p>Credit Cart Details (Secure payment)</p>
                  <div class="checkout-product-details">
                     <div class="payment">
                        <div class="card-details">
                           <form  class="checkout-form">
                              <div class="form-group">
                                 <label for="card-number">Card Number <span class="required">*</span></label>
                                 <input  id="card-number" class="form-control"   type="tel" placeholder="•••• •••• •••• ••••">
                              </div>
                              <div class="form-group half-width padding-right">
                                 <label for="card-expiry">Expiry (MM/YY) <span class="required">*</span></label>
                                 <input id="card-expiry" class="form-control" type="tel" placeholder="MM / YY">
                              </div>
                              <div class="form-group half-width padding-left">
                                 <label for="card-cvc">Card Code <span class="required">*</span></label>
                                 <input id="card-cvc" class="form-control"  type="tel" maxlength="4" placeholder="CVC" >
                              </div>
                              <a href="confirmation.html" class="btn btn-main mt-20">Place Order</a >
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4">
                <div class="product-checkout-details">
                    <div class="block">
                        <h4 class="widget-title">Order Summary</h4>
                        @foreach($items as $item)
                            @php
                                $image = $item->attributes->image
                            @endphp
                            <div class="media product-card">
                                <a class="pull-left" href="#">
                                <img class="media-object" src="{{ asset('uploads/product/'.$image) }}" alt="{{ $item->name }}" />
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $item->name }}</h4>
                                    <p class="price">{{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                    <span class="btn btn-danger btn-sm">
                                        <a style="color:white;" href="{{ route('cart.remove', $item->id) }}">Remove</a>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                        <ul class="summary-prices">
                            <li>
                                <span>Subtotal:</span>
                                <span class="price">${{ number_format($subtotal, 2) }}</span>
                            </li>
                            <li>
                                <span>Shipping:</span>
                                <span>Free</span>
                            </li>
                        </ul>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="verified-icon">
                            <img src="{{ asset('front-end/assets/images/shop/verified.png') }}" alt="Verified">
                        </div>
                    </div>
                </div>
            </div>

         </div>
      </div>
   </div>
</div>
@endsection