<header>

    <div class="header wrapper">
    
        <div class="title">

            <span class="logo">

            </span>
            
            <span class="name">
                
                <a href="" id="title">
                    POS and Inventory System
                </a>

            </span>
            
        </div>

        <div class="header-buttons">

            <span class="original">

                <div class="profile">

                    <div class="profile-icon">
                        <img src="{{asset('assets/img/user_image.png')}}" alt="User" width="30" height="30" class="rounded-circle">
                    </div>

                    <div class="profile-name">
                        <span>
                            @if(Auth::user()->record)
                                {{ Auth::user()->record->lastname }},
                                {{ Auth::user()->record->firstname }}
                            @else
                                <span style="color:red;">No user record found!</span>
                            @endif
                        </span>
                    </div>

                </div>

                <div class="profile-menu">

                    <div class="profile-menu-button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-caret-down"></i>
                    </div>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    
                </div>

            </span>

            <span class="responsive">

                <div class="responsive-button" data-bs-toggle="offcanvas" data-bs-target="#responsive-menu" aria-controls="responsive-menu">
                    <i class="fa-solid fa-bars"></i>
                </div>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="responsive-menu">
                    <div class="offcanvas-header">
                        
                    </div>
                </div>

            </span>

        </div>

    </div>

</header>