@extends('layouts.dashboard')

@section('title', 'Sales')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style-dashboard-sales.css') }}">
@endsection

@section('content')
<div class="wrapper2">

    <h1>Sales</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="sales">

        <div class="sales-tab">

            <div class="sales-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="sales-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <!--<button id="addButton" type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">New</button>!-->
                <button type="button" id="exportButton" class="btn btn-primary btn-sm" btn>Export</button>

            </div>

        </div>

        <div class="sales-table">

            <table class="table table-hover products">

                <thead>
                    <tr>
                        <th class="table-row" scope="col">Date/Time</th>
                        <th class="table-row" scope="col">Sales ID</th>
                        <th class="table-row" scope="col">Recent Product</th>
                        <th class="table-row" scope="col">Total Items</th>
                        <th class="table-row" scope="col">Total Sales</th>
                        <th class="table-row" scope="col">Cashier</th>
                        <th class="table-row" scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="sales-table-body">
                @forelse ($salesByUser as $userId => $checkouts)
                    @php
                        $latestCheckout = $checkouts->sortByDesc('created_at')->first();
                        $salesNumber = $loop->iteration - 1;
                        $left = floor($salesNumber / 10000);
                        $right = $salesNumber % 10000;
                        $salesId = 'SALES-' . str_pad($left, 4, '0', STR_PAD_LEFT) . '-' . str_pad($right, 4, '0', STR_PAD_LEFT);
                        $userRecord = $latestCheckout->user->userRecord ?? null;
                    @endphp
                    <tr class="sales-row">
                        <td class="table-data">
                            {{ $latestCheckout->created_at
                            ->timezone('Asia/Manila')
                            ->format('Y-m-d h:i A') }}
                        </td>
                        <td class="table-data">
                            {{ $salesId }}
                        </td>
                        <td class="table-data">
                            {{ $latestCheckout->product->product_name ?? 'N/A' }}
                        </td>
                        <td class="table-data">
                            x{{ $checkouts->sum('quantity') }}
                        </td>
                        <td class="table-data">
                            ₱{{ number_format($checkouts->sum('total_price'), 2) }}
                        </td>
                        <td class="table-data">
                        @php
                            $userRecord = $latestCheckout->user->userRecord ?? null;
                        @endphp
                        @if($userRecord)
                            {{ strtoupper($userRecord->lastname) }}, {{ strtoupper($userRecord->firstname) }}
                        @else
                            N/A
                        @endif
                        </td>
                        <td class="table-data">
                            
                            <span class="view-btn">
                                <button type="button" class="btn btn-primary btn-sm view-sales" data-bs-toggle="modal" data-bs-target="#salesModal{{ $userId }}">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>View</span>
                                </button>
                            </span>

                        </td>
                    </tr>

                </tbody>
                @include('dashboard.modals.sales.info', [
                    'userId' => $userId,
                    'checkouts' => $checkouts,
                    'latestCheckout' => $latestCheckout,
                    'salesId' => $salesId,
                    'userRecord' => $userRecord,   
                ])
                @empty
                    <tr>
                        <td colspan="9" class="text-center fw-bold">No sales found.</td>
                    </tr>
                @endforelse
                    <tr id="sales-no-results" style="display: none;">
                        <td colspan="7" class="text-center fw-bold">No results found.</td>
                    </tr>
            </table>

        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    document.getElementById('exportButton').addEventListener('click', function() {
        window.location.href = "{{ route('dashboard.sales.export', ['date' => $date]) }}";
    });
</script>
@endsection