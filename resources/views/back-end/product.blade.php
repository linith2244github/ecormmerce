@extends('back-end.components.master')
@section('contens')
     <!-- Page Title Header Starts-->
     <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li><a href="#">ICE Market data</a></li>
                <li><a href="#">Own analysis</a></li>
                <li><a href="#">Historic market data</a></li>
              </ul>
              <ul class="quick-links ml-auto">
                <li><a href="#">Settings</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Watchlist</a></li>
              </ul>
            </div>
          </div>
        </div> 
      </div>
      <!-- Page Title Header Ends-->

      {{-- Modal start --}}
      @include('back-end.messages.product.create')
      {{-- Modal end --}}

      {{-- Modal start --}}
      @include('back-end.messages.product.edit')
      {{-- Modal end --}}
    
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Products</h4>
                <p onclick="handleClickButtonNewProduct()" data-toggle="modal" data-target="#modalCreateProduct" id="addProductBtn" class="card-description btn btn-primary ">new product</p>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
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
                <tbody class="colors_list">
                  <tr>
                    <td>P001</td>
                    <td><img src="https://via.placeholder.com/150" alt="image"></td>
                    <td>I Phone 12</td>
                    <td>Phone</td>
                    <td>Apple</td>
                    <td>$450</td>
                    <td>10</td>
                    <td>
                      <span class="p-2 badge badge-success text-light">In Stock</span>
                      <span class="p-2 badge badge-warning text-light">Low Stock</span>
                      {{-- <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1"></label>
                      </div> --}}
                    </td>
                    <td>
                      <span class="p-2 badge badge-success text-light">Active</span>
                      <span class="p-2 badge badge-danger text-light">Inactive</span>
                    </td>
                    <td>
                      <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdateProduct" id="addProductBtn">Edit</a>
                      <a href="javascript:void(0)" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="show-page mt-3">
              </div>
              <button class="btn btn-outline-info btn-sm rounded-0" onclick="ColorRefresh()">refresh</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
  <script>
    const ProductList = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('product.list') }}",
        dataType: "json",
        success: function (response) {
          
        }
      });
    }
    ProductList();

    const UploadImage = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        url: "{{ route('product.upload') }}",
        type: "POST",
        data: payloads,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {  
          if(response.status == 200){
            Message(response.message);
            let images = response.images;
            console.log(images);
            let img = ``;
            $.each(images, function (key, value) { 
               img += `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                      <input type="hidden" name="image_uploads[]" value="${value}">
                      <img src="{{ asset('uploads/temp/${value}' )}}" style="height: 150px; width: 150px" alt="image" class="w-100" />
                      <button type="button" onclick="CancelImage(this,'${value}')" class="btn btn-danger btn-sm rounded-0 btn_cancel">Cancel</button>
                    </div>
                `;
            });
            $(".show-images").append(img);
          }
          $("#upload_image").val("");
        }
      });
    }
    const CancelImage = (e, img) => {
      if(confirm('Are you sure you want to cancel?')){
        $.ajax({
          type: "POST",
          url: "{{ route('product.cancel') }}",
          data: {
            "image" : img
          },
          dataType: "json",
          success: function (response) {
            if(response.status == 200){
              Message(response.message);
              $(e).parent().remove();
            }
          }
        });
      }
    }

    const handleClickButtonNewProduct = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('product.data') }}",
        dataType: "json",
        success: function (response) {
          if(response.status == 200){
            //Category start
            let categories = response.data.categories;
            console.log(categories);
            let cate_option = ``;
            $.each(categories, function (key, value) { 
              cate_option += `
                <option value="${value.id}">${value.name}</option>
              `;
            });
            $(".category_add").html(cate_option);
            //Category end

            //Brand start
            let brands = response.data.brands;
            let bran_option = ``;
            $.each(brands, function (key, value) { 
              bran_option += `
                <option value="${value.id}">${value.name}</option>
              `;
            });
            $(".brand_add").html(bran_option);
            //Brand end

            //Color start
            let colors = response.data.colors;
            let color_option = ``;
            $.each(colors, function (key, value) { 
              color_option += `
                <option value="${value.id}">${value.name}</option>
              `;
            });
            $(".color_add").html(color_option);
            //Color end
          }
        }
      });
    }
    $(document).ready(function () {
      $('#color_add').select2({  
        placeholder: 'Select options',  
        allowClear: true,  
        tags: true, 
      }); 
    });

    const ProductStore = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('product.store') }}",
        data: payloads,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {  
          if(response.status == 200){
            $(form).trigger("reset");
            $(".show-images").html('');
            $("#modalCreateProduct").modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('input').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
            Message(response.message);
            ProductList();
          }else{
            Message(response.message, false);
            let error = response.errors;
            if(error.title){
              $(".title_add").addClass('is-invalid').siblings('p').addClass('text-danger').text(error.title);
            }else{
              $(".title_add").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
            }
            if(error.price){
              $(".price_add").addClass('is-invalid').siblings('p').addClass('text-danger').text(error.price);
            }else{
              $(".price_add").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
            }
            if(error.qty){
              $(".qty_add").addClass('is-invalid').siblings('p').addClass('text-danger').text(error.qty);
            }else{
              $(".qty_add").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
            }
          }
        }
      });
    }
  </script>
@endsection