<div class="container">
  <article class="form__container">
    <form method="post" action="index.php?page=login" class="login__form">
      <h2 class="content__title content__title--join">U heeft al een account, welkom terug</h2>
      <div class="form-group row">
        <label for="loginFormInputEmail" class="col-sm-2 col-form-label">Email adres</label>
        <div class="col-sm-10">
          <input id="loginFormInputEmail" class="input__form__add form-control" type="email" name="email" required value="<?php if (!empty($_POST['email'])) echo $_POST['email']; ?>" />

          <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['email'])) {
                                                                              echo '<p>' . $errors['email'] . '</p>';
                                                                            } ?></span>
        </div>
      </div>
      <div class="form-group row">
        <label for="loginFormInputPass" class="col-sm-2 col-form-label">Paswoord</label>
        <div class="col-sm-10">
          <input id="loginFormInputPass" class="input__form__add form-control" type="password" name="password" required />
          <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['password'])) {
                                                                              echo '<p>' . $errors['password'] . '</p>';
                                                                            } ?></span>
        </div>
      </div>
      <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
          <input class="btn btn-primary" type="submit" value="Login" />
        </div>
      </div>
    </form>
    <div class="no__acount">
      <h2 class="content__title content__title--register"> Ik heb nog geen account</h2>
      <p class="shop__properties">Voordelen van een account:</p>
      <ul class="shop__properties__list login__advantiges">
        <li class="properties__list--item">Toegang tot onze baby race tune shop</li>
        <li class="properties__list--item">Foto's plaatsen en comments toevoegen</li>
        <li class="properties__list--item">Vragen stellen aan onze kruip experts</li>
      </ul>
      <a class="btn-primary register__Link" href="index.php?page=register">Maak account</a>
    </div>
  </article>
</div>