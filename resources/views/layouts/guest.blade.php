<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    @include('components.layouts.meta')
</head>

<body>
    <div class="page-wrapper">

        <body class="body-scroll d-flex flex-column h-100 menu-overlay">
            <main class="flex-shrink-0 main has-footer">
                <header class="header">
                    <div class="row">
                        <div class="col align-self-center text-center">
                            <a class="navbar-brand" href="/">
                                <h5 class="mb-0 font-semibold italic">
                                    <span class="text-yellow-600">DIAMOND TRADE </span>
                                </h5>
                            </a>
                        </div>
                    </div>
                </header>
                {{ $slot }}
            </main>
        </body>
    </div>

    @component('components.social')
    @endcomponent

    @include('components.layouts.scripts')
</body>

</html>
