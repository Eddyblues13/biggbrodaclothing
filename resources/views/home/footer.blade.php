<script>
    $(document).ready(function () {
        // Initialize toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000"
        };

        // Add to cart functionality
        $(document).on('click', '.add-to-cart', function (e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var button = $(this);

            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    button.html('<i class="fa fa-spinner fa-spin"></i> Adding...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        refreshCartSidebar();
                        $('.cart-count').text(response.cart_count);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function () {
                    button.html('Add to Cart');
                }
            });
        });

        // Add to favorite functionality
        $(document).on('click', '.favme', function (e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var heartIcon = $(this);

            $.ajax({
                url: '{{ route("favorites.toggle") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    heartIcon.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    if (response.success) {
                        if (response.action === 'added') {
                            toastr.success('Added to favorites');
                        } else {
                            toastr.success('Removed from favorites');
                        }
                        refreshCartSidebar();
                        $('.cart-count').text(response.cart_count);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function () {
                    heartIcon.html('<i class="fa fa-heart"></i>');
                }
            });
        });

        // Function to refresh cart sidebar
        function refreshCartSidebar() {
            $.get('{{ route("cart.data") }}', function (response) {
                if (response.success) {
                    var cartItemsContainer = $('#cartItemsContainer');

                    // Update cart count
                    $('.cart-count').text(response.cart_count);

                    if (response.cart_count > 0) {
                        var itemsHtml = '';
                        $.each(response.cart_items, function (id, item) {
                            itemsHtml += `
                                <div class="single-cart-item" id="cart-item-${id}">
                                    <a href="/products/${item.slug}" class="product-image">
                                        <img src="${item.image}" class="cart-thumb" alt="${item.name}">
                                        <div class="cart-item-desc">
                                            <span class="product-remove" onclick="removeFromCart(${id})">
                                                <i class="fa fa-close" aria-hidden="true"></i>
                                            </span>
                                            <span class="badge">${item.brand}</span>
                                            <h6>${item.name}</h6>
                                            <div class="cart-item-meta">
                                                <p class="price">$${item.price.toFixed(2)}</p>
                                                <div class="cart-item-quantity">
                                                    <button class="qty-minus" onclick="updateQuantity(${id}, -1)">-</button>
                                                    <input type="text" class="qty-text" value="${item.quantity}" readonly>
                                                    <button class="qty-plus" onclick="updateQuantity(${id}, 1)">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `;
                        });
                        cartItemsContainer.html(itemsHtml);
                        $('.empty-cart-message').remove();
                        $('.checkout-btn a').removeClass('disabled');
                    } else {
                        cartItemsContainer.html('<div class="empty-cart-message"><p>Your cart is empty</p></div>');
                        $('.checkout-btn a').addClass('disabled');
                    }

                    // Update summary
                    $('#cart-subtotal').text('$' + response.subtotal.toFixed(2));
                    $('#cart-discount').text('-$' + response.discount.toFixed(2));
                    $('#cart-total').text('$' + response.total.toFixed(2));
                }
            });
        }

        // Initialize cart sidebar on page load
        refreshCartSidebar();

        // Global functions for cart operations
        window.updateQuantity = function (productId, change) {
            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    change: change,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        refreshCartSidebar();
                        $('.cart-count').text(response.cart_count);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }

        window.removeFromCart = function (productId) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        refreshCartSidebar();
                        $('.cart-count').text(response.cart_count);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    });
</script>
<!-- ##### Footer Area Start ##### -->
<footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="{{ url("/") }}"><img src="assets/img/core-img/logo.png" alt=""
                                    style="width: 100px; height: auto;"></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.html">Shop</a></li>
                                <!-- <li><a href="blog.html">Blog</a></li> -->
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                            <h6>Subscribe</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your email here">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right"
                                        aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i
                                    class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i
                                    class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i
                                    class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i
                                    class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i
                                    class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
                            href="https://colorlib.com" target="_blank">Colorlib</a>, distributed by <a
                            href="https://themewagon.com/" target="_blank">ThemeWagon</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved
                        {{-- <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com"
                            target="_blank">Colorlib</a>, distributed by <a href="https://themewagon.com/"
                            target="_blank"></a> --}}
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>

        </div>
</footer>
<!-- ##### Footer Area End ##### -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="assets/js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="assets/js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Plugins js -->
<script src="assets/js/plugins.js"></script>
<!-- Classy Nav js -->
<script src="assets/js/classy-nav.min.js"></script>
<!-- Active js -->
<script src="assets/js/active.js"></script>

</body>

</html>