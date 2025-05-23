<header>

    <div class="est-name">
        POS and Inventory System
    </div>

    <!-- Tab Navigation -->

    <div class="version">

        <span>
            <span><i class="fa-solid fa-circle-info"></i></span>
            <span>Version</span>
        </span>

        <span>1.0.0</span>

    </div>

    <div class="date-time">

        <div class="date">
        
            <span><i class="fa-solid fa-calendar-days"></i></span>
            <span id="current-date"></span>

        </div>

        <div class="time">

            <span><i class="fa-regular fa-clock"></i></span>
            <span id="current-time"></span>

        </div>

    </div>    

    <div class="sales">

        <span>
            <span><i class="fa-solid fa-money-bill"></i></span>
            <span>Sales</span>
        </span>

        <span class="count">₱ {{ number_format($salesCount ?? 0, 2) }}</span>

    </div>

    <div class="checkouts">

        <span>
            <span><i class="fa-solid fa-cart-shopping"></i></span>
            <span>Checkouts</span>
        </span>

        <span class="count">{{ number_format($checkoutsCount) }}</span>

    </div>

    <div class="user">

        <span><i class="fa-solid fa-circle-user"></i></span>
        <span class="username">
            @if(Auth::user()->record)
                {{ Auth::user()->record->lastname }}, {{ Auth::user()->record->firstname }}
            @else
                <span style="color:red;">No user record!</span>
            @endif
        </span>

    </div>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <span><i class="fa-solid fa-right-from-bracket"></i></span>
                <span>Logout</span>
            </button>
        </form>
    </div>

</header>