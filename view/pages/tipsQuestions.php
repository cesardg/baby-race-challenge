<div class="container">
    <div class="intro__button__wrapper">
        <div>
            <h1 class="page__title"> <?php echo $title ?></h1>
            <p class="page__intro page__intro--tips">Als jonge ouders heb je veel vragen over de motorische ontwikkeling van je kinderen. We hopen met de tips van Louis en Marie, onze 2 experten je honger te stillen. Is dat niet het geval, dan kun je u vragen <a class="shopping__cart__link" href="index.php?page=tipsQuestions#questionPart">hieronder</a> gerust stellen.</p>
        </div>
        <img class="tips__img" src="assets/img/2experts.png" alt="2 baby experts" height="320">
    </div>
    <article class="tips__container">
        <h2 class="no__display">Kruip tips</h2>
        <div class="tip__square  tip__square--number">
            <p>1</p>
        </div>
        <div class="tip__square tip__square--text">
            <p> <span class="tip__important tip__important--first">Een zachte ondergrond.</span> Zorg dat de ondergrond niet te glad, maar wel zacht en stevig is. Een lap vloerbedekking of speeltegels van foam zijn ideaal.</p>
        </div>
        <div class="tip__square  tip__square--number">
            <p>2</p>

        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Zorg voor een veilige kruipomgeving.</span> Werk snoeren, stopcontacten, planten en scherpe hoeken en randen weg, of dek ze veilig af. </p>
        </div>
        <div class="tip__square  tip__square--bol">

        </div>
        <div class="tip__square  tip__square--img">
            <img class="tip__square--img--bloks" src="assets/img/blokjesroze.png" alt="speel blokjes" width="290" height="251">
        </div>
        <div class="tip__square tip__square--number tip__square--number3">
            <p>3</p>
        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Een lange broek.</span> Trek je baby een lange broek aan. Dit beschermt zijn knieën en zo hoeft hij niet met zijn blote benen over de koude grond te kruipen.</p>
        </div>
        <div class="tip__square  tip__square--img">
            <img class="tip__square--img--baby3" src="assets/img/babykruip3.png" alt="baby kruipt" width="180">
        </div>
        <div class="tip__square tip__square--number tip__square--number4">
            <p>4</p>
        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Stimuleer je baby.</span> Moedig je kindje aan en geef hem complimentjes als het lukt. Dit is goed voor zijn zelfvertrouwen en hij zal er van gaan stralen.</p>
        </div>
        <div class="tip__square  tip__square--img">
            <img class="tip__square--img--torentje" src="assets/img/torentje.png" alt="torentje" width="260">
        </div>
        <div class="tip__square tip__square--number tip__square--number5">
            <p>5</p>
        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Accepteer het als het anders gaat.</span> Vind je dat je baby een wel heel creatieve manier van voortbewegen heeft? Laat hem lekker zijn gang gaan, elk kindje heeft zijn eigen ‘kruipstijl’</p>
        </div>
        <div class="tip__square tip__square--number">
            <p>6</p>
        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Zet je baby niet te vroeg in een zittende houding.</span> Vanuit een liggende positie heeft hij veel meer bewegings-vrijheid om te bewegen en te leren kruipen. </p>
        </div>
        <div class="tip__square  tip__square--img tip__square--img4">
            <img class="tip__square--img--baby4" src="assets/img/babykruip4.png" alt="baby kruipt" width="160">
        </div>
        <div class="tip__square tip__square--number">
            <p>7</p>
        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Laat je baby regelmatig oefenen.</span> In het begin zal hij nog snel moe worden en veel omvallen. Geef hem dan ook voldoende rust. Morgen weer een dag.</p>
        </div>
        <div class="tip__square tip__square--number tip__square--number5">
            <p>8</p>
        </div>
        <div class="tip__square tip__square--text">
            <p><span class="tip__important">Doe gezellig mee met je kleine.</span> Door het voor te doen kan hij bij jou de kunst afkijken. Bovendien kan je baby er enthousiast van worden wanneer hij jou ziet kruipen.</p>
        </div>


    </article>
    <div class="content__title--rules__wrapper">
        <span class="red__line purple__line"></span>
        <p class="content__title content__title--rules content__title--forum">Stel hier u vragen aan Marie en Louis</p>
        <span class="red__line  purple__line"></span>
    </div>
    <article class="forum__container" id="questionPart">
        <h2 class="no__display">Stel hier u vragen aan Marie en Louis</h2>

        <form method="get" action="index.php?page=tipsQuestions" class="search__form">
            <input class="search__field" id="search-title" type="search" name="search-title" placeholder="Zoeken op onderwerp..." value="<?php if (!empty($_GET['search-title'])) echo $_GET['search-title']; ?>">
            <input class="search__button search__button__lay--out" type="submit" value="zoeken">
            <input type="hidden" name="page" value="tipsQuestions" />
        </form>

        <div class="form__dropdown__container">

            <input id="tab1" type="checkbox" class="radio__accordeon   <?php if (empty($_SESSION['user'])) echo 'radio__accordeon--short' ?>" name="tab">
            <p class="ask__question--button"><label for="tab1">Stel hier uw vraag</label></p>
            <div class="question__form__image__container">

                <?php if (empty($_SESSION['user'])) : ?>
                    <div class="no__user__message no__user__message--question">
                        <p>Log u <a class="shopping__cart__link" href="index.php?page=login">hier</a> in om een vraag te stellen.</p>
                    </div>
                    <div class="question__form__img">
                        <img src="assets/img/2experts.png" alt="2 baby experts" width="150">
                    </div>
                <?php else : ?>

                    <form method="post" action="index.php?page=tipsQuestions" class="form question__form">
                        <input type="hidden" name="action" value="ask-question" />
                        <div class="form-field">
                            <label class="col-form-label">Onderwerp
                                <input class="input__title input__form__add comment__field--question register__form--long" type="text" name="topic" required maxlength="100" value="<?php if (!empty($_POST['topic'])) {
                                                                                                                                                                                        echo $_POST['topic'];
                                                                                                                                                                                    } ?>">
                                <span class="form-control-feedback form-control-feedback--question"><?php if (!empty($errors['topic'])) {
                                                                                                        echo '<p>' . $errors['topic'] . '</p>';
                                                                                                    } ?></span>
                            </label>

                        </div>
                        <div class="form-field">
                            <label class="col-form-label">Vraag
                                <textarea class="input__form__add comment__field--question" name="question" required maxlength="400" cols="40" rows="3"><?php if (!empty($_POST['question'])) {
                                                                                                                                                            echo $_POST['question'];
                                                                                                                                                        } ?></textarea>
                                <span class="form-control-feedback form-control-feedback--question"><?php if (!empty($errors['question'])) {
                                                                                                        echo '<p>' . $errors['question'] . '</p>';
                                                                                                    } ?></span>
                            </label>

                        </div>
                        <div class="form-field form-field__question--button form-field__question--button--question">
                            <input type="submit" value="Vraag toevoegen" class="submit search__button upload__button">
                        </div>
                    </form>
                    <div class="question__form__img">
                        <img src="assets/img/2experts.png" alt="2 baby experts" width="549" height="373">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($_SESSION['info'])) : ?>
            <div class="session__info__lay--out session__info__page">

                <?php echo $_SESSION['info']; ?>
            </div>
        <?php endif; ?>
        <div class="not__found__message">
            <?php

            if (empty($questions)) {
                echo '<p>Oeps, er zijn geen vragen over dit onderwerp, je kan zelf wel een vraag stellen</p>';
            }
            ?>
        </div>
        <div class="posted__question__container">

            <?php foreach ($questions as $question) : ?>


                <div class="post__question__wrapper" id=awnser<?php echo $question['id']; ?>>
                    <div class="post__question">
                        <p>Onderwerp: <span><?php echo $question['topic']; ?></span></p>
                        <div class="post__question--flex">
                            <img class="post__question--img" src="assets/uploads/<?php echo $question['user'][0]['path']; ?>" alt="profiel foto vraagsteller" width="100" height="100">
                            <div>
                                <p class="post__question--name"><?php echo $question['user'][0]['gebruikersnaam']; ?></p>
                                <p class="post__question--question"><?php echo $question['question']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="post__question post__awnsers">
                        <p>
                            Antwoorden (<span class="amount__awnsers--<?php echo $question['id'] ?>"><?php echo count($question['awnsers']); ?></span>):
                        </p>

                        <div class="awnsers__container--overflow awnsers__container--overflow--<?php echo $question['id'] ?>">
                            <?php if (empty($question['awnsers'])) {
                                echo '<p class="no__awnsers__question"> Er zijn nog geen antwoorden op deze vraag. <br> Voeg een antwoord toe hieronder.</p>';
                            } ?>
                            <?php foreach ($question['awnsers'] as $awnser) : ?>


                                <div class="post__awnser post__question--flex ">
                                    <img class="post__question--img" src="assets/uploads/<?php echo $awnser['path']; ?>" alt="profielfoto" width="90" height="90">
                                    <div>
                                        <p class="post__question--name"><?php echo $awnser['gebruikersnaam']; ?></p>
                                        <p class="post__question--question post__question--question--awnser "><?php echo $awnser['awnser']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div>

                            <?php if (empty($_SESSION['user'])) : ?>
                                <div class="no__user__message no__user__message--awnser">
                                    <p>Log u <a class="shopping__cart__link" href="index.php?page=login">hier</a> in om een antwoord te posten</p>
                                </div>
                            <?php else : ?>


                                <form method="post" action="index.php?page=tipsQuestions" enctype="multipart/form-data" class="form question__form awnser__form">
                                    <input type="hidden" name="action" value="post-awnser" />
                                    <input type="hidden" name="user-id" value="  <?php echo $_SESSION['user']['id'] ?>" />
                                    <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>" />
                                    <div class="form-field">
                                        <label class="col-form-label">
                                            <!-- hier geen required nodig want het anwtwoord van de server bevat een error als het leeg is door progressive enhancement, anders zou dit ook vechten met validatejs-->
                                            <textarea class="input__form__add comment__field--question input__form__add--<?php echo $question['id']; ?>" name="awnser" maxlength="500" cols="40" rows="3"></textarea>
                                            <span class="form-control-feedback form-control-feedback--question form-control-feedback--question--<?php echo $question['id']; ?>"><?php if (!empty($errors['awnser'])) {
                                                                                                                                                                                    echo '<p>' . $errors['awnser'] . '</p>';
                                                                                                                                                                                } ?></span>
                                        </label>

                                    </div>
                                    <div class="form-field form-field__question--button form-field__awnser--button">
                                        <input type="submit" value="Antwoord toevoegen" class="submit search__button upload__button">
                                    </div>
                                </form>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </article>



</div>