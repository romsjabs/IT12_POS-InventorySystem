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
                    <input type="text" id="add-product-name" name="product_name" class="form-control" placeholder="Cappuccino Assassino" autocomplete="off" autocapitalize="words" autofocus>

                </div>

                <div class="product-image">

                    <label for="product-image">Product image</label>

                    <div class="product-image-wrapper">

                        <input type="file" name="product_image" accept="image/*" class="d-none" id="add-product-image">

                        <div class="preview-image">

                            <img id="add-product-image-preview" src="{{ asset('assets/img/product_image.png') }}" alt="Product Image" class="img-fluid" width="100">

                            <span class="enlarge-image">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                            
                        </div>

                        <div class="image-upload">
                            <button type="button" class="btn btn-primary" id="add-product-image-upload">Change image</button>
                        </div>

                    </div>

                </div>

                <div class="product-id">

                    <label for="product-id">Product ID</label>
                    <input type="text" value="{{ $nextProductId }}" name="product_id" id="add-product-id" class="form-control" autocomplete="off" readonly>
                    
                </div>

                <div class="product-category">

                    <label for="product-category">Category</label>
                    <select id="add-product-category" name="product_category" class="form-select">
                        <option selected disabled>Select..</option>
                        <option value="Iced Coffee">Iced Coffee</option>
                        <option value="Hot Coffee">Hot Coffee</option>
                        <option value="Food">Food</option>
                        <option value="Pastries">Pastries</option>
                        <option value="Beverages">Beverages</option>
                        <option value="Snacks">Snacks</option>
                        <option value="Desserts">Desserts</option>
                        <option value="other">Other..</option>
                    </select>

                </div>

                <div class="product-category-other">

                    <input type="text" name="product_category" id="add-product-category-other" class="form-control" placeholder="Custom.." autocomplete="off">

                </div>
                
                <div class="product-wrapper">

                    <div class="product-price">
                    
                        <label for="product-price">Price</label>
                        <input type="text" name="product_price" id="add-product-price" class="form-control money-input" placeholder="₱ 0.00">
                    
                    </div>

                    <div class="product-stock">

                        <label for="product-stock">Stock</label>
                        
                        <input type="text" name="product_stock" id="add-product-stock" class="form-control" placeholder="0" autocomplete="off">

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