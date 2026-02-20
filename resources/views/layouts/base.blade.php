
<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head>
    <meta name="google-site-verification" content=""/>
        <title>{{$settings->site_name}}</title>
    <meta name="description" content="{{$settings->site_name}} | We are here to serve you better and help save your money without charges.." />
    <meta property="og:locale" content="en_EN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$settings->site_name}} - We are here to serve you better and help save your money without charges.." />
            <meta property="og:description" content="{{$settings->site_name}} | We are here to serve you better and help save your money without charges" />
        <meta property="og:image" content="{{ asset('storage/app/public/'.$settings->favicon)}}" />
        <meta property="og:url" content="{{$settings->site_address}}" />
    <meta property="og:site_name" content="{{$settings->site_name}}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Welcome to a new era of banking at {{$settings->site_name}}, where traditional boundaries fade away and possibilities expand.." />
    <meta name="twitter:title" content="{{$settings->site_name}} - We are here to serve you better and help save your money without charges.." />
    <meta name="twitter:image" content="{{ asset('storage/app/public/'.$settings->favicon)}}" />

    <!--favicon icon-->
    <link rel="icon" href="{{ asset('storage/app/public/'.$settings->favicon)}}" type="image/png" sizes="16x16">

    <!--google fonts-->
    <link href="fonts.googleapis.co/css164416441644.html?family=Montserrat:400,500,600,700%7COpen+Sans:400,600&amp;display=swap" rel="stylesheet">

    <!--Bootstrap css-->
    <link rel="stylesheet" href="temp/custom/base/css/bootstrap.min.css">
    <!--Magnific popup css-->
    <link rel="stylesheet" href="temp/custom/base/css/magnific-popup.css">
    <!--Themify icon css-->
    <link rel="stylesheet" href="temp/custom/base/css/themify-icons.css">
    <!--Fontawesome icon css-->
    <link rel="stylesheet" href="temp/custom/base/css/all.min.css">
    <!--animated css-->
    <link rel="stylesheet" href="temp/custom/base/css/animate.min.css">
    <!--ytplayer css-->
    <link rel="stylesheet" href="temp/custom/base/css/jquery.mb.YTPlayer.min.css">
    <!--Owl carousel css-->
    <link rel="stylesheet" href="temp/custom/base/css/owl.carousel.min.css">
    <link rel="stylesheet" href="temp/custom/base/css/owl.theme.default.min.css">
    <!--custom css-->
    <link rel="stylesheet" href="temp/custom/base/css/style.css">
    <!--responsive css-->
    <link rel="stylesheet" href="temp/custom/base/css/responsive.css">

    <link rel="stylesheet" href="base/cdnjs.cloudflare.co/ajax/libs/normalize/5.0.0/normalize.min.html">
    <link rel='stylesheet' href='fonts.googleapis.co/icone91fe91fe91f.html?family=Material+Icons'>
    <link rel="stylesheet" href="temp/custom/base/css/customstyle.css">
    <style>
        .info {
            color: rgba(2, 2, 211, 0.753);
        }
        .success {
            color: rgba(5, 187, 5, 0.801);
        }
        .error {
            color: rgba(255, 0, 0, 0.801);
        }
    </style></head>

    <div class="loader1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<header class="header">
    <!--start navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ $brandLogoUrl }}?v={{ $cacheBuster }}" style="height: 60px; width: 150px;" alt="{{$settings->site_name}}" class="img-fluid"/>
            </a>






            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('faq') }}">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('contact') }}">Get Support</a></li>
                    <li class="nav-item"><a href="{{route('register')}}" class="btn btn-primary btn-sm px-3">Open Account</a></li>
                    <li class="nav-item"><a href="{{route('login')}}" class="btn btn-outline-primary btn-sm px-3">Online Banking</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <style>
        #mainNav {
            background: linear-gradient(135deg, #01579B 0%, #004B7A 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        #mainNav.scrolled {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            padding: 0.25rem 0;
        }

        #mainNav .container {
            padding: 0 1rem;
        }

        .navbar-brand {
            transition: transform 0.3s ease;
            margin-right: 2rem;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand img {
            max-width: 150px;
            height: auto;
        }

        .menu {
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 0.75rem !important;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0.75rem;
            width: 0;
            height: 2px;
            background: #ffffff;
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff !important;
        }

        .nav-link:hover::after {
            width: calc(100% - 1.5rem);
        }

        .menu .btn {
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 0.25rem;
        }

        .menu .btn-primary {
            background: #ffffff;
            border: none;
            color: #01579B;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .menu .btn-primary:hover {
            background: #f0f9ff;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
            color: #01579B;
        }

        .menu .btn-outline-primary {
            color: #ffffff;
            border: 2px solid #ffffff;
            background: transparent;
        }

        .menu .btn-outline-primary:hover {
            background: #ffffff;
            color: #0284C7;
            border-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .custom-toggler {
            border: none;
            padding: 0.25rem;
        }

        .hamburger {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background: #ffffff;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .custom-toggler[aria-expanded="true"] .hamburger span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .custom-toggler[aria-expanded="true"] .hamburger span:nth-child(2) {
            opacity: 0;
        }

        .custom-toggler[aria-expanded="true"] .hamburger span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        @media (max-width: 991px) {
            #mainNav {
                background: linear-gradient(135deg, #01579B 0%, #004B7A 100%) !important;
            }

            .navbar-collapse {
                background: #ffffff;
                border-radius: 8px;
                margin-top: 0.5rem;
                padding: 1rem;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
                animation: slideDown 0.3s ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .menu {
                flex-direction: column;
                gap: 0;
                width: 100%;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                color: #01579B !important;
                padding: 0.75rem 0 !important;
                border-bottom: 1px solid #f3f4f6;
            }

            .nav-link:last-child {
                border-bottom: none;
            }

            .nav-link::after {
                display: none;
            }

            .menu .btn {
                width: 100%;
                margin-left: 0;
                margin-top: 0.5rem;
                color: #ffffff !important;
            }

            .menu .btn-primary {
                color: #01579B !important;
            }

            .menu .btn-outline-primary {
                color: #01579B !important;
                border-color: #01579B !important;
            }

            .footer-section ul li a,
            .footer-section .text-white {
                color: #ffffff !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainNav = document.getElementById('mainNav');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 20) {
                    mainNav.classList.add('scrolled');
                } else {
                    mainNav.classList.remove('scrolled');
                }
            });
        });
    </script>
</header>




@yield('content')

<footer class="footer-section">
    <!--footer top start-->
    <div class="footer-top gradient-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row footer-top-wrap">
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">QUICK LINKS</h4>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('register')}}">Open Account</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href=" {{route('login')}}">Online Banking</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">COMPANY</h4>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="about">About Us</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="about">Our Services</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="faq">FAQs</a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">LEGAL</h4>
                                <ul class="nav flex-column">
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0);">Legal Information</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="privacy-policy">Privacy Policy</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="contact">Report Abuse</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="terms">Terms of Service</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">SUPPORT</h4>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact">Contact</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="faq">FAQs</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row footer-top-wrap">
                        <div class="col-12">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">GET IN TOUCH</h4>
                                <ul class="get-in-touch-list">
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-map-marker-alt mr-2"></span> {{$settings->address_o}} </li>
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-envelope mr-2"></span> <a href="cdn-cgi/l/email-protection-2.html" class="__cf_email__" data-cfemail="3e6d4b4e4e514c4a7e595b535750575952515c5f525857505f505d5b105d51">[email&#160;protected]</a></a></li>
                                   <li class="d-flex align-items-center py-2"><i class="fas fa-comments"></i>&nbsp;&nbsp;<a href='#'> {{$settings->contact_email}} </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer top end-->

    <!--footer copyright start-->
    <div class="footer-bottom py-4" style="background: black;">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5 col-lg-5">
                    <p class="copyright-text pb-0 mb-0">Copyrights © 2023. All
                        rights reserved
                        <a href="/" target="_blank" class='text-white'>{{$settings->site_name}}</a></p>
                </div>
                <div class="col-md-7 col-lg-6 d-none d-md-block d-lg-block">
                    <div class="social-nav text-right">
                        <ul class="list-unstyled social-list mb-0">
                            <li class="list-inline-item tooltip-hover">
                                <a href="https://facebook.com/" target="_blank" class="rounded text-white"><span class="ti-facebook"></span></a>
                                <div class="tooltip-item">Facebook</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="https://twitter.com/" target="_blank" class="rounded text-white"><span class="ti-twitter"></span></a>
                                <div class="tooltip-item">Twitter</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="http://linkedin.com/" target="_blank" class="rounded text-white"><span class="ti-linkedin"></span></a>
                                <div class="tooltip-item">Linkedin</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="https://instagram.com/" target="_blank" class="rounded text-white"><span class="ti-instagram"></span></a>
                                <div class="tooltip-item">Instagram</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer copyright end-->
</footer>
<!--footer section end-->

<!--bottom to top button start-->
<button class="scroll-top scroll-to-target" data-target="html">
    <span class="ti-angle-up"></span>
</button>

<div class="telegram-popup" align="center">

        </div>



        @include('layouts.lang')

<!--jQuery-->
<script data-cfasync="false" src="https://cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="temp/custom/base/js/jquery-3.4.1.min.js"></script>
<!--Popper js-->
<script src="temp/custom/base/js/popper.min.js"></script>
<!--Bootstrap js-->
<script src="temp/custom/base/js/bootstrap.min.js"></script>
<!--Magnific popup js-->
<script src="temp/custom/base/js/jquery.magnific-popup.min.js"></script>
<!--jquery easing js-->
<script src="temp/custom/base/js/jquery.easing.min.js"></script>
<!--jquery ytplayer js-->
<script src="temp/custom/base/js/jquery.mb.YTPlayer.min.js"></script>
<!--Isotope filter js-->
<script src="temp/custom/base/js/mixitup.min.js"></script>
<!--wow js-->
<script src="temp/custom/base/js/wow.min.js"></script>
<!--owl carousel js-->
<script src="temp/custom/base/js/owl.carousel.min.js"></script>
<!--countdown js-->
<script src="temp/custom/base/js/jquery.countdown.min.js"></script>
<!--custom js-->
<script src="temp/custom/base/js/all.min.js"></script>
<!--custom js-->
<script src="temp/custom/base/js/scripts.js"></script>
<!-- inpage script -->
<script>
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if(h === 0){
        h = 12;
    }

    if(h > 12){
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;

    setTimeout(showTime, 1000);

}

showTime();
</script>


<script>
    $(document).ready(function(){
        $(".telegram-popup").delay(3000).show(0);
    });
</script>

<script>
    if (window.history.replaceState){
    window.history.replaceState(null, null, window.location.href);
    }
    // ensure to add onunload='' to the body tag and autocomplete="off" on form tags
</script>

<!-- Script for getting user timezone -->
<script>
    // Timezone settings
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone; // e.g. "America/New_York"
    document.getElementById('location').value = timezone;
    console.log(document.getElementById('location').value);
</script>


@include('layouts.livechat')
@if($settings->tido)
    <script src="//code.tidio.co/{{$settings->tido}}" async></script>
    @endif

</body>



</html>

