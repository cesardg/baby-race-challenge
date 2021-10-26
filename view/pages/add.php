<div class="form__add__container">
    <h1 class="content__title content__title--add">Voeg een foto toe in 3 stappen</h1>

    <div class="form__baby--wrapper">
        <div>
            <img class="form__add__image" src="assets/img/babykruip2.png" alt="foto baby kruipt" height="170">
        </div>
        <form method="post" action="index.php?page=add" enctype="multipart/form-data" class="form form__add">

            <input type="hidden" name="action" value="add-image" />
            <div class="form-field">
                <div class="form__steps">
                    <p>1</p>
                    <div>
                        <p class="form__step">Neem deel aan de baby race challenge en neem een foto.</p>
                        <p class="form__info__grey">Meer info over de challenge vind je <a href="index.php#moreInfo">hier.</a></p>
                    </div>
                </div>
                <div class="form__steps">
                    <p>2</p>
                    <div>
                        <p class="form__step form__step--file">Upload een foto van je kruipende baby.</p>

                        <input class="input__form__add  form__info__grey custom-file-input" type="file" name="image" required accept="image/png, image/jpeg, image/gif">

                        <span class="form-control-feedback form-control-feedback--add--file"><?php if (!empty($error)) {
                                                                                                    echo '<p>' . $error . '</p>';
                                                                                                } ?></span>

                    </div>
                </div>

            </div>
            <div class="form__steps form__steps--last">
                <p>3</p>
                <div>
                    <p class="form__step">Vul u gegevens in.</p>
                    <label class="form__info__grey">Naam van u baby
                        <input class="input__title input__form__add input__form__add--name" type="text" name="name-baby" required maxlength="100" value="<?php if (!empty($_POST['name-baby'])) {
                                                                                                                                                                echo $_POST['name-baby'];
                                                                                                                                                            } ?>">
                        <span class="form-control-feedback form-control-feedback--add"><?php if (!empty($errors['name-baby'])) {
                                                                                            echo '<p>' . $errors['name-baby'] . '</p>';
                                                                                        } ?></span>
                    </label>
                    <label class="form__info__grey">Naam van u partner of vriend(in)
                        <input class="input__title input__form__add" type="text" name="name-partner" required maxlength="100" value="<?php if (!empty($_POST['name-partner'])) {
                                                                                                                                            echo $_POST['name-partner'];
                                                                                                                                        } ?>">
                        <span class="form-control-feedback form-control-feedback--add"><?php if (!empty($errors['name-partner'])) {
                                                                                            echo '<p>' . $errors['name-partner'] . '</p>';
                                                                                        } ?></span>
                    </label>
                    <label class="form__info__grey">Tijd om 10 meter te kruipen (minuten:seconden)
                        <input class="input__title input__form__add input__form__add--time" type="time" required name="time" value="<?php if (!empty($_POST['time'])) {
                                                                                                                                        echo $_POST['time'];
                                                                                                                                    } ?>">
                        <span class="form-control-feedback form-control-feedback--add"><?php if (!empty($errors['time'])) {
                                                                                            echo $errors['time'];
                                                                                        } ?></span>
                    </label>
                </div>
            </div>
            <div class="form-field form__steps">
                <div class="form__steps--button">
                    <img src="assets/img/finishpaars.svg" alt="finsih line" height="72">
                    <input type="submit" value="Plaats bericht" class="submit upload__button">
                </div>
            </div>
        </form>
    </div>
    <div class="form__add__image2">
        <img src="assets/img/blokjesgeel.png" alt="speel blokjes" height="180">
    </div>

</div>