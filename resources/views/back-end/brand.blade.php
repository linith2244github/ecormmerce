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
      @include('back-end.messages.brand.create')
      {{-- Modal end --}}

      {{-- Modal start --}}
      @include('back-end.messages.brand.edit')
      {{-- Modal end --}}
    
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Brands</h4>
                <p data-toggle="modal" data-target="#modalCreateBrand" id="addBrandBtn" class="card-description btn btn-primary ">new brand</p>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr> 
                    <th>Brand ID</th>
                    <th>Brand Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="brands_list">
                  
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="show-page mt-3">
              </div>
              <button class="btn btn-outline-info btn-sm rounded-0" onclick="BrandRefresh()">refresh</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section("scripts")
    <script>
      const BrandList = (page=1, search='') => {
        $.ajax({
          type: "POST",
          url: "{{ route('brand.list') }}",
          data: {
            "page" : page,
            "search" : search
          },
          dataType: "json",
          success: function (response) {
            if(response.status == 200){
              let brands = response.brands;
              console.log(brands);
              let tr = '';
              $.each(brands, function (key, value) { 
                tr += `<tr key=${key}>
                  <td>B00${key + 1}</td>
                  <td>${value.name}</td>
                  <td>${value.category.name}</td>
                  <td>
                      ${(value.status == 1) ? '<span class="p-2 badge badge-success text-light">Active</span>' : '<span class="p-2 text-light badge badge-danger">Inactive</span>'}
                    </td>
                  <td>
                      <a href="javascript:void(0)" onclick="BrandEdit(${value.id}, '${value.name}', ${value.category_id}, ${value.status})" data-toggle="modal" data-target="#modalUpdateBrand" class="btn btn-primary btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="BrandDelete(${value.id})" class="btn btn-danger btn-sm">Delete</a>
                  </td>     
                </tr>
                `;
              });
              $(".brands_list").html(tr);

              // pageination
              let totalPage = response.page.totalPage;
              let currentPage = response.page.currentPage;
              let page = ``;
              page = `
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">
                    <li class="page-item ${(currentPage == 1) ? 'disabled' : ''}" ${currentPage == 1 ? '' : `onclick="PreviousPage(${currentPage})"`} >
                      <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>`;
                    for(let i = 1; i <= totalPage; i++){
                      page += `
                        <li onclick="BrandPage(${i})" class="page-item ${(i == currentPage) ? 'active' : ''}">
                          <a class="page-link" href="javascript:void(0)">${i}</a>
                        </li>`;
                    }
                    page += `
                    <li class="page-item ${(currentPage == totalPage) ? 'disabled' : ''}" ${currentPage == totalPage ? '' : `onclick="NetPage(${currentPage})"`}>
                      <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              `;
              $(".show-page").html(page);
            }else{
              $(".brands_list").html('<tr><td colspan="5" class="text-center">No brands found</td></tr>');
            } 
          } 
        });
      }

      BrandList();
      const BrandRefresh = () => {
        BrandList();
        // ✅ Clear search input
        $("#searchInput").val('');
      }
      // search event
      $(document).on("click", "#searchBtn", function(){
        let search = $("#searchInput").val();
        $("#modalSearch").modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        BrandList(1, search);
        $("#searchInput").val('');
      });
      const SetFocus = () => {
        $('#modalSearch').on('shown.bs.modal', function () {
            $('#searchInput').trigger('focus');
        });
      }
      const BrandPage = (page) => {
        BrandList(page);
      }
      const NetPage = (page) => {
        BrandList(page + 1);
      }
      const PreviousPage = (page) => {
        BrandList(page - 1);
      }

      const BrandStore = (form) => {
        let payloads = new FormData($(form)[0]);
        $.ajax({
          type: "POST",
          url: "{{ route('brand.store') }}",
          data: payloads,
          dataType: "json",
          contentType: false,
          processData: false,
          success: function (response) {
            if(response.status == 200){
              $("#modalCreateBrand").modal('hide');
              $('.modal-backdrop').remove();
              $('body').removeClass('modal-open');
              $(form).trigger("reset");
              BrandList();
              $(".name").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
              Message(response.message);
            }else{
              let error = response.errors;
              if(error.name){
                $(".name").addClass('is-invalid').siblings('p').addClass('text-danger').text(error.name);
              }
            }
          }
        });
      }

      const BrandEdit = (id, name, category_id, status) => {
        $("#brand_id").val(id);
        $(".name_edit").val(name);
        $(".category_edit").val(category_id).trigger('change');
        $(".status_edit").val(status).trigger('change');
      };

      const BrandUpdate = (form) => {
        let payloads = new FormData($(form)[0]);
        $.ajax({
          type: "POST",
          url: "{{ route('brand.update') }}",
          data: payloads,
          dataType: "json",
          contentType: false,
          processData: false,
          success: function (response) {
            if(response.status == 200){
              $("#modalUpdateBrand").modal('hide');
              $('.modal-backdrop').remove();
              $('body').removeClass('modal-open');
              $(form).trigger("reset");
              BrandList();
              $(".name_edit").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
              Message(response.message);
            }else{
              let error = response.errors;
              if(error.name){ 
                $(".name_edit").addClass('is-invalid').siblings('p').addClass('text-danger').text(error.name);
              }
            }
          }
        });   
      }

      const BrandDelete = (id) => {
        if(confirm("Are you sure you want to delete this brand?")){
          $.ajax({
            type: "POST",
            url: "{{ route('brand.destroy') }}",
            data: {"id" : id},
            dataType: "json",
            success: function (response) {
              if(response.status == 200){
                BrandList();
                Message(response.message);
              }
            }
          });
        }
      }
  

      $(document).on('click', '#addBrandBtn', function(){
            $('#modalCreateBrand').modal('show');
        });

      $(document).on('click', '#searchBrandBtn', function(){
            $('#modalSearch').modal('show');
        });
    </script>

@endsection