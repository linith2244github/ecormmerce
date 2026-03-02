<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Users</h1>
          {{-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form method="POST" class="formCreateUser">
              @csrf
                <div class="form-group">
                   <label for="fname">username</label>
                   <input type="text" name="name" class="name form-control" id="fname">
                   <p></p>
                  {{-- <p class="error-text"></p> --}}
                </div>

                <div class="form-group">
                  <label for="femail">email</label>
                  <input type="email" name="email" class="email form-control" id="femail">
                  <p></p>
                  {{-- <p class="error-text"></p> --}}
                </div>

                <div class="form-group">
                  <label for="fpassword">password</label>
                  <input type="password" name="password" class="password form-control" id="fpassword">
                  <p></p>
                  {{-- <p class="error-text"></p> --}}
                </div>

                <div class="form-group">
                  <label for="frole">Role</label>
                  <select name="role" class="role form-control" id="frole">
                    <option value="1">Admin</option>
                    <option value="0">User</option>
                  </select>
                  <p></p>
                  {{-- <p class="error-text"></p> --}}
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="StoreUser('.formCreateUser')" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>