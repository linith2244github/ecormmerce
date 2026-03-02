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
      @include('back-end.messages.category.create')
      {{-- Modal end --}}

      {{-- Modal start --}}
      @include('back-end.messages.category.edit')
      {{-- Modal end --}}
    

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Categories</h4>
                <p data-toggle="modal" data-target="#modalCreateCategory" id="addCategoryBtn" class="card-description btn btn-primary ">new category</p>
            </div>
            <table class="table table-striped">
              <thead>
                <tr> 
                  <th>Category ID</th>
                  <th>Category</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="categories_list">
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
    <script>
        // JavaScript code for handling user interactions can be added here
        // Category List
        const CategoryList = () => {
          $.ajax({
            type: "POST",
            url: "{{route('category.list')}}",
            dataType: "json",
            success: function (response) {
              if(response.status == 200){
                let categories = response.categories;
                let tr = '';
                $.each(categories, function (key, value) { 
                  tr += `<tr key=${key}>
                    <td>Cate${value.id}</td>
                    <td>${value.name}</td>
                    <td>
                        <img src="{{ asset('uploads/category/${value.image}') }}" alt="image" />
                    </td>
                    <td>
                        ${(value.status == 1) ? '<span class="p-2 badge badge-success text-light">Active</span>' : '<span class="p-2 text-light badge badge-danger">Inactive</span>'}
                      </td>
                    <td>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalUpdateCategory" onclick="CategoryEdit(${value.id})" class="btn btn-primary btn-sm">Edit</a>
                      <a href="javascript:void(0)" onclick="CategoryDestroy(${value.id})" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                  </tr>
                  `;
                });
                $(".categories_list").html(tr);
              }else if(response.status == 404){
                $(".categories_list").html('<tr><td colspan="5" class="text-center">No categories found</td></tr>');
              } 
            }
          });

        }
        
        CategoryList();

         const StoreCategory = (form) => {
         let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{route('category.store')}}",
                data: payloads,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        // $(form)[0].reset();
                        $("#modalCreateCategory").modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        // Reset form and clear errors
                        $(form).trigger('reset');
                        $(`.name`).removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                        $(".show-image-category").html('');
                        CategoryList();
                        Message(response.message);
                    }else{
                        let errors = response.errors;
                        if(errors.name){
                        $(`.name`).addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.name);
                        }else{
                            $(`.name`).removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                        }
                    }
                }
            });
        }

        const UploadImage = (form) => {
          let payload = new FormData($(form)[0]);
          $.ajax({
            type: "POST",
            url: "{{ route('category.upload') }}",
            data: payload,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
              if(response.status == 200){
                let img = `
                      <input type="hidden" name="category_image" value="${response.image}">
                      <img src="{{ asset('uploads/temp/${response.image}' )}}" style="width: 50px" alt="image" />
                      <button type="button" onclick="CancelImage('${response.image}')" class="btn btn-danger btn-sm rounded-0 btn_cancel">Cancel</button>
                    `;
                $('.show-image-category').html(img);
                $('.image').val("");
                $('.image').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");
              }else{
                let errors = response.errors;
                $('.image').addClass('is-invalid').siblings('p').addClass('text-danger').text(response.errors.image);
              }
            }
          });
        }

        const CancelImage = (img) => {
          if(confirm('Are you sure you want to cancel?')){
            $.ajax({
              type: "POST",
              url: "{{ route('category.cancel') }}",
              data: {
                "image" : img
              },
              dataType: "json",
              success: function (response) {
                if(response.status == 200){
                  $('.show-image-category').html('');

                  Message(response.message);
                }
              }
            });
          }
        }

        const CategoryEdit= (id) => {
            $.ajax({
                method: "POST",
                url: "{{ route('category.edit') }}", /// Make sure this route exists in Laravel
                data: {"id": id},
                dataType: "json",
                success: function(response){
                    if(response.status == 200){
                      $("#category_id").val(response.category.id);
                        $(".name_edit").val(response.category.name);
                        $(".status_edit").val(response.category.status);
                        $('.show-image-category-edit').html('');
                        if(response.category.image != null){
                          let img = `
                            <input type="hidden" name="old_image" value="${response.category.image}">
                            <img src="{{ asset('uploads/category/${response.category.image}' )}}" style="width: 60px" alt="image" />
                          `;
                          $('.show-image-category-edit').html(img);
                        }else{
                          $('.show-image-category-edit').html('');
                        }
                        // $("#modalUpdateCategory").modal('show');
                    } 
                },
                error: function(xhr, status, error){
                    console.error(error);
                    Message('Something went wrong!', 'error');
                }
            });
        }

        const UpdateCategory = (form) => {
         let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{route('category.update')}}",
                data: payloads,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        // $(form)[0].reset();
                        $("#modalUpdateCategory").modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        // Reset form and clear errors
                        $(form).trigger('reset');
                        $(`.name_edit`).removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                        $(".show-image-category-edit").html('');
                        CategoryList();
                        Message(response.message);
                    }else{
                        let errors = response.errors;
                        if(errors.name){
                        $(`.name_edit`).addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.name);
                        }else{
                            $(`.name_edit`).removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                        }
                    }
                }
            });
        }

        const CategoryDestroy = (id) => {
          if(confirm('Are you sure you want to delete this category?')){
            $.ajax({
              type: "POST",
              url: "{{route('category.destroy')}}",
              data: {"id": id},
              dataType: "json",
              success: function (response) {
                if(response.status == 200){
                  CategoryList();
                  Message(response.message);
                }else{
                  Message(response.message, 'error');
                }
              }
            });
          }
        }       

        $(document).on('click', '#addCategoryBtn', function(){
            $('#modalCreateCategory').modal('show');
        });
    </script>
@endsection