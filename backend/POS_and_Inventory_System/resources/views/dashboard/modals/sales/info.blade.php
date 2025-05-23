<div class="modal fade" id="salesModal{{ $userId }}" tabindex="-1" aria-labelledby="salesModalLabel{{ $userId }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel{{ $userId }}">Sales Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Date/Time:</strong> {{ $latestCheckout->created_at->timezone('Asia/Manila')->format('Y-m-d h:i') }}</p>
                <p><strong>Sales ID:</strong> {{ $salesId }}</p>
                <p><strong>Products:</strong></p>
                <ul>
                    @foreach ($checkouts->sortByDesc('created_at') as $checkout)
                        <li>
                            {{ $checkout->product->product_name ?? 'N/A' }} (x{{ $checkout->quantity }}) - ₱{{ number_format($checkout->total_price, 2) }}
                        </li>
                    @endforeach
                </ul>
                <p><strong>Total Sales:</strong> ₱{{ number_format($checkouts->sum('total_price'), 2) }}</p>
                <p><strong>Cashier:</strong>
                    @if($userRecord)
                        {{ strtoupper($userRecord->lastname) }}, {{ strtoupper($userRecord->firstname) }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>