<?php
$session = session();
$uri = service('uri');
$cart = \Config\Services::cart();
$items = $cart->contents();
?>
<!-- Header Section Begin -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-right">
                <?php if ($session->get('isLoggedIn')) : ?>
                    <a href="<?= site_url('logout') ?>" class="login-panel"><i class="fa fa-user"></i>Logout ( <?= $session->get('username') ?> )</a>
                <?php else : ?>
                    <a href="<?= site_url('login') ?>" class="login-panel"><i class="fa fa-user"></i>Login</a>
                <?php endif ?>
                <div class="top-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        <a href="./index.html">
                            <img src="<?= base_url('aset/img/logochana.png') ?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="advanced-search">
                        <button type="button" class="category-btn">Kategori</button>
                        <div class="input-group">
                            <input type="text" placeholder="Butuh mu opo?">
                            <button type="button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                <span>1</span>
                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="#">
                                <i class="icon_bag_alt"></i>
                                <span><?php echo (!empty($items)) ? $cart->totalItems() : 0; ?></span>
                            </a>
                            <div class="cart-hover">
                                <?php
                                if (!empty($items)) :
                                ?>
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                <?php
                                                foreach ($items as $index => $item) :
                                                ?>
                                                    <tr>
                                                        <td class="si-pic"><img src="<?= base_url('uploads/' . $item['options']['foto'] . '') ?>" alt="" style="width:100px"></td>
                                                        <td class="si-text">
                                                            <div class="product-selected">
                                                                <p><?php echo number_to_currency($item['price'], 'IDR') ?> x <?php echo $item['qty'] ?></p>
                                                                <h6><?php echo $item['name'] ?></h6>
                                                            </div>
                                                        </td>
                                                        <td class="si-close">
                                                            <a href="<?= site_url('shop/delete/' . $item['rowid'] . '') ?>"><i class="ti-close"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5><?php echo (!empty($items)) ? number_to_currency($cart->total(), 'IDR') : 0 ?></h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="<?= site_url('shop/cart') ?>" class="primary-btn view-card">VIEW CARD</a>
                                        <a href="<?= site_url('shop/checkout') ?>" class="primary-btn checkout-btn">CHECK OUT</a>
                                    </div>
                                <?php
                                else :
                                    echo "Cart Empty";
                                endif;
                                ?>
                            </div>
                        </li>
                        <li class="cart-price"><?php echo (!empty($items)) ? number_to_currency($cart->total(), 'IDR') : 0 ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            <div class="nav-depart">
                <div class="depart-btn">
                    <i class="ti-menu"></i>
                    <span>Kategori</span>
                    <ul class="depart-hover">
                        <li class="active"><a href="<?= site_url('shop/category/2') ?>">Tenda</a></li>
                        <li><a href="<?= site_url('shop/category/1') ?>">Carrier</a></li>
                        <li><a href="<?= site_url('shop/category/3') ?>">Meja & Kursi</a></li>
                    </ul>
                </div>
            </div>
            <nav class="nav-menu mobile-menu">
                <ul>
                    <li <?= ($uri->getSegment(1) == '') ? 'class="active"' : '' ?>><a href="<?= site_url('/') ?>">Home</a></li>
                    <li <?= ($uri->getSegment(1) == 'shop') ? 'class="active"' : '' ?>><a href="<?= site_url('shop') ?>">Selengkapnya</a></li>
                    <li <?= ($uri->getSegment(1) == 'contact') ? 'class="active"' : '' ?>><a href="<?= site_url('contact') ?>">Kontak & Pemesanan</a></li>
                    <?php if ($session->get('isLoggedIn')) : ?>
                        <li <?= ($uri->getSegment(1) == 'transaction') ? 'class="active"' : '' ?>><a href="<?= site_url('transaction') ?>">Transaksi</a></li>
                    <?php endif ?>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>
<!-- Header End -->