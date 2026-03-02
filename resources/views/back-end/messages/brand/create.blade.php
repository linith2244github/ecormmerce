<div class="modal fade" id="modalCreateBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Brand</h1>
          {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form method="POST" class="formCreateBrand">
              @csrf
                <div class="form-group">
                   <label for="bname">Brand</label>
                   <input type="text" name="name" class="name form-control" id="bname">
                   <p></p>
                </div>
                <div class="form-group">
                  <label for="bstatus">Category</label>
                  <select name="category" class="category form-control" id="bcategory">
                    @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="bstatus">Status</label>
                  <select name="status" class="status form-control" id="bstatus">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="BrandStore('.formCreateBrand')" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>