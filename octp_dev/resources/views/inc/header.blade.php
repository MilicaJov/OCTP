<div class="imgcontainer">
    <img src = "{{asset('images/Logo.png')}}" alt = "OCTP" class = "logo">
</div>	
<div class = "meni">
    <ul>
        <li>
            <a href="/home">
                Home
            </a>
        </li>
        <li>
            <a href="About Us.html" class="dropbtn">
                About Us
            </a>
        </li>
        <li>
            <a href="/document/showAll" class="dropbtn">
                All documents
            </a>
        </li>
        @if (Auth::check())
        <li>
            <a href="/document/my" class="dropbtn">
                My documents
            </a>
        </li>
        <li>
            <a href="/document/create" class="dropbtn">
                Upload document
            </a>
        </li>
        @endif

        @if (Auth::check())
            <li style="float:right">
                <a href="{{ url('user/'.Auth::id()) }}">
                    My Profile
                </a>
            </li>
            <li style="float:right">
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @else
            <li style="float:right" class="dropdown">
                <a href="/login" class="dropbtn">
                    Login
                </a>
            </li>
            <li style="float:right" class="dropdown">
                <a href="/register" class="dropbtn">
                    Register
                </a>
            </li>
        @endif

    </ul>
</div>