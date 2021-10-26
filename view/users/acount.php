<div class="container">
  <div class="form__container--acount">
    <article>
      <div class="title--acount__button__wrapper">
        <h1 class="acount__title">Uw account gegevens</h1>
        <a class="shop__card__button acount__logout" href="index.php?page=logout">Log uit</a>
      </div>
      <div class="acount__info__wrapper">
        <img class="acount__pf" src="assets/uploads/<?php echo $_SESSION['user']['path']; ?>" alt="profielfoto" height="180" width="180">
        <div>
          <p class="acount__field">Naam:</p>
          <p class="acount__field--value"><?php echo $_SESSION['user']['voornaam']; ?> <?php echo $_SESSION['user']['naam']; ?></p>
          <p class="acount__field">Gebruikersnaam:</p>
          <p class="acount__field--value"><?php echo $_SESSION['user']['gebruikersnaam']; ?></p>
          <p class="acount__field">Email:</p>
          <p class="acount__field--value"><?php echo $_SESSION['user']['email']; ?></p>
        </div>
      </div>
    </article>
    <article>
      <div class="title--acount__button__wrapper">
        <h2 class="acount__title">Uw foto's</h2>
        <a class="shop__card__button" href="index.php?page=add">Post een foto</a>
      </div>
      <?php if (empty($userPosts)) : ?>
        <p>U heeft nog geen foto's gepost. Post <a class="shopping__cart__link" href="index.php?page=add">hier</a> uw eerste foto.</p>
      <?php endif; ?>
      <div class="post__gallery__container post__gallery__container--account">
        <?php foreach ($userPosts as $post) : ?>
          <a class="post__gallery--link post__gallery--link--account" href="index.php?page=detail&id=<?php echo $post['id']; ?>">
            <div class="post__card--hof">
              <div class="filter__wrapper">
                <img class="post__card--hof--img" src="assets/uploads/<?php echo $post['path']; ?>" alt="post kruipende baby <?php echo $post['name']; ?>" width="323" height="323">
                <div class="post__filter">
                  <p>hier komt filter</p>
                </div>
                <img class="post__finish__filter" src="assets/img/finishpostfilter.svg" alt="finish filter" width="201" height="65">
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </article>
  </div>
</div>