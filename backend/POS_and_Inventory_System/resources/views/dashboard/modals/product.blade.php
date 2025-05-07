<!-- New Modal -->

<div class="modal fade" id="new-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                
            @csrf

            <!-- Error Display -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="modal-body">

                <div class="modal-container1"></div>
                <div class="modal-container2"></div>

                <div class="product-name">

                    <label for="product-name">Product name</label>
                    <input type="text" name="product_name" id="product-name" class="form-control" placeholder="Chocolate">

                </div>

                <div class="product-image">

                    <label for="product-image">Product image</label>

                    <div class="product-image-wrapper">

                        <input type="file" name="product_image" accept="image/*" class="d-none" id="real-product-image">

                        <div class="preview-image">

                            <img id="product-image" src="{{asset('assets/img/product_image.png')}}" alt="Product Image" class="img-fluid" width="100">

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
                    <input type="text" name="product_sku_id" id="product-id" class="form-control" placeholder="4-800020-021112">
                    
                </div>

                <div class="product-category">

                    <label for="product-category">Category</label>
                    <select name="product_category" id="product-category" class="form-select">
                        <option selected disabled>Select..</option>
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                    </select>

                </div>
                
                <div class="product-wrapper">

                    <div class="product-price">
                    
                        <label for="product-price">Price</label>
                        <input type="text" name="product_price" id="money" class="form-control money-input" placeholder="₱ 0.00">
                    
                    </div>

                    <div class="product-stock">

                        <label for="product-stock">Stock</label>
                        
                        <input type="text" name="product_stock" id="product-stock" class="form-control" placeholder="0">

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
<div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="edit-product-form" action="" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Error Display -->
                <div id="edit-modal-error" class="alert alert-danger alert-dismissible fade show d-none m-3" role="alert">
                    <ul id="edit-modal-error-list" class="mb-0"></ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <div class="modal-body">
                    <div class="product-name">
                        <label for="edit-product-name">Product name</label>
                        <input type="text" name="product_name" id="edit-product-name" class="form-control" placeholder="Chocolate">
                    </div>

                    <div class="product-image">
                        <label for="edit-product-image">Product image</label>
                        <div class="product-image-wrapper">
                            <input type="file" name="product_image" accept="image/*" class="d-none" id="edit-real-product-image">
                            <div class="preview-image">
                                <img id="edit-product-image" src="{{ asset('assets/img/product_image.png') }}" alt="Product Image" class="img-fluid" width="100">
                            </div>
                            <div class="image-upload">
                                <button type="button" class="btn btn-primary" id="edit-product-image-upload">Change image</button>
                            </div>
                        </div>
                    </div>

                    <div class="product-id">
                        <label for="edit-product-id">Product SKU/ID</label>
                        <input type="text" name="product_sku_id" id="edit-product-id" class="form-control" placeholder="4-800020-021112">
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

<!-- Delete -->

<script>
    // Check if there are validation errors and reopen the modal
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            var newModal = new bootstrap.Modal(document.getElementById('new-modal'));
            newModal.show();
        });
    @endif
</script>