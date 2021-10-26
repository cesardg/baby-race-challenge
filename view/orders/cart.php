  <div class="container">

    <h1 class="page__title page__title--winkelbuggy"> <?php echo $title ?></h1>
    <div id="content" class="cart__tune--shop">




      <?php if (empty($_SESSION['cart'])) : ?>
        <p class="empty__cart--message"> Het is redelijk leeg hier, ga naar de <a href="index.php?page=shop"> tune shop </a> en leg iets in je winkelbuggy</p>
      <?php else : ?>

        <form action="index.php?page=cart" method="post" id="cartform" class="shopping__cart__form">
          <table class='cart__tune--shop'>
            <thead>
              <tr>
                <th class='product-description' colspan='2'></th>
                <th class='price'>Prijs</th>
                <th class='quantity'>Hoeveelheid</th>
                <th class='remove-item'></th>
                <th class='total'>Totaal</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $total = 0;
              foreach ($_SESSION['cart'] as $item) {
                $itemTotal = $item['product']['price'] * $item['quantity'];
                $total += $itemTotal;
              ?>
                <tr class="item">
                  <td class='product-image'>
                    <a href="index.php?page=shop">
                      <img src="assets/shop/<?php echo $item['product']['path']; ?>" alt="<?php echo $item['product']['title']; ?>" />
                    </a>
                  </td>
                  <td class='product-description'>
                    <?php echo $item['product']['title']; ?>
                  </td>
                  <td class='price price__cart'>€ <?php echo $item['product']['price']; ?></td>
                  <td class='quantity'> <input class="text quantity replace" type="text" name="quantity[<?php echo $item['product']['id']; ?>]" value="<?php echo $item['quantity']; ?>" /> </td>
                  <td class='remove-item'><button type="submit" class="btn remove-from-cart" name="remove" value="<?php echo $item['product']['id']; ?>">Remove</button></td>
                  <td class='total price__cart price__cart--total'>€ <?php echo  $itemTotal ?></td>
                </tr>
              <?php
              }
              ?>


            </tbody>
          </table>
          <div class='column two'>
            <p class='order-total'><span>Totaal:</span> €<?php echo $total ?></p>
            <p><button type="submit" id="update-cart" class="update__cart--button" name="action" value="update">Update Cart</button></p>

            <p><button class="update__cart--button checkout__cart--button" type="submit" id="checkout" name="action" value="checkout">Checkout</button></p>

          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>