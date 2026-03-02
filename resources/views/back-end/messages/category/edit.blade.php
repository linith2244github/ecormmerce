<div class="modal fade" id="modalUpdateCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Updating Category</h1>
          {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form method="POST" id="formUpdateCategory" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                  <input type="hidden" name="category_id" id="category_id">
                   <label for="cname">Category</label>
                   <input type="text" name="name" class="name name_edit form-control" id="cname">
                   <p></p>
                  {{-- <p class="error-text"></p> --}}
                </div>

                <div class="form-group">
                  <label for="cimage">Image</label>
                  <input type="file" class="image image_edit form-control rounded-0" id="cimage" name="image">
                  <button type="button" onclick="UploadImage('#formUpdateCategory')" class="btn-sm btn btn-success rounded-0 btn_upload">upload</button>
                  <p></p>
                </div>
                <div class="show-image-category show-image-category-edit form-group">

                </div>

                <div class="form-group">
                  <label for="cstatus">Status</label>
                  <select name="status" class="status status_edit form-control" id="cstatus">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                  {{-- <p class="error-text"></p> --}}
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="UpdateCategory('#formUpdateCategory')" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
</div>