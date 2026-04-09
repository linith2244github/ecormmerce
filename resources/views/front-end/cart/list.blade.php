@extends('front-end.components.master')

@section('contents')

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Cart</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">cart</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
       
        <div class="cart shopping">
            <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if (Session::has('success'))
                        <div class=" alert alert-success pb-0 text-center">
                           Congratulation❤️😘 <span>{{ Session::get('success') }}</span>
                        </div>
                    @endif
                    

                    <div class="block">
                        <div class="product-list">
                            <form method="post">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th class="">Item Name</th>
                                        <th class="">Item Quantity</th>
                                        <th class="">Item Price</th>
                                        <th class="">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item )
                                            @php
                                                $image = $item->attributes->image;
                                            @endphp
                                            <tr class="">
                                                <td class="">
                                                    <div class="product-info">
                                                    <img width="80" src="{{ asset('uploads/product/'.$image) }}" alt="" />
                                                    <a href="#!">{{ $item->name }}</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <td>
                                                        <div class="qty-control">
                                                            <button type="button" class="btn btn-sm btn-danger decrease-btn" data-id="{{ $item->id }}">-</button>
                                                            <input type="number" name="qty[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" style="width: 60px; text-align: center; padding: 3px; outline: none;" readonly class="item-qty-{{ $item->id }}" />
                                                            <button type="button" class="btn btn-sm btn-success increase-btn" data-id="{{ $item->id }}">+</button>
                                                        </div>
                                                    </td>
                                                    
                                                </td>
                                                <td class="">${{ $item->price }}</td>
                                                <td class="">
                                                    <a class="product-remove" href="{{ route('cart.remove',$item->id) }}">Remove</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                                <a href="{{ route('checkout.index') }}" class="btn btn-main pull-right">Checkout</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
  <script>
    
    // Handle increase button
    $(".increase-btn").on("click", function () {
        const itemId = $(this).data("id");
        updateQuantity(itemId, "increase");
    });

    // Handle decrease button
    $(".decrease-btn").on("click", function () {
        const itemId = $(this).data("id");
        updateQuantity(itemId, "decrease");
    });



    function updateQuantity(itemId, action) {
        $.ajax({
            url: "{{ route('cart.update') }}",
            type: "POST",
            data: {
                id: itemId,
                action: action,
            },
            success: function (response) {
                if (response.success) {
                    $(`.item-qty-${itemId}`).val(response.newQuantity);
                    Message(response.message,true);
                } else {    
                    Message(response.message,false);
                }
            },
            error: function () {
                alert("An error occurred. Please try again.");
            }
        });
    }


  </script>
@endsection