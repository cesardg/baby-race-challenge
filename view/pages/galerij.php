<div class="container">
    <div class="intro__button__wrapper">
        <div>
            <h1 class="page__title"> <?php echo $title ?></h1>
            <p class="page__intro">In de galerij vind je een uniek overzicht van alle babies die jou voor waren in de baby race challenge. Wens je hierin een plaatsje te verzilveren, doe dan mee aan de challenge en post een foto. Vergeet vooral niet de naam en snelheid van uw baby te vermelden.</p>
        </div>
        <a href="index.php?page=add" class="add--photo__big__button">
            <p><span class="big__plus__sign">+ </span> <br>Voeg een foto toe
            </p>
        </a>
    </div>

    <div class="filter__sort filter__view">

        <form action="index.php" method="get" class="filter__sort--form">
            <input type="hidden" name="page" value="galerij" />
            <div>
                <p class="sort__options--name">Weergave:</p>
                <div class="sort__options">

                    <input type="radio" class="filter__field" id="id4" name="view" <?php if (!isset($_GET['view']) || $_GET['view'] == 'klassiek') echo 'checked';
                                                                                    ?> value="klassiek">
                    <label for="id4">Klassiek</label>
                    <input type="radio" class="filter__field" id="id5" name="view" <?php if (isset($_GET['view']) && $_GET['view'] == 'racetrack') echo 'checked';
                                                                                    ?> value="racetrack">
                    <label for="id5">Racebaan</label>

                </div>
            </div>
            <div>
                <p class="sort__options--name">Sorteren op:</p>
                <div class="sort__options">

                    <input type="radio" class="filter__field" id="id1" name="sort" <?php if (!isset($_GET['sort']) || $_GET['sort'] == 'recent') echo 'checked';
                                                                                    ?> value="recent">
                    <label for="id1">Recent</label>
                    <input type="radio" class="filter__field" id="id2" name="sort" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'snelheid') echo 'checked';
                                                                                    ?> value="snelheid">
                    <label for="id2">Snelheid</label>
                </div>
            </div>
            <div class="sort__button">
                <input type="submit" value="Pas toe" class="btn-primary sort__button--js">
            </div>
        </form>
    </div>


    <div class="post__gallery__container--racetrack">
        <div class="post__gallery__container">
            <?php if ((isset($_GET['view']) && $_GET['view'] == 'racetrack')) : ?>
                <div class="post__gallery__container--racetrack">
                    <?php foreach ($posts as $index => $post) : ?>
                        <div class="racetrack__item">
                            <div class="racetrack__item--info">
                                <p><?php echo $index + 1 ?> </p>
                                <div>
                                    <div class="racetrack__item--wrapper racetrack__item--wrapper--<?php echo $post['id']; ?>">
                                        <p class="no__display racetrack__time"><?php echo $post['time']; ?></p>
                                        <p class="no__display racetrack__id"><?php echo $post['id']; ?></p>
                                        <p class="racetrack__name"> <a href="index.php?page=detail&id=<?php echo $post['id']; ?>"> <?php echo $post['name']; ?> </a>
                                        </p>
                                        <a href="index.php?page=detail&id=<?php echo $post['id']; ?>"> <img class="racetrack__img" src="assets/uploads/<?php echo $post['path']; ?>" alt="foto baby" width="150" height="150"> </a>
                                    </div>
                                </div>
                            </div>
                            <img class="finishline__racetrack" src="assets/img/finishlineracetrack.svg" alt="finishline" height="250">
                        </div>
                    <?php endforeach; ?>

                <?php else : ?>

                    <?php foreach ($posts as $post) : ?>
                        <a class="post__gallery--link" href="index.php?page=detail&id=<?php echo $post['id']; ?>">
                            <div class="post__card--hof post__card--gallery">
                                <div class="name__time__wrapper">
                                    <p class="post__name <?php if (strlen($post['name']) > 8) echo 'big__name--smaller'; ?>"><?php echo $post['name']; ?></p>
                                    <div class="icoon__time__wrapper">
                                        <img src="assets/img/chronoicoonsmall.png" alt="icoon chronometer" width="27" height="30">
                                        <p class="post__time"><?php echo $post['time']; ?></p>
                                    </div>
                                </div>
                                <p class="post__parents">Baby van <?php echo $post['user'][0]['gebruikersnaam']; ?> en <?php echo $post['parent2']; ?></p>
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

                <?php endif; ?>
                </div>
        </div>

    </div>