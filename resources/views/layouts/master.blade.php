<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> @yield('title') @isset($title)
            {{ $title }} |
        @endisset Score Board</title>
    <link rel="icon" href="{{ asset('fab-icon.png') }}" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
@php $league = Helper::league(); @endphp

<body>
    <header>
        <div class="super-section">
            <div class="text-white container ">
                <h5>
                    <marquee direction="left">
                        @if (@$league->name)
                            League Name : {{ $league->name }}, Duration :
                            {{ Carbon\Carbon::parse($league->start_date)->format('M-d, Y') }} To
                            {{ Carbon\Carbon::parse($league->end_date)->format('M-d, Y') }}, Status :
                            {{ Helper::leagueStatus() }}
                        @else
                            League is not Added
                        @endif
                    </marquee>
                </h5>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg">
            <div class="container text-white">
                <a class="navbar-brand text-white" href="{{ route('client.index') }}"> Score Board</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('client.index') ? 'active' : '' }}"
                                href="{{ route('client.index') }}">Home</a>
                        </li>
                        @auth
                            @can('Admin')
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('league.*') ? 'active' : '' }}"
                                        href="{{ route('league.index') }}">League</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('player.*') ? 'active' : '' }}"
                                        href="{{ route('player.index') }}">Players</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('team.*') ? 'active' : '' }}"
                                        href="{{ route('team.index') }}">Teams</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('match.*') ? 'active' : '' }}"
                                        href="{{ route('match.index') }}">Matches</a>
                                </li>
                            @endcan
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                    class="nav-link dropdown-toggle {{ request()->routeIs('home', 'user.*') ? 'active' : '' }}"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="fas fa-user"></i> {{ auth()->user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item {{ request()->routeIs('home') ? 'active' : '' }}"
                                        href="{{ route('home') }}">Dashboard </a>
                                    @can('Admin')
                                        <a class="dropdown-item {{ request()->routeIs('user.*') ? 'active' : '' }}"
                                            href="{{ route('user.index') }}">Users </a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                            </li>
                        @endauth



                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    @if (Session::has('message'))
        <p id="pnotify-solid-success" hidden>{{ Session::get('message') }}</p>
    @endif
    @if (Session::has('errors'))
        <p id="pnotify-solid-warning" hidden>{{ Session::get('errors')->first() }}</p>
    @endif

    <footer class="footer">
        <p>@ {{ date('Y') }} Designed by <a href="https://amitdhakal.com.np/" target="_blank">Amit Dhakal</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>


    <script src="{{ asset('/js/pnotify.min.js') }}"></script>
    <script src="{{ asset('/js/extra_pnotify.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#pnotify-solid-success").trigger('click');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#pnotify-solid-warning").trigger('click');
        });
    </script>

    <script>
        new DataTable("#example");
    </script>
    @yield('custom-script')

</body>

</html>
