<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./home.html"><i class="fa fa-home"></i> Home</a>
                    <a href="./shop.html">Shop</a>
                    <span>Shopping Cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open('shop/edit') ?>
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th class="p-name">Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th><i class="ti-close"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (!empty($items)) :
                                foreach ($items as $index => $item) :
                            ?>
                                    <tr>
                                        <td class="cart-pic first-row"><img src="<?= base_url('uploads/' . $item['options']['foto'] . '') ?>" alt="" style="width:100px"></td>
                                        <td class="cart-title first-row">
                                            <h5><?php echo $item['name'] ?></h5>
                                        </td>
                                        <td class="p-price first-row"><?php echo number_to_currency($item['price'], 'IDR') ?></td>
                                        <td class="qua-col first-row">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" name="qty<?php echo $i++ ?>" value="<?php echo $item['qty'] ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-price first-row"><?php echo number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                                        <td class="close-td first-row"><a href="<?= site_url('shop/delete/' . $item['rowid'] . '') ?>"><i class="ti-close"></i></a></td>
                                    </tr>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($diskon) : ?>
                    <h4>terdapat diskon hari ini</h4>
                <?php else : ?>
                    <h4>tidak ada diskon hari ini</h4>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="<?= site_url('shop') ?>" class="primary-btn continue-shop">Continue shopping</a>
                            <!-- <a href="<?= site_url('shop/cart') ?>" class="primary-btn up-cart">Update cart</a> -->
                            <button type="submit" class="primary-btn up-cart">Update cart</button>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Subtotal <span><?php echo number_to_currency($total, 'IDR') ?></span></li>
                                <?php foreach ($diskon as $diskon) : ?>
                                    <li class="subtotal">Diskon <span><?= $diskon['diskon'] ?>%</span></li>
                                    <?php
                                    $besarDiskon = ($total * $diskon['diskon']) / 100;
                                    $hargaSetelahDiskon = $total - $besarDiskon;
                                    ?>`
                                    <li class="cart-total">Total <span><?php echo number_to_currency($hargaSetelahDiskon, 'IDR') ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="<?= site_url('shop/checkout') ?>" class="proceed-btn">PROCEED TO CHECK OUT</a>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->
<?= $this->endSection() ?>