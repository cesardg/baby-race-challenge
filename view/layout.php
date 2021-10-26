<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/kwc7mgb.css">
    <link rel="shortcut icon" href="assets/img/browsericon.png">
    <title>The baby race challenge</title>
</head>

<body>

    <header class="header">
        <div class="header__wrapper">
            <div class="title__container">
                <a href="index.php" class="header__link<?php if ($currentPage == 'Home') echo ' no__display'; ?>"><img class="header__link--logo" src="assets/img/logo.png" alt="logo" width="200"></a>
            </div>
            <nav class="menu__wrapper">
                <ul class="menu">
                    <li class="menu__item <?php if ($currentPage == 'galerij') echo ' menu__item--active'; ?>"><a href="index.php?page=galerij">Gallery</a></li>
                    <li class="menu__item <?php if ($currentPage == 'tipsQuestions') echo ' menu__item--active'; ?>"><a href="index.php?page=tipsQuestions">Tips & questions</a></li>
                    <li class="menu__item <?php if ($currentPage == 'shop') echo ' menu__item--active'; ?>"><a href="index.php?page=shop">Tune shop</a></li>
                    <?php if (empty($_SESSION['user'])) : ?>
                        <li class="menu__item menu__item--cta <?php if ($currentPage == 'login') echo ' menu__item--active menu__item--active--cta'; ?>"><a href="index.php?page=login">Join us</a></li>
                    <?php else : ?>
                        <li class="menu__item<?php if ($currentPage == 'acount') echo ' menu__item--active'; ?>"><a href="index.php?page=acount">My account</a></li>
                        <li><a class="nav__pf__img" href="index.php?page=acount"><img class="nav__pf__img" src="assets/uploads/<?php echo $_SESSION['user']['path'] ?>" alt="profiel foto" width="50" height="50"></a></li>
                        <li class="menu__item menu__item--cta <?php if ($currentPage == 'add') echo ' menu__item--active menu__item--active--cta'; ?>"><a href="index.php?page=add">Add photo</a></li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </header>

    <main class="content">
        <?php if (!empty($_SESSION['info'])) : ?>
            <div class="session__info__lay--out">

                <?php echo $_SESSION['info']; ?>
            </div>
        <?php endif; ?>

        <?php echo $content; ?>
    </main>
    <footer class="footer <?php if ($currentPage == 'cart') echo 'no__display'; ?>">
        <div class="footer__wrapper">
            <div class="footer__contact">
                <p class="footer__contact__title">Contact informatie</p>
                <p class="footer__contact__info">+32 491 59 01 55</p>
                <p class="footer__contact__info"><a href="mailto:cesar.degreve@gmail.com">babyrace@challenge.com</a></p>
            </div>
            <p>
                &copy;2020 Baby race challenge <span class="footer__contact--name">- by Cesar De Greve</span>
            </p>
            <img src="assets/img/finishfooter.svg" alt="finsish footer" height="120" width="370">
        </div>
    </footer>

   
    <script src="js/scriptComments.js"></script>
    <script src="js/scriptReactions.js"></script>
    <script src="js/scriptSearch.js"></script>
    <script src="js/scriptFilter.js"></script>
    <script src="js/validate.js"></script>
    <script src="js/scriptForum.js"></script>
    <script src="js/animations.js"> </script>
</body>

</html>