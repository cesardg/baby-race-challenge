<div class="container">
    <div class="intro__button__wrapper intro__button__wrapper--shop">
        <div>
            <h1 class="page__title"> <?php echo $title ?></h1>
            <p class="page__intro page__intro--shop">Baby races zijn leuk. Maar als je wilt dat uw baby een tandje bijsteekt kun je hem pimpen. In deze shop vind je ethisch verantwoordde modificaties die je baby kunnen helpen om je race te winnen. Bovendien gaat 30% van de omzet naar een goed doen, klik <a class="shopping__cart__link" href="index.php?page=shop#givingBack">hier</a> voor meer info.</p>
        </div>
        <div class="image__cart__wrapper">
            <div class="icon__cart__wrapper">
                <a class="shopping__cart__link" href="index.php?page=cart">winkelbuggy</a>
                <div>
                    <a href="index.php?page=cart"> <img src="assets/img/winkelbuggy.svg" alt="winkelbuggy icoontje"></a>
                    <a href="index.php?page=cart" class="cart__amount"><?php echo $numItems; ?></a>
                </div>
            </div>
            <img class="shop__img" src="assets/img/handjemettools.png" alt="baby met werkttuig" width="139" height="220">
        </div>
    </div>
    <div class="container__shop">

        <?php foreach ($shopitems as $shopitem) : ?>
            <div class="shop__item">
                <div class="shop__image__container">
                    <img src="assets/shop/<?php echo $shopitem['path']; ?>" alt="productfoto <?php echo $shopitem['title']; ?> " width="554" height="358">
                </div>
                <div class="shop__details__container">
                    <p class="shop__item__name"><?php echo $shopitem['title']; ?></p>
                    <p class="shop__properties">Voordelen:</p>
                    <ul class="shop__properties__list">
                        <?php echo $shopitem['description']; ?>
                    </ul>
                    <div class="price__button__wrapper">
                        <p class="shop__price">€ <?php echo $shopitem['price']; ?></p>
                        <form method="post" action="index.php?page=cart">
                            <input type="hidden" name="product_id" value="<?php echo $shopitem['id']; ?>" />
                            <button class="shop__card__button" type="submit" name="action" value="add">Leg in winkelbuggy</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <article id=givingBack>
        <h3 class="content__title">Giving back</h3>
        <div class="giving--back__container">
            <p>
                Overgewicht is een groot probleem in de ontwikkelde
                landen. In de derde wereldlanden zorgt ondergewicht juist voor een hoog sterfte cijfer. Een balans waar wij samen verandering in kunnen brengen 30% van de omzet van deze webshop gaat naar een fundraising om voedselpakketten te doneren aan organisaties in derde wereldlanden.
            </p>
            <img src="assets/img/givingback.png" alt="foto giving back" class="giving__back--img" width="553" height="252">
        </div>
    </article>


</div>