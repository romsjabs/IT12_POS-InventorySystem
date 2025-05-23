<div id="receipt-modal" class="modal d-none">
    <div class="modal-content" id="receipt-content" style="font-family: monospace; width: 320px; margin: auto; padding: 20px; background: #fff;">
        <h2 style="text-align: center; margin-bottom: 10px;">{{ $store_name ?? 'My Store' }}</h2>
        <p style="text-align: center; margin: 0;">{{ $store_address ?? '123 Main St.' }}</p>
        @if(!empty($store_contact))
            <p style="text-align: center; margin: 0;">Contact: {{ $store_contact }}</p>
        @endif
        @if(!empty($store_tin))
            <p style="text-align: center; margin: 0;">TIN: {{ $store_tin }}</p>
        @endif
        <hr>
        <p>Date: {{ $date ?? now() }}</p>
        <p>Transaction #: {{ $transaction_id ?? '000001' }}</p>
        <hr>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="text-align:left;">Item</th>
                    <th style="text-align:right;">Qty</th>
                    <th style="text-align:right;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items ?? [] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td style="text-align:right;">{{ $item['quantity'] }}</td>
                    <td style="text-align:right;">₱{{ number_format($item['total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <p style="text-align:right;">Subtotal: ₱{{ number_format($subtotal ?? 0, 2) }}</p>
        <p style="text-align:right;">Discount: ₱{{ number_format($discount ?? 0, 2) }}</p>
        <p style="text-align:right; font-weight:bold;">Total: ₱{{ number_format($total ?? 0, 2) }}</p>
        <p style="text-align:right;">Cash: ₱{{ number_format($cash ?? 0, 2) }}</p>
        <p style="text-align:right;">Change: ₱{{ number_format($change ?? 0, 2) }}</p>
        <hr>
        <p style="text-align: center;">Thank you for shopping!</p>
    </div>
</div>