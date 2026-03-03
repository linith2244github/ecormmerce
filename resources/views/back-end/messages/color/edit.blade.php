<div class="modal fade" id="modalUpdateColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Updating Color</h1>
          {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form method="POST" class="formUpdateColor">
              @csrf
                <div class="form-group">
                  <input type="hidden" name="color_id" class="color_id form-control" id="color_id">
                   <label for="cname">Color Name</label>
                   <input type="text" name="name" class="name name_edit form-control" id="cname">
                   <p></p>
                </div>
                <div class="form-group">
                   <label for="ccolor">Color Code</label>
                   <input type="color" name="color_code" class="color_code color_edit form-control" id="ccolor">
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
          <button type="button" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
</div>