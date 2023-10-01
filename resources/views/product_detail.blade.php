<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/css/style.css" rel="stylesheet">

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body>
    <header class="header">
        <div class="logo_wrapper">
            <a href="/"><img src="/image/logo.png" alt="logo"></a>
        </div>
        <div class="cart_wrapper">
            <span>Cart</span><br>
            <span id="cart_amount">0</span> article(s), <span id="cart_price">0</span>€
        </div>
    </header>

    <div class="breadcrumb_wrapper">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/home/product">Women's Top</a></li>
            <li><a href="#">{{ $product->title }}</a></li>
        </ul>
    </div>

    <div class="product_detail_wrapper">
        <div class="product_image_group">
            <div class="product_img_main">
                <img id="img_main" src="{{ url('/storage/'.$product->images[0]->url) }}" alt="">
            </div>
            <div class="product_img_sub">
                @foreach($product->images as $image)
                <span class="img_sub_wrapper"><img class="img_sub" src="{{ url('/storage/'.$image->url) }}" alt=""></span>
                @endforeach
            </div>
        </div>
        <div class="product_info_group">
            <div class="product_title_group">
                <h1 class="product_tittle">{{ $product->title }}</h1>
                <div class="product_price">
                    <span id="original_price" data-original_price="{{ $product->price }}">{{ $product->price }}€</span>
                    <span id="sale_price" data-sale_price="{{ $product->promo_price }}">{{ $product->promo_price }}€</span>
                </div>
            </div>

            <p>Brand: {{ $product->brand->name ?? '' }}</p>

            <div class="tab-content" id="product_info_tab_content">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    {{ $product->description }}
                </div>
                <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                    Delivery Information
                </div>
                <div class="tab-pane fade" id="guarantees" role="tabpanel" aria-labelledby="guarantees-tab">
                    Guarantees Information
                </div>
            </div>
            <ul class="nav nav-tabs" id="product_info_tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery" type="button" role="tab" aria-controls="delivery" aria-selected="false">Delivery</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="guarantees-tab" data-bs-toggle="tab" data-bs-target="#guarantees" type="button" role="tab" aria-controls="guarantees" aria-selected="false">Guarantees Payment</button>
                </li>
            </ul>

            <form id="add_to_cart_form" action="#" method="post">
                <input type="hidden" name="product_id" value="">

                <div class="add_to_cart_wrapper">
                    <div class="amount_wrapper">
                        <span>Amount:</span>
                        <div class="amount_group">
                            <button class="change_amount_btn sub_amount_btn" type="button" onclick="changeQuantity('sub')">-</button>
                            <input id="product_quantity" type="number" value="1" name="product_quantity" min="0" step="1">
                            <button class="change_amount_btn add_amount_btn" type="button" onclick="changeQuantity('add')">+</button>
                        </div>
                    </div>

                    <button id="add_to_cart_btn" class="btn btn-secondary" type="button" onclick="addTocart()">Add To Cart</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        if(localStorage.getItem("cart_quantity")) {
            $('#cart_amount').text(localStorage.getItem("cart_quantity"));
        }
        if(localStorage.getItem("cart_price")) {
            $('#cart_price').text(localStorage.getItem("cart_price"));
        }

        const main_img = $('#img_main').attr('src');
        $(".img_sub_wrapper").on( "click", ".img_sub",function() {
            const src = $(this).attr('src');
            $('#img_main').attr('src', src);
        });

        function changeQuantity(direction) {
            let product_quantity = parseInt($('#product_quantity').val());
            if(direction == 'add') {
                $('#product_quantity').val(product_quantity+1);
            }

            if(direction == 'sub') {
                if(product_quantity-1 < 1) {
                    return;
                }
                $('#product_quantity').val(product_quantity-1);
            }

        }

        function addTocart() {
            const product_quantity = parseInt($('#product_quantity').val());
            const product_price = parseFloat($('#original_price').attr('data-original_price'));
            const promo_price = parseFloat($('#sale_price').attr('data-sale_price'));

            let price = promo_price > 0 ? promo_price : product_price;

            let cart_quantity = parseInt(localStorage.getItem("cart_quantity"));
            if(cart_quantity) {
                cart_quantity+= product_quantity;
            } else {
                cart_quantity = product_quantity;
            }

            $('#cart_amount').text(cart_quantity);
            $('#cart_price').text(cart_quantity*price);
            localStorage.setItem("cart_quantity", cart_quantity);
            localStorage.setItem("cart_price", cart_quantity*price);
        }
    </script>
</body>
</html>