<!DOCTYPE html>
<html>
<head>
    <title>Session Expired</title>
</head>
<body>
    <h2>Session Expired</h2>
    <p>Your session has expired due to inactivity. Please log in again.</p>
    <a  href="{{ route('customlogout') }}"
                   >
                   <!--a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"-->
                   <i class="bx bx-power-off me-2"></i>
                   <span class="align-middle">Log Out</span>
                   </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                  </form>
</body>
</html>
