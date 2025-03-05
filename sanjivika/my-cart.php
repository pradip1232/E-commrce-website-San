<?php
include('includes/header.php');
?>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

.lightgray-color-colmn{
    background:#dee2e6!important;
}
    .cart-container {
        padding: 20px;
        min-height: calc(100vh - 100px);
        /* display: flex;
        flex-direction: column; */
        margin-top: 130px;
        /* Adjust based on your header height */
    }

    .cart-header {
        color: #482607;
        font-family: Roboto;
        font-size: 32px;
        font-weight: 700;
        line-height: 37.5px;
        text-align: center;

        text-align: center;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .cart-summary {
        width: 100%;
        margin-top: 20px;
    }

    .btn-qty {
        width: 32px;
        height: 32px;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
    }

    .cart-summary .table {
        margin-bottom: 0;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .input-group-w {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .qnityt-area input {
        width: 50px;
        text-align: center;
        border: none;
    }

    /* Responsive adjustments */
    @media (max-width: 1199px) {

        /* For large screens (tablets and below) */
        .container-fluid {
            padding: 15px;
        }

        .cart-summary {
            width: 100%;
            margin-top: 20px;
        }
    }

    @media (max-width: 991px) {

        /* For medium screens (tablets) */
        .col-lg-8,
        .col-lg-4 {
            flex: 1 1 100%;
            /* Make columns stack on top of each other */
            max-width: 100%;
        }

        .input-group-w {
            width: 100%;
        }
    }

    @media (max-width: 767px) {

        /* For small screens (phones) */
        .btn-qty {
            width: 28px;
            height: 28px;
        }

        .qnityt-area input {
            width: 40px;
        }

        .cart-header {
            font-size: 18px;
        }

        .table th,
        .table td {
            font-size: 14px;
        }
    }

    .btn-success-check {
        background-color: #482607;
        color: white;
    }

    .price-p,
    .total {
        color: #77C712;
        font-family: Archivo;
        font-size: 18px;
        font-weight: 400;
        line-height: 19.58px;
        text-align: left;

    }

    .sumry-cal {
        background: #F4F4F4;

    }
</style>

<div class="container-fluid cart-container">
    <h2 class="cart-header">Your Cart</h2>
    <div class="row">
        <div class="col-lg-8">
            <div class="cart-items">
                <table class="table">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th class="lightgray-color-colmn">PRICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="https://via.placeholder.com/100" alt="Product 1" class="img-fluid">
                                <span>Turmeric (Haldi) Powder 100g</span>
                            </td>
                            <td class="price lightgray-color-colmn" data-price="38">
                                <p class="price-p "> ₹38.00</p>
                            </td>
                            <td>
                                <div class="input-group-w qnityt-area">
                                    <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, -1)">-</button>
                                    <input type="text" class="form-control text-center qty" value="1" readonly>
                                    <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </td>
                            <td class="total">
                                <p class="price-p"> ₹38.00 </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://via.placeholder.com/100" alt="Product 1" class="img-fluid">
                                <span>Turmeric (Haldi) Powder 100g</span>
                            </td>
                            <td class="price lightgray-color-colmn" data-price="38">₹38.00</td>
                            <td>
                                <div class="input-group-w qnityt-area">
                                    <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, -1)">-</button>
                                    <input type="text" class="form-control text-center qty" value="1" readonly>
                                    <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </td>
                            <td class="total">₹38.00</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://via.placeholder.com/100" alt="Product 1" class="img-fluid">
                                <span>Turmeric (Haldi) Powder 100g</span>
                            </td>
                            <td class="price lightgray-color-colmn" data-price="38">₹38.00</td>
                            <td>
                                <div class="input-group-w qnityt-area">
                                    <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, -1)">-</button>
                                    <input type="text" class="form-control text-center qty" value="1" readonly>
                                    <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </td>
                            <td class="total">₹38.00</td>
                        </tr>
                        <!-- Repeat other product rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="cart-summary">
                <table class="table sumry-cal">
                    <tr>
                        <td>Shipping</td>
                        <td class="text-end">CALCULATED AT CHECKOUT</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end" id="subtotal">₹313.00</td>
                    </tr>
                </table>
                <a href="checkout" class="btn btn-success-check btn-block">PROCEED TO CHECKOUT</a>
                <div class="text-center mt-2">
                    <a href="#">or continue shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateQty(button, change) {
        var qtyInput = button.parentElement.querySelector('.qty');
        var newQty = parseInt(qtyInput.value) + change;
        if (newQty < 1) newQty = 1;
        qtyInput.value = newQty;

        var row = button.closest('tr');
        var price = parseFloat(row.querySelector('.price').getAttribute('data-price'));
        var total = row.querySelector('.total');
        total.innerText = '₹' + (price * newQty).toFixed(2);

        updateSubtotal();
    }

    function updateSubtotal() {
        var totals = document.querySelectorAll('.total');
        var subtotal = 0;
        totals.forEach(function(total) {
            subtotal += parseFloat(total.innerText.replace('₹', ''));
        });
        document.getElementById('subtotal').innerText = '₹' + subtotal.toFixed(2);
    }
</script>

<?php
include('includes/footer.php');
?>