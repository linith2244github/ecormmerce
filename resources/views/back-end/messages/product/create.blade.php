{{-- Modal Product --}}
<div class="modal fade" id="modalCreateProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" style="max-width: 80%;"> 
      <div class="modal-content"> 
        <div class="modal-header"> 
          <h1 class="modal-title fs-5" id="exampleModalLabel">Creatting Product</h1> 
        </div> 
        <div class="modal-body"> 
            <form  class="formCreateProduct" method="POST" enctype="multipart/form-data"> 
                @csrf
                <div class="row"> 
 
                    <div class="col-lg-8"> 
 
                        <div class="form-group"> 
                            <label for="title">Product Title</label> 
                            <input type="text" class="title_add form-control" name="title"> 
                            <p></p>
                        </div> 
 
                        <div class="form-group"> 
                            <label for="name">Description</label> 
                            <textarea name="desc" id="desc" class="desc_add form-control" rows="10"></textarea> 
                        </div> 
 
                        <div class="form-group"> 
                            <label for="price">Product Price</label> 
                            <input type="text" class="price_add form-control" name="price"> 
                            <p></p>
                        </div> 
 
                        <div class="form-group"> 
                            <label for="qty">Product Quantity</label> 
                            <input type="text" class="qty_add form-control"  name="qty"> 
                            <p></p>
                        </div> 
 
                        <div class="form-group"> 
                            <label for="">Product Image</label> 
                            <input type="file" id="upload_image" class="image form-control" multiple name="image[]"> 
                            <button type="button" onclick="UploadImage('.formCreateProduct')" class=" btn btn-primary upload_images">Uploads</button> 
                        </div>
                        
                        <div class="show-images row">

                        </div>
                    </div> 
 
                    <div class="col-lg-4"> 
                        <div class="form-group"> 
                            <label for="">Category</label> 
                            <select name="category"  class="category_add form-control"> 

                            </select> 
                        </div> 
                    <div class="form-group"> 
                        <label for="">Brand</label> 
                       
                        <select name="brand" id="brand" class="brand_add form-control"> 
                            
                        </select> 
                    </div> 
 
                    <div class="form-group"> 
                        <label for="">Color</label> 
                        <select name="color[]" id="color_add" style="width : 100%" class="color_add form-control" multiple ="multiple"> 
                      
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
          <button onclick="ProductStore('.formCreateProduct')" type="button" class="btn btn-primary">Save</button> 
        </div> 
      </div> 
    </div> 
 </div>
{{-- End Modal Product --}}