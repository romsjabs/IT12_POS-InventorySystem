<div class="items-wrapper">
    @forelse ($products as $product)
        <div class="item" data-name="{{ strtolower($product->product_name) }}" onclick="addToOrder({{ $product->id }})">
            <img id="item-image" 
                 src="{{ $product->product_image && Storage::disk('public')->exists($product->product_image) 
                     ? Storage::url($product->product_image) 
                     : asset('storage/defaults/product_image.png') }}"
                 alt="Product Image">
            <span class="item-name">{{ $product->product_name }}</span>
            @if ($product->product_stock <= 0)
                <div class="stock-label">
                    Not Available
                </div>
            @endif
        </div>
    @empty
        <div class="no-items">
            No items found.
        </div>
    @endforelse
</div>

<script>
    document.getElementById('products-search').addEventListener('input', function (e) {
    const searchValue = e.target.value.toLowerCase(); // Get the search input and convert to lowercase
    const items = document.querySelectorAll('.items-wrapper .item'); // Select all items

    items.forEach(item => {
        const itemName = item.getAttribute('data-name'); // Get the data-name attribute
        if (itemName.includes(searchValue)) {
            item.style.display = ''; // Show the item if it matches the search
        } else {
            item.style.display = 'none'; // Hide the item if it doesn't match
        }
    });

    // Handle "No items found" message
    const noItemsMessage = document.querySelector('.no-items');
    const visibleItems = Array.from(items).some(item => item.style.display !== 'none');
    if (noItemsMessage) {
        noItemsMessage.style.display = visibleItems ? 'none' : ''; // Show or hide the "No items found" message
    }
    });
</script>