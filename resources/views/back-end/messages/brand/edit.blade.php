<div class="modal fade" id="modalUpdateBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Updating Brand</h1>
          {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form method="POST" class="formUpdateBrand">
              @csrf
                <div class="form-group">
                  <input type="hidden" name="brand_id" id="brand_id">
                   <label for="bname">Brand</label>
                   <input type="text" name="name" class="name name_edit form-control" id="bname">
                   <p></p>
                </div>
                <div class="form-group">
                  <label for="bstatus">Category</label>
                  <select name="category" class="category category_edit form-control" id="bcategory">
                    @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="bstatus">Status</label>
                  <select name="status" class="status status_edit form-control" id="bstatus">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="BrandUpdate('.formUpdateBrand')" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
</div>