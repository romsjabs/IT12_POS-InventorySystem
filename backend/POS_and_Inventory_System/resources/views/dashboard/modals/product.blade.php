<!-- New Modal -->

<div class="modal fade" id="new-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">

                <div class="modal-container1"></div>
                <div class="modal-container2"></div>

                <div class="product-name">

                    <label for="product-name">Product name</label>
                    <input type="email" name="product-name" id="product-name" class="form-control" placeholder="Chocolate">

                </div>

                <div class="product-image">

                    <label for="product-image">Product image</label>

                    <div class="product-image-wrapper">

                        <input type="file" name="product-image" accept="image/*" class="d-none" id="real-product-image">

                        <div class="preview-image">

                            <img id="product-image" src="assets/img/product_image.png" alt="Product Image" class="img-fluid" width="100">

                            <span class="enlarge-image">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                            
                        </div>

                        <div class="image-upload">
                            <button type="button" class="btn btn-primary" id="product-image-upload">Change image</button>
                        </div>

                    </div>

                </div>

                <div class="product-id">

                    <label for="product-id">Product SKU/ID</label>
                    <input type="text" name="product-id" id="product-id" class="form-control" placeholder="4-800020-021112">
                    
                </div>

                <div class="product-category">

                    <label for="product-category">Category</label>
                    <select name="product-category" id="product-category" class="form-select">
                        <option selected disabled>Select..</option>
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                    </select>

                </div>
                
                <div class="product-wrapper">

                    <div class="product-price">
                    
                        <label for="product-price">Price</label>
                        <input type="text" name="product-price" id="money" class="form-control money-input" placeholder="₱ 0.00">
                    
                    </div>

                    <div class="product-stock">

                        <label for="product-stock">Stock</label>
                        
                        <input type="text" name="product-stock" id="product-stock" class="form-control" placeholder="0">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>

            </div>
        </div>
    </div>
</div>

<!-- Preview Image -->

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-body text-center">
            <img id="modal-preview-image" src="" alt="Enlarged Product Image" class="img-fluid">
        </div>
        </div>
    </div>
    </div>

<!-- Edit -->

<!-- Delete -->