@extends('front-end.components.master')

@section('contents')

    <section class="single-product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li class="active">Single Product</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <ol class="product-pagination text-right">
                        <li><a href="blog-left-sidebar.html"><i class="tf-ion-ios-arrow-left"></i> Next </a></li>
                        <li><a href="blog-left-sidebar.html">Preview <i class="tf-ion-ios-arrow-right"></i></a></li>
                    </ol>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-md-5">
                    <div class="single-product-slider">
                        <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                            <div class='carousel-outer'>
                                <!-- Main slider -->
                                <div class='carousel-inner '>
                                    @foreach ($images as  $key => $image)
                                        <div class='item {{ $key == 0 ? 'active' : '' }}'>
                                            <img src="{{ asset('uploads/product/'. $image->image) }}" alt="Product Image" data-zoom-image="{{ asset('uploads/product/'. $image->image) }}" class="img-responsive" />
                                        </div>
                                    @endforeach
                                    
                                </div>
                                
                                <!-- Navigation controls -->
                                <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                                    <i class="tf-ion-ios-arrow-left"></i>
                                </a>
                                <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                                    <i class="tf-ion-ios-arrow-right"></i>
                                </a>
                            </div>
                            
                            <!-- Thumbnails -->
                            <ol class='carousel-indicators mCustomScrollbar meartlab'>
                                @foreach ($images as  $key => $image)
                                    <li data-target='#carousel-custom' data-slide-to='{{ $key }}' class="{{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('uploads/product/'. $image->image) }}" alt="Thumbnail" class="img-responsive" />
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-details">
                        <h2>{{ $product->name }}</h2>
                        <p class="product-price">${{ $product->price }}</p>
                        
                        <p class="product-description mt-20">
                            {{ Str::limit($product->desc, 400) }}
                        </p>
                        <div class="color-swatches">
                            <span>color:</span>
                            <ul>
                                @foreach ($colors as $color)
                                    <li>
                                        <a href="#!" style="background-color: {{ $color->color_code }}" class="swatch"></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="product-size">
                            <span>Size:</span>
                            <select class="form-control">
                                <option>S</option>
                                <option>M</option>
                                <option>L</option>
                                <option>XL</option>
                            </select>
                        </div>
                        {{-- <div class="product-quantity">
                            <span>Quantity:</span>
                            <div class="product-quantity-slider">
                                <input id="product-quantity" type="text" value="0" name="product-quantity">
                            </div>
                        </div> --}}
                        <div class="product-category">
                            <span>Categories:</span>
                            <ul>
                                <li><a href="product-single.html">{{ $category->name }}</a></li>
                                <li><a href="product-single.html">{{ $brand->name }}</a></li>
                            </ul>
                        </div>
                        <a href="cart.html" class="btn btn-main mt-20">Add To Cart</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabCommon mt-20">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
                            <li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews (3)</a></li>
                        </ul>
                        <div class="tab-content patternbg">
                            <div id="details" class="tab-pane fade active in">
                                <h4>Product Description</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut per spici</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis delectus quidem repudiandae veniam distinctio repellendus magni pariatur molestiae asperiores animi, eos quod iusto hic doloremque iste a, nisi iure at unde molestias enim fugit, nulla voluptatibus. Deserunt voluptate tempora aut illum harum, deleniti laborum animi neque, praesentium explicabo, debitis ipsa?</p>
                            </div>
                            <div id="reviews" class="tab-pane fade">
                                <div class="post-comments">
                                    <ul class="media-list comments-list m-bot-50 clearlist">
                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar" src="{{ asset('front-end/assets/images/blog/avater-1.jpg') }}" alt="" width="50" height="50" />
                                            </a>

                                            <div class="media-body">
                                                <div class="comment-info">
                                                    <h4 class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                        
                                                    </h4>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod laborum minima, reprehenderit laboriosam officiis praesentium? Impedit minus provident assumenda quae.
                                                </p>
                                            </div>

                                        </li>
                                        <!-- End Comment Item -->

                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar" src="{{ asset('front-end/assets/images/blog/avater-4.jpg') }}" alt="" width="50" height="50" />
                                            </a>

                                            <div class="media-body">

                                                <div class="comment-info">
                                                    <div class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                    </div>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni natus, nostrum iste non delectus atque ab a accusantium optio, dolor!
                                                </p>

                                            </div>

                                        </li>
                                        <!-- End Comment Item -->

                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar" src="{{ asset('front-end/assets/images/blog/avater-1.jpg') }}" alt="" width="50" height="50">
                                            </a>

                                            <div class="media-body">

                                                <div class="comment-info">
                                                    <div class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                    </div>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend.
                                                </p>

                                            </div>

                                        </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products related-products section">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Related Products</h2>
                </div>
            </div>
            <div class="row">
                @if ($related_products->isNotEmpty())
                    @foreach($related_products as $product)
                        @php
                            if($product->images != '') {
                                $img = $product->images->first();
                                $imgUrl = $img ? asset('uploads/product/'. $img->image) : asset('front-end/assets/images/shop/products/product-1.jpg');
                            } 
                        @endphp
                        <div class="col-md-3">
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

    <!-- Modal -->
    <div class="modal product-modal fade" id="product-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="tf-ion-close"></i>
        </button>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="modal-image">
                                <img class="img-responsive" src="{{ asset('front-end/assets/images/shop/products/modal-product.jpg') }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-short-details">
                                <h2 class="product-title">GM Pendant, Basalt Grey</h2>
                                <p class="product-price">$200</p>
                                <p class="product-short-description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto nihil cum. Illo laborum numquam rem aut officia dicta cumque.
                                </p>
                                <a href="#!" class="btn btn-main">Add To Cart</a>
                                <a href="#!" class="btn btn-transparent">View Product Details</a>
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