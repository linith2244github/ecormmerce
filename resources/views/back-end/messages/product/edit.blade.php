{{-- Modal Product --}}
<div class="modal fade" id="modalUpdateProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" style="max-width: 80%;"> 
      <div class="modal-content"> 
        <div class="modal-header"> 
          <h1 class="modal-title fs-5" id="exampleModalLabel">Updating Product</h1> 
        </div> 
        <div class="modal-body"> 
            <form  class="formUpdateProduct" method="POST" enctype="multipart/form-data"> 
                @csrf
                <div class="row"> 
 
                    <div class="col-lg-8"> 
 
                        <div class="form-group"> 
                            <label for="title">Product Name</label> 
                            <input type="text" class="title form-control" name="title" required> 
                        </div> 
 
                        <div class="form-group"> 
                            <label for="name">Description</label> 
                            <textarea name="desc" id="desc" class="desc form-control" rows="10"></textarea> 
                        </div> 
 
                        <div class="form-group"> 
                            <label for="price">Product Price</label> 
                            <input type="text" class="price form-control" name="price" required> 
                        </div> 
 
                        <div class="form-group"> 
                            <label for="qty">Product Quantity</label> 
                            <input type="text" class="qty form-control"  name="qty" required> 
                        </div> 
 
                        <div class="form-group"> 
                            <label for="">Product Image</label> 
                            <input type="file" id="image" class="image form-control" multiple name="image[]" required> 
                            <button type="button" onclick="UploadImage('.formCreateProduct')" class=" btn btn-primary upload_images">Uploads</button> 
                        </div>
                        
                        <div class="show-images row">
                          
                        </div>
     
                    </div> 
 
                    <div class="col-lg-4"> 
                        <div class="form-group"> 
                            <label for="">Category</label> 
                            <select name="category"  class="category form-control"> 
                            </select> 
                        </div> 
                     
 
                    <div class="form-group"> 
                        <label for="">Brand</label> 
                       
                        <select name="brand" id="brand" class="brand form-control"> 
                            
                        </select> 
                    </div> 
 
                    <div class="form-group"> 
                        <label for="">Color</label> 
                        <select name="color[]" id="color" style="width : 100%" class="color form-control" multiple ="multiple"> 
                      
                        </select> 
                    </div> 
 
                    <div class="form-group"> 
                        <label for="">Releated Product</label> 
                        <select name="reteated" id="reteated" class=" form-control"> 
                            <option value="">Select Color</option> 
                            <option value="">red</option> 
                        </select> 
                    </div> 
 
                    <div class="form-group"> 
                        <label for="">Status</label> 
                        <select name="status" id="status" class="status form-control"> 
                            <option value="1">Active</option> 
                            <option value="0">Block</option> 
                        </select> 
                    </div> 
 
                </div> 
 
 
                </div> 
 
            </form> 
        </div> 
        <div class="modal-footer"> 
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
          <button onclick="StoreProduct('.formCreateProduct')" type="button" class="btn btn-primary">Update</button> 
        </div> 
      </div> 
    </div> 
 </div>
{{-- End Modal Product --}}