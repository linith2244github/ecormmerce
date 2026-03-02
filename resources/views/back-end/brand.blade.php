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
            <table class="table table-striped">
              <thead>
                <tr> 
                  <th>Brand ID</th>
                  <th>Brand</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="brands_list">
                <tr>
                  <td>B001</td>
                  <td>Apple</td>
                  <td>
                    <span class="p-2 badge badge-success text-light">Active</span>
                    <span class="p-2 text-light badge badge-danger">Inactive</span>
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdateBrand">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
@endsection

@section("scripts")
    <script>




        $(document).on('click', '#addBrandBtn', function(){
            $('#modalCreateBrand').modal('show');
        });
    </script>

@endsection