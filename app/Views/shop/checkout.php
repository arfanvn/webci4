<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php $session = session(); ?>
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                    <a href="./shop.html">Shop</a>
                    <span>Check Out</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <?= form_open('buy', 'class="checkout-form"') ?>
        <?= form_hidden('id_user', $session->get('id')) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>
        <div class="row">
            <div class="col-lg-6">
                <h4>Billing Details</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="fir">Nama<span>*</span></label>
                        <input type="text" id="fir" value="<?= $session->get('username') ?>">
                    </div>
                    <div class="col-lg-12">
                        <label for="street">Alamat<span>*</span></label>
                        <input type="text" id="alamat" name="alamat" class="street-first" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="town">Provinsi<span>*</span></label>
                        <select class="form-control" id="provinsi" required>
                            <option>Pilih Provinsi</option>
                            <?php foreach ($provinsi as $p) : ?>
                                <option value="<?= $p->province_id ?>"><?= $p->province ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label for="town">Kabupaten/Kota<span>*</span></label>
                        <select class="form-control" id="kabupaten" required>
                            <option>Pilih Kabupaten/kota</option>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label for="town">Layanan<span>*</span></label>
                        <select class="form-control" id="service" required>
                            <option>Pilih Layanan</option>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label for="street">Estimasi<span></span></label>
                        <span id="estimasi"></span>
                    </div>
                    <div class="col-lg-12">
                        <label for="street">Ongkir<span>*</span></label>
                        <input type="text" id="ongkir" name="ongkir" readonly>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="place-order">
                    <h4>Your Order</h4>
                    <div class="order-total">
                        <ul class="order-table">
                            <li>Product <span>Total</span></li>
                            <?php
                            if (!empty($items)) :
                                foreach ($items as $index => $item) :
                            ?>
                                    <li class="fw-normal"><?php echo $item['name'] ?> x <?php echo $item['qty'] ?> <span><?php echo number_to_currency($item['price'] * $item['qty'], 'IDR') ?></span></li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                            <?php if ($diskon) :
                                foreach ($diskon as $diskon) : ?>
                                    <li class="fw-normal">Subtotal <span><?php echo number_to_currency($total, 'IDR') ?></span></li>
                                    <li class="fw-normal">Diskon <span><?= $diskon['diskon'] ?>%</span></li>
                                    <?php
                                    $besarDiskon = ($total * $diskon['diskon']) / 100;
                                    $hargaSetelahDiskon = $total - $besarDiskon;
                                    ?>
                                    <li class="total-price">Total <span id="total"><?php echo number_to_currency($hargaSetelahDiskon, 'IDR') ?></span></li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <li class="fw-normal">Subtotal <span><?php echo number_to_currency($total, 'IDR') ?></span></li>
                                <li class="total-price">Total <span id="total"><?php echo number_to_currency($total, 'IDR') ?></span></li>
                            <?php endif; ?>
                        </ul>
                        <div class="order-btn">
                            <button type="submit" class="site-btn place-btn">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</section>
<!-- Shopping Cart Section End -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $('document').ready(function() {
        var ongkir = 0;
        $("#provinsi").on('change', function() {
            $("#kabupaten").empty();
            var id_province = $(this).val();
            $.ajax({
                url: "<?= site_url('shop/getcity') ?>",
                type: 'GET',
                data: {
                    'id_province': id_province,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var results = data["rajaongkir"]["results"];
                    for (var i = 0; i < results.length; i++) {
                        $("#kabupaten").append($('<option>', {
                            value: results[i]["city_id"],
                            text: results[i]['city_name']
                        }));
                    }
                },

            });
        });

        $("#kabupaten").on('change', function() {
            var id_city = $(this).val();
            $.ajax({
                url: "<?= site_url('shop/getcost') ?>",
                type: 'GET',
                data: {
                    'origin': 399,
                    'destination': id_city,
                    'weight': 1000,
                    'courier': 'jne'
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var results = data["rajaongkir"]["results"][0]["costs"];
                    for (var i = 0; i < results.length; i++) {
                        var text = results[i]["description"] + "(" + results[i]["service"] + ")";
                        $("#service").append($('<option>', {
                            value: results[i]["cost"][0]["value"],
                            text: text,
                            etd: results[i]["cost"][0]["etd"]
                        }));
                    }
                },

            });
        });

        $("#service").on('change', function() {
            var estimasi = $('option:selected', this).attr('etd');
            ongkir = parseInt($(this).val());
            var total = ongkir + <?= $hargaSetelahDiskon ?? $total ?>;
            $("#ongkir").val(ongkir);
            $("#estimasi").html(estimasi + " Hari");
            $("#total").html("IDR " + total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
            $("#total_harga").val(total);
        });
    });
</script>
<?= $this->endSection() ?>