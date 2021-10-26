<div class="container">
  <article id="content" class="form__container--register">

    <h2 class="content__title content__title--registerpage">Sluit je aan bij onze community</h2>
    <div class="form__info__wrapper">


      <form action="index.php?page=register" method="post" enctype="multipart/form-data" class="form-horizontal">

        <div class="form-group">
          <label class="col-sm-2 col-form-label" for="registerVoornaam">Voornaam</label>
          <div class="col-sm-10">
            <input type="text" name="voornaam" id="registerVoornaam" placeholder="John" required class="register__form--mid input__form__add form-control<?php if (!empty($errors['voornaam'])) echo ' form-control-danger'; ?>" value="<?php if (!empty($_POST['voornaam'])) echo $_POST['voornaam']; ?>" />
            <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['voornaam'])) {
                                                                                echo '<p>' . $errors['voornaam'] . '</p>';
                                                                              } ?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-form-label" for="registerNaam">Naam</label>
          <div class="col-sm-10">
            <input type="text" name="naam" id="registerNaam" placeholder="Doe" required class="register__form--mid input__form__add form-control<?php if (!empty($errors['naam'])) echo ' form-control-danger'; ?>" value="<?php if (!empty($_POST['naam'])) echo $_POST['naam']; ?>" />
            <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['naam'])) {
                                                                                echo '<p>' . $errors['naam'] . '</p>';
                                                                              } ?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-form-label" for="registerGebruikersnaam">Gebruikersnaam</label>
          <div class="col-sm-10">
            <input type="text" name="gebruikersnaam" id="registerGebruikersnaam" required placeholder="johndoe" class="register__form--mid input__form__add form-control<?php if (!empty($errors['gebruikersnaam'])) echo ' form-control-danger'; ?>" value="<?php if (!empty($_POST['gebruikersnaam'])) echo $_POST['gebruikersnaam']; ?>" />
            <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['gebruikersnaam'])) {
                                                                                echo '<p>' . $errors['gebruikersnaam'] . '</p>';
                                                                              } ?></span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-form-label" for="registerEmail">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email" id="registerEmail" required placeholder="john.doe@example.com" class="register__form--long input__form__add form-control<?php if (!empty($errors['email'])) echo ' form-control-danger'; ?>" value="<?php if (!empty($_POST['email'])) echo $_POST['email']; ?>" />
            <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['email'])) {
                                                                                echo '<p>' . $errors['email'] . '</p>';
                                                                              } ?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-form-label" for="registerPassword">Paswoord</label>
          <div class="col-sm-10">
            <input type="password" name="password" id="registerPassword" required class="register__form--long input__form__add form-control<?php if (!empty($errors['password'])) echo ' form-control-danger'; ?>" />
            <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['password'])) {
                                                                                echo '<p>' . $errors['password'] . '</p>';
                                                                              } ?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-form-label" for="registerConfirmPassword">Herhaal paswoord:</label>
          <div class="col-sm-10">
            <input type="password" name="confirm_password" id="registerConfirmPassword" required class="register__form--long input__form__add form-control<?php if (!empty($errors['confirm_password'])) echo ' form-control-danger'; ?>" />
            <span class="form-control-feedback form-control-feedback--login"><?php if (!empty($errors['confirm_password'])) {
                                                                                echo '<p>' . $errors['confirm_password'] . '</p>';
                                                                              } ?></span>
          </div>
        </div>

        <div>
          <p class="col-sm-2 col-form-label form__step--file">Profielfoto (optioneel)</p>
          <input class="input__form__add  form__info__grey custom-file-input custom-file-input--register" type="file" name="image" accept="image/png, image/jpeg, image/gif">

          <span class="form-control-feedback form-control-feedback--add--file"><?php if (!empty($errors['image'])) {
                                                                                  echo '<p>' . $errors['image'] . '</p>';
                                                                                } ?></span>
        </div>

        <div class="form-group row">
          <div class="offset-sm-2 col-sm-10">
            <input type="submit" value="Maak account" class="btn btn-primary btn-primary--acount">
          </div>
        </div>
      </form>

      <div class="no__acount no__acount--register">

        <p class="shop__properties">Voordelen van een account:</p>
        <ul class="shop__properties__list login__advantiges">
          <li class="properties__list--item">Toegang tot onze baby race tune shop</li>
          <li class="properties__list--item">Foto's plaatsen en comments toevoegen</li>
          <li class="properties__list--item">Vragen stellen aan onze kruip experts</li>
        </ul>

      </div>
    </div>
    <div class="form__add__image2 form__register__image">
      <img src="assets/img/blokjesgeel.png" alt="speel blokjes" height="180">
    </div>
  </article>
</div>