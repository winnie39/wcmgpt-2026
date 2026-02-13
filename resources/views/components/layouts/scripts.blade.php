<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

<script src="/js/jquery.cookie.js"></script>

<script src="/js/swiper.min.js"></script>

<script src="/js/Chart.bundle.min.js"></script>
<script src="/js/utils.js"></script>
{{--
<script src="/js/chart-js-data.js"></script> --}}

<script src="/js/main.js"></script>
<script src="/js/color-scheme-demo.js"></script>

<script src="/js/pwa-services.js"></script>

<script src="/js/app.js"></script>

<script src="/js/sweetalert2@11.js"></script>

<script src="/js/swiper-element-bundle.min.js"></script>

<link rel="stylesheet" href="/css/iziToast.min.css">
<script src="/js/iziToast.min.js"></script>

<script src="/js/toastr.js"></script>
{!! Toastr::message() !!}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.channel('toast-notification')
            .listen('.notification', (event) => {
                toastr.info(event.message);
            });
    });
</script>

{{--
<script>
    "use strict";

    function notify(status, message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script> --}}


<script>
    document.addEventListener('DOMContentLoaded', function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
</script>

{{--
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const notifyMsg = (msg, cls) => {
            Swal.fire({
                position: 'top-end',
                icon: cls,
                title: msg,
                toast: true,
                showConfirmButton: false,
                timer: 2100
            })
        }

        $(window).on('load', function () {
            $('#preLoadCustom').delay(100).fadeOut(100);
        });
        const darkModeChange = () => {
            if ($('body').hasClass('darkmode')) {
                $('.nightModeImg').html(
                    `<img width="28px" src="https://zeustrade.pro/d6/assets/images/3d-logo/sun.png" alt="">`
                );
            } else {
                $('.nightModeImg').html(
                    `<img width="28px" src="https://zeustrade.pro/d6/assets/images/3d-logo/moon.png" alt="">`
                );
            }
        }

        $(window).on('load', function () {
            darkModeChange()
        });

        $(document).on('click', '#darklayout', function () {
            darkModeChange()
        });

        (function ($) {
            "use strict";
            $(".langSel").on("change", function () {
                window.location.href = "https://zeustrade.pro/d6/change/" + $(this).val();
            });

            var inputElements = $('input,select');
            $.each(inputElements, function (index, element) {
                element = $(element);
                var type = element.attr('type');
                if (type != 'checkbox') {
                    element.closest('.form-group').find('label').attr('for', element.attr('name'));
                    element.attr('id', element.attr('name'))
                }
            });

            $('.policy').on('click', function () {
                $.get('https://zeustrade.pro/d6/cookie/accept', function (response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function () {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            $.each($('input, select, textarea'), function (i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });

            $('.showFilterBtn').on('click', function () {
                $('.responsive-filter-card').slideToggle();
            });

            let headings = $('.table th');
            let rows = $('.table tbody tr');
            let columns
            let dataLabel;
            $.each(rows, function (index, element) {
                columns = element.children;
                if (columns.length == headings.length) {
                    $.each(columns, function (i, td) {
                        dataLabel = headings[i].innerText;
                        $(td).attr('data-label', dataLabel)
                    });
                }
            });

        })(jQuery);
    });
</script> --}}
<script src="/js/swiper-bundle.min.js"></script>

{{--
<script>
    document.addEventListener('DOMContentLoaded', function () {

        var swiper = new Swiper(".mySwiper", {
            //   effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });
    })
</script> --}}