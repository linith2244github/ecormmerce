@extends('back-end.components.master')
@section('contens')
{{-- Modal create start --}}
@include('back-end.messages.product.create')
{{-- Modal create end --}}

{{-- Modal edit start --}}
@include('back-end.messages.product.edit')
{{-- Modal edit start --}}

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Products</h3>
                <p onclick="handleClickOnButtonNewProduct()" data-toggle="modal" data-target="#modalCreateProduct" class="card-description btn btn-primary ">new product</p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-3">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody class="products_list">

                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center">

                <div class="show-page mt-3">

                </div>

                <button onclick="ProductRefresh()" class=" btn btn-outline-danger rounded-0 btn-sm">refresh</button>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#color_add').select2({
            placeholder: 'Select options'
            , allowClear: true
            , tags: true
        , });

        $('#color_edit').select2({
            placeholder: 'Select options'
            , allowClear: true
            , tags: true
        , });
    });

    // Product Rendering
    const ProductList = (page = 1, search = null) => {
        $(".products_list").html(`
          <tr>
              <td colspan="5" class="text-center">
                  <div class="spinner-border text-primary" role="status">hello</div>
              </td>
          </tr>
      `);

        $.ajax({
            type: "POST"
            , url: "{{ route('product.list') }}"
            , data: {
                'page': page
                , 'search': search
            }
            , dataType: "json"
            , success: function(response) {
                if (response.status == 200) {
                    let products = response.products;
                    let tr = '';
                    $.each(products, function(key, value) {
                        tr += `
                          <tr>
                              <td>P${value.id}</td>
                              <td>
                              `;
                        if (value.images.length > 0) {
                            tr +=
                                `<img  src='{{ asset('uploads/product/${value.images[0].image}') }}'/>`;
                        }
                        tr += ` 
                              </td>
                              <td>${value.name}</td>
                              <td>${value.categories.name}</td>
                              <td>${value.brands.name}</td>
                              <td>$${value.price}</td>
                              <td>${value.qty}</td>
                              <td>
                              <span class='text-light p-1 badge ${value.qty > 1 ? 'bg-success' : 'bg-danger'}'>
                                  ${value.qty > 1? 'In Stock' : 'Out Stock' }
                              </span> 
                          </td>
                              <td>
                                  <span class="text-light badge ${(value.status == 1)  ? 'bg-success' : 'bg-danger' }  p-1">
                                  ${(value.status == 1) ? 'Active' : 'Inactive' }
                                  </span>
                              </td>
                              <td>
                                  <button onclick="edit(${value.id})" type="button" class=" btn btn-info  btn-sm" data-toggle="modal" data-target="#modalUpdateProduct">Edit</button>
                                  <button onclick="ProductDelete(${value.id})" type="button" class="btn btn-danger btn-sm">Delete</button>
                              </td>
                          </tr>
                      `;
                    })

                    $(".products_list").html(tr);

                    //pagination
                    let page = ``;
                    let totalPage = response.page.totalPage;
                    let currentPage = response.page.currentPage;
                    page = `
                      <nav aria-label="Page navigation example">
                          <ul class="pagination">
                              <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : 'd-block' }">
                              <a class="page-link" href="javascript:void()" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                              </a>
                              </li>`;

                    for (let i = 1; i <= totalPage; i++) {
                        page += `
                                      <li onclick="ProductPage(${i})" class="shadow-none page-item ${(i == currentPage) ? 'active' : '' }">
                                          <a class="page-link" href="javascript:void()">${i}</a>
                                      </li>`;
                    }

                    page += `<li onclick="NextPage(${currentPage})" class="page-item ${( currentPage == totalPage ) ? 'd-none' : 'd-block'}">
                              <a class="page-link" href="javascript:void()" aria-label="Next">
                                  <span aria-hidden="true">&raquo;</span>
                              </a>
                              </li>
                          </ul>
                      </nav>
                  `;

                    if (totalPage > 1) {
                        $(".show-page").html(page);
                    } else {
                        $('.show-page').html('');
                    }


                } else {
                    $(".products_list").html('<tr><td colspan="5" class="text-center text-danger">No Product found.</td></tr>');
                }
            }
            , error: function() {
                $(".products_list").html('<tr><td colspan="5" class="text-center text-danger">Failed to load data.</td></tr>');
            }
        });



    }

    ProductList();

    const handleClickOnButtonNewProduct = () => {
        $.ajax({
            type: "POST"
            , url: "{{ route('product.data') }}"
            , dataType: "json"
            , success: function(response) {
                if (response.status == 200) {

                    //Categories start
                    let categories = response.data.categories;
                    let cate_option = ``;
                    $.each(categories, function(key, value) {
                        cate_option += `
              <option value="${value.id}">${value.name}</option>
          `;
                    });

                    $('.category_add').html(cate_option);
                    //Categories end

                    //Brands Start
                    let brands = response.data.brands;
                    let brand_option = ``;
                    $.each(brands, function(key, value) {
                        brand_option += `
              <option value="${value.id}">${value.name}</option>
          `;
                    });
                    $('.brand_add').html(brand_option);
                    //Brands end

                    //Colors Start
                    let colors = response.data.colors;
                    let color_option = ``;
                    $.each(colors, function(key, value) {
                        color_option += `
              <option value="${value.id}">${value.name}</option>
          `;
                    });

                    $('.color_add').html(color_option);





                    //Colors end
                }
            }
        });
    }

    const ProductUpload = (form) => {
        let payloads = new FormData($(form)[0]);
        $.ajax({
            type: "POST"
            , url: "{{ route('product.upload') }}"
            , data: payloads
            , dataType: "json"
            , contentType: false
            , processData: false
            , success: function(response) {
                if (response.status == 200) {
                    Message(response.message);

                    let images = response.images;
                    let img = ``;
                    $.each(images, function(key, value) {
                        img = `
                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                <input type="hidden" name="image_uploads[]" value="${value}">
                                <img class="w-100" src="{{ asset('uploads/temp/${value}') }}">
                                <button onclick="ProductCancelImage(this,'${value}')" type="button" class="btn btn-danger btn-sm ">cancel</button>
                            </div>
                        `;

                        if (form === '.formUpdateProduct') {
                            $('.show-images-edit').append(img);
                        } else if (form === '.formCreateProduct') {
                            $('.show-images').append(img);
                        }

                    });

                    $('.image').val("");

                }
            }
        });
    }

    const ProductCancelImage = (e, image) => {

        if (confirm("Do you want to cancel ?")) {
            $.ajax({
                type: "POST"
                , url: "{{ route('product.cancel') }}"
                , data: {
                    "image": image
                }
                , dataType: "json"
                , success: function(response) {
                    if (response.status == 200) {

                        Message(response.message);
                        $(e).parent().remove();

                    }
                }
            });
        }

    }

    const ProductStore = (form) => {
        let payloads = new FormData($(form)[0]);

        $.ajax({
            type: "POST"
            , url: "{{ route('product.store') }}"
            , data: payloads
            , dataType: "json"
            , contentType: false
            , processData: false
            , success: function(response) {
                if (response.status == 200) {
                    $(form).trigger("reset");
                    $('.show-images').html(" ");
                    $("#modalCreateProduct").modal('hide');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('input').removeClass("is-invalid").siblings("p").removeClass('text-danger').text(
                        " ")
                    Message(response.message);
                    ProductList();

                } else {
                    Message(response.message, false);

                    if (response.errors.title) {
                        $('.title_add').addClass("is-invalid").siblings("p").addClass('text-danger')
                            .text(response.errors.title)
                    } else {
                        $('.title_add').removeClass("is-invalid").siblings("p").removeClass(
                            'text-danger').text("")
                    }

                    if (response.errors.price) {
                        $('.price_add').addClass("is-invalid").siblings("p").addClass('text-danger')
                            .text(response.errors.price)
                    } else {
                        $('.price_add').removeClass("is-invalid").siblings("p").removeClass(
                            'text-danger').text("")

                    }

                    if (response.errors.qty) {
                        $('.qty_add').addClass("is-invalid").siblings("p").addClass('text-danger').text(
                            response.errors.qty)
                    } else {
                        $('.qty_add').removeClass("is-invalid").siblings("p").removeClass('text-danger')
                            .text("")
                    }
                }
            }
        });
    }

    const edit = (id) => {
        $(".show-images-edit").html(" ");
        $.ajax({
            type: "POST"
            , url: "{{ route('product.edit') }}"
            , data: {
                'id': id
            }
            , dataType: "json"
            , success: function(response) {
                if (response.status == 200) {

                    //assign id input id feild
                    $("#product_id").val(response.data.product.id);

                    //product 
                    $(".title_edit").val(response.data.product.name);
                    $(".price_edit").val(response.data.product.price);
                    $(".qty_edit").val(response.data.product.qty);
                    $(".desc_edit").val(response.data.product.desc);

                    //categories start
                    let categories = response.data.categories;
                    let cate_option = ``;
                    $.each(categories, function(key, value) {
                        cate_option += `
          <option value="${value.id}" ${(value.id == response.data.product.category_id) ? 'selected' : ''}>
            ${value.name}
          </option>
          `;
                    });

                    //inner to category edit 
                    $('.category_edit').html(cate_option);
                    //categories end
                }

                //brands start
                let brands = response.data.brands;
                let brand_option = ``;
                $.each(brands, function(key, value) {
                    brand_option += `
                    <option value="${value.id}" ${(value.id == response.data.product.brand_id)? 'selected' : ''}>
                        ${value.name}
                    </option>
                    `;
                });
                //inner to brand edit 
                $('.brand_edit').html(brand_option);
                //brands end


                //colors start
                let colors = response.data.colors;
                let color_ids = response.data.product.color; // 4,2,1

                //let find  = array.includes(5)  // => true or false => 1
                let color_option = ``;
                $.each(colors, function(key, value) {
                    if (color_ids.includes(String(value.id))) {
                        color_option += `
                          <option value="${value.id}" selected >${value.name}</option>`;
                    } else {
                        color_option += `
                        <option value="${value.id}">${value.name}</option>`;
                    }
                });
                //inner to color edit 
                $('.color_edit').html(color_option);
                //colors end


                //Images start
                let images = response.data.productImages;
                let img = ``;
                $.each(images, function(key, value) {
                    img = `
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <input type="hidden" name="old_image" value="${value.image}">
                            <img class="w-100" src="{{ asset('uploads/product/${value.image}') }}">
                            <button onclick="ProductCancelImage(this,'${value.image}')" type="button" class="btn btn-danger btn-sm ">cancel</button>
                        </div>`
                    $('.show-images-edit').append(img)
                });

            }
        });
    }

    const ProductUpdate = (form) => {
        let payloads = new FormData($(form)[0]);

        $.ajax({
            type: "POST"
            , url: "{{ route('product.update') }}"
            , data: payloads
            , dataType: "json"
            , contentType: false
            , processData: false
            , success: function(response) {
                if (response.status == 200) {
                    $(form).trigger("reset");
                    $('.show-images-edit').html(" ");
                    $("#modalUpdateProduct").modal('hide');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('input').removeClass("is-invalid").siblings("p").removeClass('text-danger').text(
                        " ")
                    Message(response.message);
                    ProductList();
                } else {
                    Message(response.message, false);

                    if (response.errors.title) {
                        $('.title_edit').addClass("is-invalid").siblings("p").addClass('text-danger')
                            .text(response.errors.title)
                    } else {
                        $('.title_edit').removeClass("is-invalid").siblings("p").removeClass(
                            'text-danger').text("")
                    }

                    if (response.errors.price) {
                        $('.price_edit').addClass("is-invalid").siblings("p").addClass('text-danger')
                            .text(response.errors.price)
                    } else {
                        $('.price_edit').removeClass("is-invalid").siblings("p").removeClass(
                            'text-danger').text("")

                    }

                    if (response.errors.qty) {
                        $('.qty_edit').addClass("is-invalid").siblings("p").addClass('text-danger')
                            .text(response.errors.qty)
                    } else {
                        $('.qty_edit').removeClass("is-invalid").siblings("p").removeClass(
                            'text-danger').text("")
                    }
                }
            }
        });

    }
    //Product delete 
    const ProductDelete = (id) => {
        if (confirm("Do you want to delete the product?")) {
            $.ajax({
                type: "POST"
                , url: "{{ route('product.destroy') }}"
                , data: {
                    "id": id
                }
                , dataType: "json"
                , success: function(response) {
                    if (response.status == 200) {
                        Message(response.message);

                        //Rendering product list
                        ProductList();

                    }
                }
            });
        }
    }

</script>
@endsection
