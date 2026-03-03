<div class="modal fade" id="modalCreateColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Color</h1>
          {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form method="POST" class="formCreateColor">
              @csrf
                <div class="form-group">
                   <label for="cname">Color Name</label>
                   <input type="text" name="name" class="name form-control" id="cname">
                   <p></p>
                </div>
                <div class="form-group">
                   <label for="ccolor">Color Code</label>
                   <input type="color" name="color_code" class="color_code form-control" id="ccolor">
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
          <button type="button" onclick="ColorStore('.formCreateColor')" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>