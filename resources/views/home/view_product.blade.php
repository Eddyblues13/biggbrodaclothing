@include("home.header")

<!-- ##### Single Product Details Area Start ##### -->
<section class="single_product_details_area d-flex align-items-center">
    <!-- Single Product Thumb -->
    <div class="single_product_thumb clearfix">
        <div class="product_thumbnail_slides owl-carousel">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            @foreach($product->gallery_urls as $galleryImage)
            <img src="{{ $galleryImage }}" alt="{{ $product->name }}">
            @endforeach

        </div>
    </div>

    <!-- Single Product Description -->
    <div class="single_product_desc clearfix">
        <span>{{ $product->brand }}</span>
        <h2>{{ $product->name }}</h2>

        @if($product->isOnSale)
        <p class="product-price"><span class="old-price">${{ number_format($product->price, 2) }}</span> ${{
            number_format($product->discount_price, 2) }}</p>
        @else
        <p class="product-price">${{ number_format($product->price, 2) }}</p>
        @endif

        <p class="product-desc">{{ $product->description }}</p>

        <!-- Form -->
        <form class="cart-form clearfix" method="post">
            <!-- Select Box -->
            @if(count($product->available_sizes) > 0)
            <div class="select-box d-flex mt-50 mb-30">
                <select name="select" id="productSize" class="mr-5">
                    @foreach($product->available_sizes as $size)
                    <option value="{{ $size }}">Size: {{ $size }}</option>
                    @endforeach
                </select>
                @if(count($product->available_colors) > 0)
                <select name="select" id="productColor">
                    @foreach($product->available_colors as $color)
                    <option value="{{ $color }}">Color: {{ $color }}</option>
                    @endforeach
                </select>
                @endif
            </div>
            @endif

            <!-- Cart & Favourite Box -->
            <div class="cart-fav-box d-flex align-items-center">
                <!-- Cart -->
                <button type="submit" name="addtocart" value="{{ $product->id }}" class="btn essence-btn">Add to
                    cart</button>
                <!-- Favourite -->
                <div class="product-favourite ml-4">
                    <a href="#" class="favme fa fa-heart {{ in_array($product->id, $favorites) ? 'active' : '' }}"
                        data-product-id="{{ $product->id }}"></a>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- ##### Single Product Details Area End ##### -->
@include("home.footer")