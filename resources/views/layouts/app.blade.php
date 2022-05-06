<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Website Icon-->
        <link rel="icon" href="{{asset('img/favicon.png')}}">

        <!--the title of the current page-->
        <title>@yield('pageTitle')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


        <!-- Styles -->
        <link href="{{ asset('css/app.css') . "?" . time() }}" rel="stylesheet"> <!--Template Style-->
        <link href="{{ asset('css/media_query.css') . "?" . time() }}" rel="stylesheet"> <!--Template responsive Style-->

        @stack('styles')

    </head>

    <body>

        <!--main container-->
        <div class="container">

            <!--Hearder Section-->
            <header class="">
                <div class="navbar">

                    <!--menu button for small screens-->
                    <button class="navbar-menu-btn">
                        <span class="one"></span>
                        <span class="two"></span>
                        <span class="three"></span>
                    </button>


                    <!--Logo-->
                    <a href="{{route('home')}}" class="navbar-logo">
                        <img src="{{asset('img/logo.png')}}" alt="">
                    </a>


                    <!--navbar navigation-->
                    <nav class="">
                        <ul class="navbar-nav">
                            <li><a href="{{route('home')}}" class="navbar-link">Home</a></li>
                            <li><a href="/AllMovies/1" class="navbar-link">Movies</a></li>
                            <li><a href="#" class="navbar-link">Trending</a></li>
                            <li><a href="{{route('bookmarked')}}" class="navbar-link">Bookmarked</a></li>



                        </ul>
                    </nav>

                    <!--Search-->
                    <div class="navbar-actions">

                        <form action="#" class="navbar-form" autocomplete="off">

                            <input type="text" name="search" id="" placeholder="looking for something ?..." class="navbar-form-search">
                            <div class="autocom-box">
{{--                                <li>The Shawnshake Redemption</li>--}}
{{--                                <li>Coco 2017</li>--}}
{{--                                <li>La Vida es Bella</li>--}}
{{--                                <li>It's a wonderful life</li>--}}
{{--                                <li>Fight Club</li>--}}
                            </div>


                            <button class="navbar-form-btn">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>

                            <!--clear search button (hidden)-->
                            <button class="navbar-form-close">
                                <ion-icon name="close-circle-outline"></ion-icon>
                            </button>


                        </form>

                        <!--
                            - Search button for small screens
                        -->
                        <button class="navbar-search-btn">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>

                    </div>


                    <!--Sign in-->
                    @guest
                        <a href="{{route('login')}}" class="navbar-signin">
                            <span>Sign in</span>
                            <ion-icon name="log-in-outline"></ion-icon>
                        </a>
                    @else
                        <div class="dropdown-username">
                            <button class="dropbtn">
                                <span>{{Auth::user()->username}}</span>
                            </button>
                            <div class="dropdown-username-content">
                                <a href="#">Profile</a>
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest

                </div>

            </header>


            <!--MAIN Section-->
            <main>
                @yield('content')
            </main>
            <!--End Main-->



            <!--Footer Section:-->
            <footer>
                <div class="footer-content">

                    <div class="footer-brand">

                        <img src="{{asset('img/logo.png')}}" alt="" class="footer-logo">
                        <p class="slogan">
                            WTW.ma What To Watch ! Find Your Next Favorite Movie.
                        </p>

                        <div class="social-links">
                            <a href="#"> <ion-icon name="logo-facebook"></ion-icon></a>
                            <a href="#"> <ion-icon name="logo-twitter"></ion-icon></a>
                            <a href="#"> <ion-icon name="logo-instagram"></ion-icon></a>
                            <a href="#"> <ion-icon name="logo-tiktok"></ion-icon></a>
                            <a href="#"> <ion-icon name="logo-youtube"></ion-icon></a>
                        </div>

                    </div>

                    <div class="footer-links">

                        <ul>

                            <h4 class="link-heading">WTW.ma</h4>

                            <li class="link-items"><a href="#">About Us</a></li>
                            <li class="link-items"><a href="#">My Profile</a></li>
                            <li class="link-items"><a href="#">Pricing Plans</a></li>
                            <li class="link-items"><a href="#">Contacts</a></li>

                        </ul>

                        <ul>

                            <h4 class="link-heading">Browse</h4>

                            <li class="link-items"><a href="{{route('home')}}">Home</a></li>
                            <li class="link-items"><a href="#">Movies</a></li>
                            <li class="link-items"><a href="#">Documentaries</a></li>
                            <li class="link-items"><a href="#">Trending</a></li>

                        </ul>

                        <ul>

                            <li class="link-items"><a href="{{route('foryou')}}">Recommended for you</a></li>
                            <li class="link-items"><a href="#">Other Stuff2</a></li>
                            <li class="link-items"><a href="#">Other Stuff3</a></li>
                            <li class="link-items"><a href="#">Other Stuff4</a></li>

                        </ul>

                        <ul>

                            <h4 class="link-heading">Help</h4>

                            <li class="link-items"><a href="#">Account</a></li>
                            <li class="link-items"><a href="#">Plans</a></li>
                            <li class="link-items"><a href="#">Supported Devices</a></li>
                            <li class="link-items"><a href="#">Accessibility</a></li>

                        </ul>

                    </div>

                </div>

                <div class="footer-copyright">

                    <div class="copyright">
                        <p>&copy; All Rights Reserved! DKHISSI AYOUB & BOUHCAIN Ali</p>
                    </div>

                    <div class="wrapper">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms and conditions</a>
                    </div>

                </div>

            </footer>

        </div>



        <!-- Scripts-->
        <!--Template Scripts:-->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://unpkg.com/neo4j-driver"></script>

        @stack('scripts')


        <!------->

        <!-- unpkg CDN non-minified -->


        <script src="{{ asset('js/app.js') }}"></script>


    </body>

</html>
