 <h1 class="no__display">Detail post</h1>
 <div class="container">
       <p class="overview__link"><a href="index.php?page=galerij">Terug naar overzicht</a></p>
       <div class="detail__post">
             <img src="assets/uploads/<?php echo $post['path']; ?>" height="500" width="500" alt="<?php echo $post['name']; ?> kruipt ">
             <div class="detail__container">
                   <div class="name__time__wrapper--detail">
                         <p class="post__title post__title--detail <?php if (strlen($post['name']) > 8) echo 'post__title--detail--smaller'; ?>">
                               <?php echo $post['name']; ?>
                         </p>
                         <div class="time__icon__wrapper--detail">
                               <img src="assets/img/chronoicoonbig.png" alt="icoon chronometer" height="40">
                               <p><?php echo $post['time']; ?></p>
                         </div>
                   </div>
                   <p class="post__discription post__discription--detail">
                         Kindje van <?php echo $post['user'][0]['gebruikersnaam']; ?> en <?php echo $post['parent2']; ?>
                   </p>
                   <div class="comments">
                         <p class="comments__title">Comments (<span class="comment__amount"><?php echo count($comments); ?></span>)</p>
                         <?php
                              if (empty($comments)) {
                                    echo '<p class="error__no__comments">Deze posts heeft nog geen comments.</p>';
                              }
                              ?>
                         <div class="comment__container">
                               <ul class="comment__list">
                                     <?php foreach ($comments as $comment) : ?>

                                           <li class="comment">
                                                 <span class="comment__date"> <?php echo $comment['parent']; ?></span>
                                                 <?php echo $comment['comment']; ?>
                                           </li>

                                     <?php endforeach; ?>
                               </ul>
                         </div>


                   </div>
                   <?php if (empty($_SESSION['user'])) : ?>
                         <div class="no__user__message">
                               <p>Log u <a class="shopping__cart__link" href="index.php?page=login">hier</a> in om een comment te posten, u kan wel een reactie toevoegen hieronder</p>
                         </div>
                   <?php else : ?>
                         <form method="post" action="index.php?page=detail&id=<?php echo $post['id']; ?>" class="comment__form">
                               <input type="hidden" name="action" value="insertComment">
                               <input type="hidden" name="parent" value="<?php echo $_SESSION['user']['gebruikersnaam'] ?>">
                               <input type="hidden" name="image_id" value="<?php echo $post['id'] ?>">
                               <label>
                                     <!-- hier geen required nodig want het anwtwoord van de server bevat een error als het leeg is door progressive enhancement, anders zou dit ook vechten met validatejs-->
                                     <textarea name="text" cols="19" rows="4" class="comment__field input__form__add"></textarea>
                                     <span class="error form-control-feedback form-control-feedback--comment"><?php if (!empty($errors['text'])) {
                                                                                                                        echo $errors['text'];
                                                                                                                  } ?></span>
                               </label>
                               <input class="comment__button" type="submit" name="button" value="Add Comment">
                         </form>
                   <?php endif; ?>
                   <form method="post" action="index.php?page=detail&id=<?php echo $post['id']; ?>" class="reaction__form">
                         <input type="hidden" name="action" value="insertReaction">
                         <input type="hidden" name="image_id" value="<?php echo $post['id'] ?>">
                         <div>
                               <div class="form-general__field form-general__field__reactions">

                                     <?php foreach ($reactions as $reaction) : ?>

                                           <div class="reaction__container">
                                                 <label title="<?php echo $reaction['name'] ?>!" class="checkbox-radio__field"><input class="hidden__button" type="radio" name="reactie" <?php if (isset($_SESSION['likedReactions'][$post['id']]) && $_SESSION['likedReactions'][$post['id']]['reactie'] == $reaction['id']) echo 'checked'; ?> value="<?php echo $reaction['id'] ?>"><img src="assets/buttons/<?php echo $reaction['icon'] ?>" alt="icoon <?php echo $reaction['name'] ?>" height="80" width="80"></label>
                                                 <span class="amount__reactions amount__reaction__<?php echo $reaction['name'] ?>"><?php echo $reaction['likes'] ?></span>
                                           </div>

                                     <?php endforeach; ?>



                               </div>
                               <div class="reaction__button__container">

                                     <input class="comment__button reaction__button" type="submit" name="button" value="Add Reaction">

                                     <span class="error error__reaction form-control-feedback"><?php if (!empty($errorsReactions['reactie'])) {
                                                                                                      echo $errorsReactions['reactie'];
                                                                                                } ?></span>
                               </div>

                         </div>
                   </form>
             </div>
       </div>


       <h2 class="content__title content__title__detail">Deze baby's deden het net sneller:</h2>
       <?php if (empty($fasterposts)) echo '<p class="fastest--baby__message">Dit is de snelste baby!</p>' ?>
       <div class="post__gallery__container post__gallery__container--detail">
             <?php foreach ($fasterposts as $post) : ?>
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
                                     <img class="post__card--hof--img" src=" assets/uploads/<?php echo $post['path']; ?>" alt="post kruipende baby <?php echo $post['name']; ?>" width="323" height="323">
                                     <div class="post__filter">
                                           <p>hier komt filter</p>
                                     </div>
                                     <img class="post__finish__filter" src="assets/img/finishpostfilter.svg" alt="finish filter" width="201" height="65">

                               </div>

                         </div>
                   </a>
             <?php endforeach; ?>
       </div>
 </div>