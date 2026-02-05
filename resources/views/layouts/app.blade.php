<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>

    @component('components.layouts.meta')
    @endcomponent
    <style>
        a {
            text-decoration: none !important;
        }

        .bg-gradiant {
            background-image: linear-gradient(to bottom right, #ffffff36, #00000081) !important;
            color: #FFF;
        }

        .bg-gradiant-alt {
            background-image: linear-gradient(to bottom right, #00000081, #ffffff36) !important;
            color: #FFF;
        }

        .bg-purple {
            background: #560087 !important;
            color: #FFF;
        }

        .text-purple {
            color: #560087 !important;
        }

        .bg-purple-light {
            background-color: #fae0ff !important;
        }

        .bg-orange {
            background: #f76000 !important;
            color: #FFF;
        }

        .btn-mini {
            font-size: 0.6rem;
            line-height: 1;
            border-radius: 80.19999999999999rem;
        }

        .btn-mini2 {
            font-size: 0.7rem;
            line-height: 1.7;
            border-radius: 80.19999999999999rem;
        }

        .border-custom {
            border-radius: 1.3rem !important;
        }

        .avatar.avatar-200 {
            height: 200px;
            line-height: 200px;
            width: 200px;
        }

        /* custom */

        .single-select.active {
            position: relative;
            border-color: #e6a25d;
        }

        .single-select {
            padding: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            border-radius: 8px;
        }
    </style>
    <link rel="stylesheet" href="https://zeustrade.pro/d6/assets/global/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://zeustrade.pro/d6/assets/templates/basic/css/lightcase.css">
    <style>
        .blalnceCardBtn {
            height: 50px !important;
            width: 50px !important;
            box-shadow: 0 0 0.5rem 0px #00000040 !important;
            border-radius: 1.3rem !important;
            color: #fff !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .coverPhoto {
            margin-top: 60px !important;
            background-size: cover;
            background-repeat: no-repeat;
            height: 170px;
            width: 100%;
            background-position: center;
            position: cover;
        }

        .top-220 {
            margin-top: -220px;
        }

        .profile-thumb {
            padding: 0.18rem !important;
            background-color: #3d5fa5 !important;
            border: 1px solid #3d5fa5 !important;
            max-width: 100%;
            height: auto;
            transition: ease all 0.5s;
            -webkit-transition: ease all 0.5s;
        }

        .darkmode .profile-thumb {
            background-color: #0f0b04 !important;
            border: 1px solid #0f0b04 !important;
        }
    </style>
    <style>
        .avatar-edit label {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            text-align: center;
            line-height: 41px;
            border: 3px solid #3d5fa5;
            font-size: 18px;
            cursor: pointer;
            position: absolute;
            transition: ease all 0.5s;
            -webkit-transition: ease all 0.5s;
        }

        .avatar-edit {
            transition: ease all 0.5s;
            -webkit-transition: ease all 0.5s;
        }

        .darkmode .avatar-edit {
            background-color: #040910;
        }

        .darkmode .avatar-edit label {
            border: 3px solid #040910 !important;
        }

        .imgEdit {
            margin-left: 6.3rem !important;
            margin-top: -2.6rem !important;
        }

        .coverEdit {
            margin-right: 0.3rem !important;
            margin-top: -45px !important;
        }
    </style>

    <link rel="stylesheet"
        href="https://zeustrade.pro/d6/assets/templates/basic/css/color.php?color1=ffffff&color2=001d4a">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>

<body>
    <div class="page-wrapper">

        <body class="body-scroll d-flex flex-column h-100 menu-overlay" data-page="addmoney">
            <div class="main-menu">
                <div class="row mb-4 no-gutters">
                    <div class="col-auto"><button class="btn btn-link btn-40 btn-close text-white"><span
                                class="material-icons">chevron_left</span></button></div>
                    <div class="col-auto">
                        <div class="avatar avatar-40 rounded-circle position-relative">
                            {{-- <figure class="background profilePhoto">
                                <img src="https://zeustrade.pro/d6/" alt="LOGO">
                            </figure> --}}
                        </div>
                    </div>
                    <div class="col pl-3 text-left align-self-center">
                        <h6 class="mb-1"> {{ auth()->user()->name }} </h6>
                        <p class="small text-default-secondary"> {{ auth()->user()->email }} </p>
                    </div>
                </div>
                <div class="menu-container">
                    <div class="row mb-4">
                        <div class="col">
                            <h4 class="mb-1 font-weight-normal user_balance"> {{ config('app.currency') }}
                                {{ (float) auth()->user()->wallet->deposit }}
                            </h4>
                            <p class="text-default-secondary">My Balance</p>
                        </div>
                        <div class="col-auto">
                            <a href="/deposit" class="btn btn-default btn-40 rounded-circle border-0 dpbtnSidebar"><i
                                    class="material-icons">add</i></a>
                        </div>
                    </div>

                    <ul class="nav nav-pills flex-column ">
                        <li class="nav-item">
                            <a class="nav-link  {{ request()->is('dashboard') && ' active ' }} " href="/dashboard">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/home-3.png" alt="">
                                    Home
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  {{ request()->is('deposit') && ' active ' }} " href="/deposit">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/money-graph.png" alt="">
                                    Deposit
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('withdraw') && ' active ' }}" href="/withdraw">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/team-3.png" alt="">
                                    Withdraw
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  {{ request()->is('change-password') && ' active ' }} "
                                href="/change-password">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/deposit-2.png" alt="">
                                    Change password
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile') && ' active ' }}" href="/profile">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/wallet-3.png" alt="">
                                    Profile
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('transactions') && ' active ' }}" href="/transactions">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/profile-2.png" alt="">
                                    Transactions
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('transfer') && ' active ' }}" href="/transfer">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/profile-2.png" alt="">
                                    Transfer
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>


                        {{-- <li class="nav-item">
                            <a class="nav-link  {{ request()->is('transfer') && ' active ' }} " href="/transfer">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/money-graph.png" alt="">
                                    Transfer
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('transactions') && ' active ' }}" href="/verification">
                                <div>
                                    <img width="20px" class="nav-icons" src="/images/wallet-3.png" alt="">
                                    KYC
                                </div>
                                <span class="arrow material-icons">chevron_right</span>
                            </a>
                        </li>


                    </ul>
                    <form action="/logout" method="post">
                        @csrf
                        <div class="text-center">
                            <button class="btn btn-outline-danger text-white rounded my-3 mx-auto">Sign out</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="backdrop"></div>


            <main class="flex-shrink-0 main has-footer">
                <header class="header">
                    <div class="row">
                        <div class="col-auto px-0">
                            <button class="menu-btn btn btn-40 btn-link" type="button">
                                <span class="material-icons">menu</span>
                            </button>
                        </div>
                        <div class="text-left col align-self-center">
                            <a class="navbar-brand" href="/">
                                <h5 class="mb-0"><img class=" h-8" src="/images/logo-img.png" alt="site-logo">
                                </h5>
                            </a>
                        </div>
                        <div class="ml-auto col-auto pl-0">
                            <div class="row">
                                <div style="padding-top: 6px !important;"
                                    class="custom-control custom-switch darkModeSwitch">
                                    <input type="checkbox" class="custom-control-input switch-info text-align-center"
                                        id="darklayout">
                                    <label class="custom-control-label nightModeImg" for="darklayout">
                                        <img width="28px" src="/images/moon.png" alt="">
                                    </label>
                                </div>

                                <a href="notification.html" class=" btn btn-40 btn-link" data-toggle="modal"
                                    data-target="#noticeModal">
                                    <img width="25px" src="/images/notice.png" alt="">
                                </a>
                                <div style="padding-right: 0.5rem !important;" class="mt-1">
                                    <a href="/profile" class="avatar avatar-30 shadow-sm rounded-circle ml-2 mt-1">
                                        <figure class="m-0 background profilePhoto">
                                            {{-- <img src="https://zeustrade.pro/d6/placeholder-image/300x300"
                                                alt=""> --}}
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </header>

                <div class="color-picker">
                    <div class="row">

                        <div class="col text-left">
                            <div class="selectoption">
                                <input type="checkbox" id="darklayout" name="darkmode">
                                <label for="darklayout">Dark</label>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-link text-secondary btn-round colorsettings2"><span
                                    class="material-icons">close</span></button>
                        </div>
                    </div>
                </div>
                {{ $slot }}
            </main>
        </body>

        <!-- footer-->
        <div class="footer w-full">
            <div class=" flex  row no-gutters justify-content-center justify-between w-full">
                <div class="col">
                    <a href="/" class="">
                        <img class="img-fluid footer-icon" src="/images/home-3.png" alt="">
                        <p>Dashboard</p>
                    </a>
                </div>
                <div class="col">
                    <a href=" https://whatsapp.com/channel/0029VaSxhDBId7nFihXTM23Z" class="" target="__blank">
                        <img class="img-fluid footer-icon" src="/images/whatsapp.png" alt="">
                        <p>Whatsapp</p>
                    </a>
                </div>
                <div class="col">
                    <a href="/plans" class="">
                        <img class="img-fluid footer-icon-middle" src="/images/btc-mining-7.png" alt="">
                    </a>
                </div>
                <div class="col">
                    <a href="/order-history" class="">
                        <img class="img-fluid footer-icon" src="/images/DIAMOND TRADE .png" alt="">
                        <p>Order History</p>
                    </a>
                </div>
                <div class="col">
                    <a href="/profile" class="active jumpBtn">
                        <img class="img-fluid footer-icon" src="/images/user-4.png" alt="">
                        <p>Profile</p>
                    </a>
                </div>
            </div>
        </div>

        <!--AutoPayment Redirect-->
        <div id="LocationPayment"></div>
    </div>
    @include('components.layouts.scripts')
</body>

</html>
