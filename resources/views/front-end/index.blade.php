@extends('front-end.components.master')

@section('slider')
    <div class="hero-slider">
        <div class="slider-item th-fullpage hero-area" style="background-image: url({{ asset('front-end/assets/images/slider/slider-1.jpg') }});">
            <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center">
                <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details.</h1>
                <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="shop.html">Shop Now</a>
                </div>
            </div>
            </div>
        </div>
        <div class="slider-item th-fullpage hero-area" style="background-image: url({{ asset('front-end/assets/images/slider/slider-3.jpg') }});">
            <div class="container">
            <div class="row">
                <div class="col-lg-8 text-left">
                <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details.</h1>
                <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="shop.html">Shop Now</a>
                </div>
            </div>
            </div>
        </div>
        <div class="slider-item th-fullpage hero-area" style="background-image: url({{ asset('front-end/assets/images/slider/slider-2.jpg') }});">
            <div class="container">
            <div class="row">
                <div class="col-lg-8 text-right">
                <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details.</h1>
                <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="shop.html">Shop Now</a>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('contents')
    <section class="product-category section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title text-center">
                        <h2>Product Category</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box">
                        <a href="{{ route('product.category', $categories[0]->id) }}">
                            <img src="{{ asset('uploads/category/'. $categories[0]->image) }}" alt="" />
                            <div class="content">
                                <h3>{{ $categories[0]->name }}</h3>
                            </div>
                        </a>	
                    </div>
                    <div class="category-box">
                        <a href="{{ route('product.category', $categories[1]->id) }}">
                            <img src="{{ asset('uploads/category/'. $categories[1]->image) }}" alt="" />
                            <div class="content">
                                <h3>{{ $categories[1]->name }}</h3>
                            </div>
                        </a>	
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box category-box-2">
                        <a href="{{ route('product.category', $categories[2]->id) }}">
                            <img src="{{ asset('uploads/category/'. $categories[2]->image) }}" alt="" />
                            <div class="content">
                                <h3>{{ $categories[2]->name }}</h3>
                            </div>
                        </a>	
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>All Products</h2>
                </div>
            </div>

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