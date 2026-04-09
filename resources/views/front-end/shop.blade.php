@extends('front-end.components.master')

@section('contents')
    
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Shop</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">shop</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products section">
        <div class="container">
            <div class="row">
                @if ($products->isNotEmpty())
                    @foreach($products as $product)
                        @php
                            if($product->images != '') {
                                $img = $product->images->first();
                                $imgUrl = $img ? asset('uploads/product/'. $img->image) : asset('front-end/assets/images/shop/products/product-1.jpg');
                            } 
                        @endphp
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <span class="bage">Sale</span>
                                    <img class="img-responsive" src="{{ $imgUrl }}" alt="{{ $img ? $img->image : 'product' }}" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li onclick="viewProduct({{ $product->id }})">
                                                <span  data-toggle="modal" data-target="#product-modal">
                                                    <i class="tf-ion-ios-search-strong"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <a href="#!" ><i class="tf-ion-ios-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html">{{ $product->name }}</a></h4>
                                    <p class="price">${{ $product->price }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <!-- Modal Start -->
                <div class="modal product-modal fade" id="product-modal">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="tf-ion-close"></i>
                    </button>
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-body view-product">
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal end -->
            </div>

            {{-- show page --}}
            
            <div class="show-page text-center ">
                {{ $products->links() }}
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        const viewProduct = (id) => {
            $.ajax({
                type: "GET",
                url: "{{ route('product.view') }}",
                data: { "id" : id},
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        let product = response.product;
                        let productHTML = `
                            <div class="row">
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <div class="modal-image">`;
                                        if(product.images.length > 0){
                                            productHTML = `<img class="img-responsive" src="{{ asset('uploads/product/${product.images[0].image}') }}" alt="product-img" />`;
                                        }
                            productHTML += `
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="product-short-details">
                                        <h2 class="product-title">${product.name}</h2>
                                        <p class="product-price">$${product.price.toFixed(2)}</p>
                                        <p class="product-short-description">
                                            ${(product.desc.substring(0, 200) + '...')}
                                        </p>
                                        <a href="cart.html" class="btn btn-main">Add To Cart</a>
                                        <a href="/product/single/${product.id}" class="btn btn-transparent">View Product Details</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('.view-product').html(productHTML);
                    }
                }
            });
        }
    </script>
@endsection