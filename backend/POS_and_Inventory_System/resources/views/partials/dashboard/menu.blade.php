<div class="wrapper1">

<div class="menu">

    <a href="{{ route('dashboard.home') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.home') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">

        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-house-chimney"></i>
            </span>
            
            <span class="label">Home</span>

        </div>

    </a>

    <a href="{{ route('dashboard.attendance') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.attendance') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">

        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-clipboard-user"></i>
            </span>
            
            <span class="label">Attendance</span>

        </div>

    </a>

    <a href="{{ route('dashboard.details') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.details') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">

        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-circle-info"></i>
            </span>
            
            <span class="label">Details</span>

        </div>

    </a>

    <a href="{{ route('dashboard.products') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.products') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">
        
        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </span>
            
            <span class="label">Products</span>

        </div>

    </a>

    <a href="{{ route('dashboard.checkouts') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.checkouts') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">
        
        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </span>
            
            <span class="label">Checkouts</span>

        </div>

    </a>

    <a href="{{ route('dashboard.users') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.users') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">

        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-users"></i>
            </span>
            
            <span class="label">Users</span>

        </div>

    </a>

    <a href="{{ route('dashboard.sales') }}" class="d-flex gap-1" style="{{ request()->routeIs('dashboard.sales') ? 'background-color: #1b4c4c; border-radius: 8px;' : '' }}">
        
        <div class="menu-item">

            <span class="icon">
                <i class="fa-solid fa-money-bills"></i>
            </span>
            
            <span class="label">Sales</span>

        </div>

    </a>

</div>

</div>