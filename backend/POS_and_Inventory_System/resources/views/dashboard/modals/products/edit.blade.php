<!-- Edit -->
<div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editProductForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <input type="hidden" id="edit-product-id" name="product_id">

                    <div class="product-name">
                        <label for="product-name">Product name</label>
                        <input type="text" name="product_name" id="edit-product-name" class="form-control" placeholder="Chocolate">
                    </div>

                    <div class="product-image">

                        <label for="edit-product-image">Product image</label>

                        <div class="product-image-wrapper">

                            <input type="file" name="product_image" accept="image/*" class="d-none" id="edit-product-image">

                            <div class="preview-image">
                                
                                <img id="edit-product-image-preview" src="" alt="Product Image" class="img-fluid" width="100">
                                
                            </div>

                            <div class="image-upload">
                                <button type="button" class="btn btn-primary" id="edit-product-image-upload">Change image</button>
                            </div>

                        </div>

                    </div>

                    <div class="product-id">
                        <label for="edit-product-id">Product SKU/ID</label>
                        <input type="text" name="product_sku_id" id="edit-product-sku-id" class="form-control" placeholder="4-800020-021112">
                    </div>

                    <div class="product-category">
                        <label for="edit-product-category">Category</label>
                        <select name="product_category" id="edit-product-category" class="form-select">
                            <option selected disabled>Select..</option>
                            <option value="1">Category 1</option>
                            <option value="2">Category 2</option>
                        </select>
                    </div>

                    <div class="product-wrapper">
                        <div class="product-price">
                            <label for="edit-product-price">Price</label>
                            <input type="text" name="product_price" id="edit-product-price" class="form-control money-input" placeholder="₱ 0.00">
                        </div>
                        <div class="product-stock">
                            <label for="edit-product-stock">Stock</label>
                            <input type="text" name="product_stock" id="edit-product-stock" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>