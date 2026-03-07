@extends('back-end.components.master')
@section('contens')
     <!-- Page Title Header Starts-->
     <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <h4 class="page-title">Color</h4>
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
      @include('back-end.messages.color.create')
      {{-- Modal end --}}

      {{-- Modal start --}}
      @include('back-end.messages.color.edit')
      {{-- Modal end --}}
    
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Colors</h4>
                <p data-toggle="modal" data-target="#modalCreateColor" id="addColorBtn" class="card-description btn btn-primary ">new color</p>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr> 
                    <th>Color ID</th>
                    <th>Color Name</th>
                    <th>Color Code</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="colors_list">
                  
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

@section("scripts")
    <script>
        const ColorList = (page=1, search='') => {
        $.ajax({
          type: "POST",
          url: "{{ route('color.list') }}",
          data: {
            "page" : page,
            "search" : search
          },
          dataType: "json",
          success: function (response) {
            if(response.status == 200){
              let colors = response.colors;
              let tr = '';
              $.each(colors, function (key, value) { 
                console.log(value.id);
                tr += `<tr key=${key}>
                  <td>B00${value.id}</td>
                  <td>${value.name}</td>
                  <td>
                     <div style="background-color: ${value.color_code}; height: 20px; width: 20px; border-radius: 50%; border: 1px solid #000;"></div>
                  </td>
                  <td>
                      ${(value.status == 1) ? '<span class="p-2 badge badge-success text-light">Active</span>' : '<span class="p-2 text-light badge badge-danger">Inactive</span>'}
                    </td>
                  <td>
                      <a href="javascript:void(0)" onclick="ColorEdit(${value.id}, '${value.name}', '${value.color_code}', ${value.status})" data-toggle="modal" data-target="#modalUpdateColor" class="btn btn-primary btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="ColorDelete(${value.id})" class="btn btn-danger btn-sm">Delete</a>
                  </td>     
                </tr>
                `;
              });
              $(".colors_list").html(tr);

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
                        <li onclick="ColorPage(${i})" class="page-item ${(i == currentPage) ? 'active' : ''}">
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
              if(totalPage > 1){
                  $(".show-page").html(page);
              }
            }else{
              $(".colors_list").html('<tr><td colspan="5" class="text-center">No brands found</td></tr>');
            } 
          } 
        });
      }

      ColorList();
      ColorList();
      const ColorRefresh = () => {
        ColorList();
        // ✅ Clear search input
        $("#searchInput").val('');
      }
      // search event
      $(document).on("click", "#searchBtn", function(){
        let search = $("#searchInput").val();
        $("#modalSearch").modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        ColorList(1, search);
        $("#searchInput").val('');
      });
      const SetFocus = () => {
        $('#modalSearch').on('shown.bs.modal', function () {
            $('#searchInput').trigger('focus');
        });
      }

      const ColorPage = (page) => {
        ColorList(page);
      }
      const NetPage = (page) => {
        ColorList(page + 1);
      }
      const PreviousPage = (page) => {
        ColorList(page - 1);
      }

    const ColorStore = (form) => {
    let payloads = new FormData($(form)[0]);
    $.ajax({
        type: "POST",
        url: "{{ route('color.store') }}",
        data: payloads,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
        if(response.status == 200){
            $("#modalCreateColor").modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $(form).trigger("reset");
            ColorList();
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

      const ColorDelete = (id) => {
        if(confirm('Are you sure you want to delete this color?')){
            $.ajax({
              type: "POST",
              url: "{{ route('color.destroy') }}",
              data: {
                "id" : id
              },
              dataType: "json",
              success: function (response) {
                if(response.status == 200){
                    Message(response.message);
                    ColorList();
                }else{
                  Message(response.message, 'error');
                }
              }
            });
        }
      }

      const ColorEdit = (id, name, color_code, status) => {
        $("#color_id").val(id);
        $(".name_edit").val(name);
        $(".color_edit").val(color_code);
        $(".status_edit").val(status).trigger('change');
        // let option `
        //     <option value="1" ${(status == 1) ? 'selected' : ''}>Active</option>
        //     <option value="0" ${(status == 0) ? 'selected' : ''}>Inactive</option>
        // `;
        // $(".status_edit").html(option);
      }

      const ColorUpdate = (form) => {
        let payloads = new FormData($(form)[0]);
        $.ajax({
          type: "POST",
          url: "{{ route('color.update') }}",
          data: payloads,
          dataType: "json",
          contentType: false,
          processData: false,
          success: function (response) {
            if(response.status == 200){
              $("#modalUpdateColor").modal('hide');
              $('.modal-backdrop').remove();
              $('body').removeClass('modal-open');
              $(form).trigger("reset");
              $(".name_edit").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
              ColorList();
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
      
    </script>
@endsection