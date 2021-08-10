@if (get_setting('facebook_chat') == 1)
    <script type="text/javascript">
        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v3.3'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="fb-root"></div>
    <!-- Your customer chat code -->
    <div class="fb-customerchat"
         attribution=setup_tool
         page_id="{{ env('FACEBOOK_PAGE_ID') }}">
    </div>
@endif

<script>
    @auth
    @foreach (session('flash_notification', collect())->toArray() as $message)
    AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
    @endforeach
    @endauth
</script>

<script>

    $(document).ready(function () {

        // INITIALIZATION OF UNFOLD
        // =======================================================
        var unfold = new HSUnfold('.js-hs-unfold-invoker').init();

        $('.category-nav-element').each(function (i, el) {
            $(el).on('mouseover', function () {
                if (!$(el).find('.sub-cat-menu').hasClass('loaded')) {
                    $.post('{{ route('category.elements') }}', {
                        _token: AIZ.data.csrf,
                        id: $(el).data('id')
                    }, function (data) {
                        $(el).find('.sub-cat-menu').addClass('loaded').html(data);
                    });
                }
            });
        });
        if ($('#lang-change').length > 0) {
            $('#lang-change .dropdown-menu a').each(function () {
                $(this).on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    var locale = $this.data('flag');
                    $.post('{{ route('language.change') }}', {_token: AIZ.data.csrf, locale: locale}, function (data) {
                        location.reload();
                    });

                });
            });
        }

        if ($('#currency-change').length > 0) {
            $('#currency-change .dropdown-menu a').each(function () {
                $(this).on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    var currency_code = $this.data('currency');
                    $.post('{{ route('currency.change') }}', {
                        _token: AIZ.data.csrf,
                        currency_code: currency_code
                    }, function (data) {
                        location.reload();
                    });

                });
            });
        }

        // INITIALIZATION OF HS-ADD-FIELD
        // =======================================================
        $('.js-add-field').each(function () {
          new HSAddField($(this)).init();
        });
    });

    $('#search').on('keyup', function () {
        search();
    });

    $('#search').on('focus', function () {
        search();
    });

    document.addEventListener('scroll', processScroll);

    function processScroll() {
        let docElem = document.documentElement,
        docBody = document.body,
        scrollTop = docElem['scrollTop'] || docBody['scrollTop'],
        scrollBottom = (docElem['scrollHeight'] || docBody['scrollHeight']) - window.innerHeight,
        scrollPercent = scrollTop / scrollBottom * 100 + '%';

        if (!!document.getElementById("b2b-progress-bar")) {
            document.getElementById("b2b-progress-bar").style.setProperty("--scrollAmount", scrollPercent);
        }
    }

    function search() {
        var searchKey = $('#search').val();
        if (searchKey.length > 0) {
            $('body').addClass("typed-search-box-shown");

            $('.typed-search-box').removeClass('d-none');
            $('.search-preloader').removeClass('d-none');
            $.post('{{ route('search.ajax') }}', {_token: AIZ.data.csrf, search: searchKey}, function (data) {
                if (data == '0') {
                    // $('.typed-search-box').addClass('d-none');
                    $('#search-content').html(null);
                    $('.typed-search-box .search-nothing').removeClass('d-none').html('Sorry, nothing found for <strong>"' + searchKey + '"</strong>');
                    $('.search-preloader').addClass('d-none');

                } else {
                    $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                    $('#search-content').html(data);
                    $('.search-preloader').addClass('d-none');
                }
            });
        } else {
            $('.typed-search-box').addClass('d-none');
            $('body').removeClass("typed-search-box-shown");
        }
    }

    function updateNavCart() {
        $.post('{{ route('cart.nav_cart') }}', {_token: AIZ.data.csrf}, function (data) {
            $('#cart_items').html(data);
        });
    }

    function removeFromCart(key) {
        $.post('{{ route('cart.removeFromCart') }}', {_token: AIZ.data.csrf, key: key}, function (data) {
            updateNavCart();
            $('#cart-summary').html(data);
            AIZ.plugins.notify('success', 'Item has been removed from cart');
            $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) - 1);
        });
    }

    function addToCompare(id) {
        $.post('{{ route('compare.addToCompare') }}', {_token: AIZ.data.csrf, id: id}, function (data) {
            $('#compare').html(data);
            AIZ.plugins.notify('success', "{{ translate('Item has been added to compare list') }}");
            $('#compare_items_sidenav').html(parseInt($('#compare_items_sidenav').html()) + 1);
        });
    }

    function addToWishList(id) {
        @if (Auth::check() && (auth()->user()->isCustomer() || auth()->user()->isSeller()))
        $.post('{{ route('wishlists.store') }}', {_token: AIZ.data.csrf, id: id}, function (data) {
            if (data != 0) {
                $('#wishlist').html(data);
                AIZ.plugins.notify('success', "{{ translate('Item has been added to wishlist') }}");
            } else {
                AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
            }
        });
        @else
        AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
        @endif
    }

    function showAddToCartModal(id) {
        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('{{ route('cart.showCartModal') }}', {_token: AIZ.data.csrf, id: id}, function (data) {
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            AIZ.plugins.slickCarousel();
            AIZ.plugins.zoom();
            AIZ.extra.plusMinus();
            getVariantPrice();
        });
    }

    $('#option-choice-form input').on('change', function () {
        getVariantPrice();
    });

    function getVariantPrice() {
        if ($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
            $.ajax({
                type: "POST",
                url: '{{ route('products.variant_price') }}',
                data: $('#option-choice-form').serializeArray(),
                success: function (data) {

                    $('.product-gallery-thumb .carousel-box').each(function (i) {
                        if ($(this).data('variation') && data.variation == $(this).data('variation')) {
                            $('.product-gallery-thumb').slick('slickGoTo', i);
                        }
                    })

                    $('#option-choice-form #chosen_price_div').removeClass('d-none');
                    $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                    $('#available-quantity').html(data.quantity);
                    $('.input-number').prop('max', data.quantity);
                    if (parseInt(data.quantity) < 1 && data.digital == 0) {
                        $('.buy-now').hide();
                        $('.add-to-cart').hide();
                    } else {
                        $('.buy-now').show();
                        $('.add-to-cart').show();
                    }
                }
            });
        }
    }

    function checkAddToCartValidity() {
        var names = {};
        $('#option-choice-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });

        if ($('#option-choice-form input:radio:checked').length == count) {
            return true;
        }

        return false;
    }

    function addToCart() {
        if (checkAddToCartValidity()) {
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
                type: "POST",
                url: '{{ route('cart.addToCart') }}',
                data: $('#option-choice-form').serializeArray(),
                success: function (data) {
                    $('#addToCart-modal-body').html(null);
                    $('.c-preloader').hide();
                    $('#modal-size').removeClass('modal-lg');
                    $('#addToCart-modal-body').html(data.view);
                    updateNavCart();
                    $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
                }
            });
        } else {
            AIZ.plugins.notify('warning', 'Please choose all the options');
        }
    }

    function buyNow() {
        if (checkAddToCartValidity()) {
            $('#addToCart-modal-body').html(null);
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
                type: "POST",
                url: '{{ route('cart.addToCart') }}',
                data: $('#option-choice-form').serializeArray(),
                success: function (data) {
                    if (data.status == 1) {
                        updateNavCart();
                        $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
                        window.location.replace("{{ route('cart') }}");
                    } else {
                        $('#addToCart-modal-body').html(null);
                        $('.c-preloader').hide();
                        $('#modal-size').removeClass('modal-lg');
                        $('#addToCart-modal-body').html(data.view);
                    }
                }
            });
        } else {
            AIZ.plugins.notify('warning', 'Please choose all the options');
        }
    }

    function show_purchase_history_details(order_id) {
        $('#order-details-modal-body').html(null);

        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }

        $.post('{{ route('purchase_history.details') }}', {_token: AIZ.data.csrf, order_id: order_id}, function (data) {
            $('#order-details-modal-body').html(data);
            $('#order_details').modal();
            $('.c-preloader').hide();
        });
    }

    function show_order_details(order_id) {
        $('#order-details-modal-body').html(null);

        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }

        $.post('{{ route('orders.details') }}', {_token: AIZ.data.csrf, order_id: order_id}, function (data) {
            $('#order-details-modal-body').html(data);
            $('#order_details').modal();
            $('.c-preloader').hide();
        });
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    function imageInputInitialize() {
        $('.custom-input-file').each(function () {
            var $input = $(this),
                $label = $input.next('label'),
                labelVal = $label.html();

            $input.on('change', function (e) {
                var fileName = '';

                if (this.files && this.files.length > 1)
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                else if (e.target.value)
                    fileName = e.target.value.split('\\').pop();

                if (fileName)
                    $label.find('span').html(fileName);
                else
                    $label.html(labelVal);
            });

            // Firefox bug fix
            $input
                .on('focus', function () {
                    $input.addClass('has-focus');
                })
                .on('blur', function () {
                    $input.removeClass('has-focus');
                });
        });
    }

    function markAllAsRead() {
        $.ajax({
                type: "POST",
                url: '{{ route('notifications.mark_all_as_read') }}',
                data: {
                    _token: AIZ.data.csrf,
                },
                success: function (data) {

                }
            });
    }

</script>
