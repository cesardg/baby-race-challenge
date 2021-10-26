<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/PostDAO.php';
require_once __DIR__ . '/../dao/CommentDAO.php';
require_once __DIR__ . '/../dao/ReactionsDAO.php';
require_once __DIR__ . '/../dao/ImagesReactionsDAO.php';
require_once __DIR__ . '/../dao/ForumDAO.php';
require_once __DIR__ . '/../dao/ShopDAO.php';

class PagesController extends Controller
{

  private $PostDAO;
  private $CommentDAO;
  private $ReactionsDAO;
  private $ImagesReactionsDAO;
  private $ForumDAO;
  private $ShopDAO;

  function __construct()
  {
    $this->PostDAO = new PostDAO();
    $this->CommentDAO = new CommentDAO();
    $this->ReactionsDAO = new ReactionsDAO();
    $this->ImagesReactionsDAO = new ImagesReactionsDAO();
    $this->ForumDAO = new ForumDAO();
    $this->ShopDAO = new ShopDAO();
  }

  public function index()
  {
    $this->set('title', 'Baby race challenge');
    $this->set('currentPage', 'Home');


    // in deze opdracht maak ik gebruik van sessions info te tonen
    if (empty($_SESSION['info'])) {
      $_SESSION['info'] = '';
    }

    // en om de liked reacties bij te houden
    if (empty($_SESSION['likedReactions'])) {
      $_SESSION['likedReactions'] = array();
    }

    $hofPosts = '';

    // haalt de 3 populairste posts op
    $hofPosts = $this->PostDAO->selectHallOfFamePosts();
    // koppelt usersname met posts
    foreach ($hofPosts as $index => $post) {
      $hofPosts[$index]['user'] = $this->PostDAO->selectUserByPost($post['user_id']);
    }
    // de posts worden gerangschikt op een podium dus ze moeten eerst een andere volgorde krijgen
    $hofPostsRanked = array($hofPosts[2], $hofPosts[0], $hofPosts[1]);

    $this->set('hofPosts', $hofPostsRanked);
  }


  public function galerij()
  {
    $this->set('title', 'The baby race gallery');
    $this->set('currentPage', 'galerij');

    $posts = '';

    $posts = $this->PostDAO->selectAllPostsRecent();


    // sorteert op speed
    if (!empty($_GET['sort'])) {
      if ($_GET['sort'] == 'snelheid') {
        $posts = $this->PostDAO->selectAllPostsSpeed();
      }
    }

    // koppelt usersname met posts
    foreach ($posts as $index => $post) {
      $posts[$index]['user'] = $this->PostDAO->selectUserByPost($post['user_id']);
    }
    $this->set('posts', $posts);

    // indien er een request via JavaScript kwam worden de resultaten als JSON terug gegeven
    if ($_SERVER['HTTP_ACCEPT'] == 'applicationFilter/json') {
      echo json_encode($posts);
      exit();
    }
  }




  public function add()
  {
    $this->set('title', 'Voeg een foto toe in 3 stappen');
    $this->set('currentPage', 'add');


    if (!isset($_SESSION['user'])) {
      $_SESSION['info'] = '  <p class="sessions__bold">U moet ingelogd zijn voor u een foto kan posten</p>';
      header('Location: index.php?page=login');
      exit();
    }


    // variabele om foutmelding bij te houden
    $error = '';

    // controleer of er iets in de $_POST zit
    if (!empty($_POST['action'])) {
      // controleer of het wel om het juiste formulier gaat
      if ($_POST['action'] == 'add-image') {
        // controleren of er een bestand werd geselecteerd
        if (empty($_FILES['image']) || !empty($_FILES['image']['error'])) {
          $error = 'Please select a file';
        }

        if (empty($error)) {
          // controleer of het een afbeelding is van het type jpg, png of gif
          $whitelist_type = array('image/jpeg', 'image/png', 'image/gif');
          if (!in_array($_FILES['image']['type'], $whitelist_type)) {
            $error = 'please select a jpg, png or gif';
          }
        }

        if (empty($error)) {
          // controleer de afmetingen van het bestand: pas deze gerust aan voor je eigen project
          // width: 400
          // height: 400
          $size = getimagesize($_FILES['image']['tmp_name']);
          if ($size[0] < 400 || $size[1] < 400) {
            $error = 'De foto moet 400 bij 400 pixels groot zijn';
          }
        }
        $this->set('error', $error);

        if (empty($error)) {
          // map met een random naam aanmaken voor de upload: redelijk zeker dat er geen conflict is met andere uploads
          $projectFolder = realpath(__DIR__);
          $targetFolder = $projectFolder . '/../assets/uploads';
          $targetFolder = tempnam($targetFolder, '');
          unlink($targetFolder);
          mkdir($targetFolder, 0777, true);
          $targetFileName = $targetFolder . '/' . $_FILES['image']['name'];

          // via de functie _resizeAndCrop() de afbeelding croppen en resizen tot de gevraagde afmeting
          $this->_resizeAndCrop($_FILES['image']['tmp_name'], $targetFileName, 500, 500);
          $relativeFileName = substr($targetFileName, 5 + strlen($projectFolder));

          $data = array(
            'path' => $relativeFileName,
            'name-baby' => $_POST['name-baby'],
            'user-id' => $_SESSION['user']['id'],
            'name-partner' => $_POST['name-partner'],
            'time' => $_POST['time']
          );

          // aanspreken van de DAO
          $insertTodoResult = $this->PostDAO->createPost($data);

          // $error indien er iets fout gegaan is
          if (!$insertTodoResult) {
            $errors = $this->PostDAO->validate($data);
            $this->set('errors', $errors);
          } else {
            header('Location: index.php?page=galerij');
            $_SESSION['info'] = '  <p class="sessions__bold"> Je foto werd succesvol geupload</p>
            <p class="session__normal">Ben je niet tevreden met de kruiptijd van je baby? Bekijk dan onze <a class="shopping__cart__link sessions__link" href="index.php?page=tipsQuestions">tips pagina</a> of ga even langs bij onze <a class="shopping__cart__link sessions__link" href="index.php?page=shop"> tuneshop</a>. </p>';
            exit();
          }
        }
      }
    }
  }

  private function _resizeAndCrop($src, $dst, $thumb_width, $thumb_height)
  {
    $type = exif_imagetype($src);
    $allowedTypes = array(
      1,  // [] gif
      2,  // [] jpg
      3  // [] png
    );

    if (!in_array($type, $allowedTypes)) {
      return false;
    }

    switch ($type) {
      case 1:
        $image = imagecreatefromgif($src);
        break;
      case 2:
        $image = imagecreatefromjpeg($src);
        break;
      case 3:
        $image = imagecreatefrompng($src);
        break;
      case 6:
        $image = imagecreatefrombmp($src);
        break;
    }

    $filename = $dst;

    $width = imagesx($image);
    $height = imagesy($image);

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ($original_aspect >= $thumb_aspect) {
      // If image is wider than thumbnail (in aspect ratio sense)
      $new_height = $thumb_height;
      $new_width = $width / ($height / $thumb_height);
    } else {
      // If the thumbnail is wider than the image
      $new_width = $thumb_width;
      $new_height = $height / ($width / $thumb_width);
    }

    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

    // Resize and crop
    imagecopyresampled(
      $thumb,
      $image,
      0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
      0 - ($new_height - $thumb_height) / 2, // Center the image vertically
      0,
      0,
      $new_width,
      $new_height,
      $width,
      $height
    );
    imagejpeg($thumb, $filename, 80);
    return true;
  }




  public function detail()
  {

    $this->set('title', 'detail post');
    $this->set('currentPage', 'detail');



    //id van de post ophalen
    $post = false;
    if (!empty($_GET['id'])) {
      $post = $this->PostDAO->selectPostById($_GET['id']);
    }
    // relocate naar gallerij indien de post niet bestaat
    if (empty($post)) {
      header('Location:index.php?page=galerij');
      exit();
    }
    $post['user'] = $this->PostDAO->selectUserByPost($post['user_id']);

    $this->set('post', $post);


    // comments wegscrijven naar database met js
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "applicationComment/json") {
      // data ophalen via php://input (is nu éénmaal zo voor formdata)
      $content = trim(file_get_contents("php://input"));
      $data = json_decode($content, true); // JSON omzetten naar assoc array

      // toevoegen van een quote in de database en geef een error terug in geval van fout
      $insertedComment = $this->CommentDAO->insert($data);
      if (!$insertedComment) {
        $errors = $this->CommentDAO->validate($data);
        $this->set('errors', $errors);
        echo json_encode($errors);
      } else {
        // geef alle quotes uit de database terug indien gelukt
        $comments = $this->CommentDAO->selectCommentsForPost($data['image_id']);
        echo json_encode($comments);
      }
      // stop met PHP uit te voeren, JavaScript mag overnemen
      exit();
    }


    //comments wegschrijven naar db
    if (!empty($_POST['action'])) {
      if ($_POST['action'] == 'insertComment') {
        $data = array(
          'image_id' => $post['id'],
          'text' => $_POST['text'],
          'parent' => $_SESSION['user']['gebruikersnaam']

        );
        $insertedComment = $this->CommentDAO->insert($data);
        if (!$insertedComment) {
          $errors = $this->CommentDAO->validate($data);
          $this->set('errors', $errors);
        } else {
          header('Location: index.php?page=detail&id=' . $_GET['id']);
          exit();
        }
      }
    }

    //comments ophalen uit db
    $comments = false;
    if (!empty($_GET['id'])) {
      $comments = $this->CommentDAO->selectCommentsForPost($_GET['id']);
    }
    $this->set('comments', $comments);


    // reacties wegschrijven naar de db met js
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "applicationReaction/json") {
      // data ophalen via php://input (is nu éénmaal zo voor formdata)
      $content = trim(file_get_contents("php://input"));
      $reactionsData = json_decode($content, true); // JSON omzetten naar assoc array

      //reactie toevoegen aan sessie, zo blijft hij aangevinkt na refresh
      $_SESSION['likedReactions'][$_GET['id']] = $reactionsData;

      // toevoegen van een quote in de database en geef een error terug in geval van fout
      $insertedReaction = $this->ImagesReactionsDAO->insertReactions($reactionsData);
      if (!$insertedReaction) {
        $errorsReactions = $this->ImagesReactionsDAO->validate($reactionsData);
        $this->set('errorsReactions', $errorsReactions);
        echo json_encode($errorsReactions);
      } else {
        // geef alle quotes uit de database terug indien gelukt
        // alle reacties ophalen 
        $reactions = $this->ReactionsDAO->selectAllReactions();

        //foreach reaction -> tel alle likes 
        foreach ($reactions as &$reaction) {
          $reaction['likes'] =  count($this->ImagesReactionsDAO->selectReactionsForPost($reactionsData['image_id'], $reaction['id']));
          $this->set('AmountReaction' . $reaction['id'], $reaction['likes']);
        }
        $this->set('reactions', $reactions);
        echo json_encode($reactions);
      }
      // stop met PHP uit te voeren, JavaScript mag overnemen
      exit();
    }


    //reacties wegscrijven naar db
    if (!empty($_POST['action'])) {
      if ($_POST['action'] == 'insertReaction') {
        if (isset($_POST['reactie'])) {

          $reactionsData = array(
            'image_id' => $post['id'],
            'reactie' => $_POST['reactie']
          );

          //reactie toevoegen aan sessie, zo blijft hij visueel aangevinkt na refresh
          $_SESSION['likedReactions'][$_GET['id']] = $reactionsData;

          $insertedReaction = $this->ImagesReactionsDAO->insertReactions($reactionsData);
          if (!$insertedReaction) {
            $errorsReactions = $this->ImagesReactionsDAO->validate($reactionsData);
            $this->set('errorsReactions', $errorsReactions);
          } else {
            header('Location: index.php?page=detail&id=' . $_GET['id']);
            exit();
          }
        } else {
          $errorsReactions['reactie'] = 'please select a reaction';
          $this->set('errorsReactions', $errorsReactions);
        }
      }
    }

    // alle reacties ophalen 
    $reactions = $this->ReactionsDAO->selectAllReactions();

    //foreach reaction -> telt alle likes 
    foreach ($reactions as &$reaction) {
      $reaction['likes'] =  count($this->ImagesReactionsDAO->selectReactionsForPost($_GET['id'], $reaction['id']));
      $this->set('AmountReaction' . $reaction['id'], $reaction['likes']);
    }
    $this->set('reactions', $reactions);



    $fasterposts = false;
    //posts ophalen die net sneller zijn
    $fasterposts = $this->PostDAO->selectFasterPosts($post['time']);
    // koppelt usersname met posts
    foreach ($fasterposts as $index => $post) {
      $fasterposts[$index]['user'] = $this->PostDAO->selectUserByPost($post['user_id']);
    }
    $this->set('fasterposts', $fasterposts);
  }


  public function shop()
  {
    $this->set('title', 'Tune your baby');
    $this->set('currentPage', 'shop');


    $shopitems = '';
    // haalt alle recente posts op
    $shopitems = $this->ShopDAO->selectAllShopItems();
    $this->set('shopitems', $shopitems);
  }

  public function tipsQuestions()
  {
    $this->set('title', 'Tips & questions');
    $this->set('currentPage', 'tipsQuestions');


    //vragen wegscrijven naar db
    if (!empty($_POST['action'])) {
      if ($_POST['action'] == 'ask-question') {
        $data = array(
          'user-id' => $_SESSION['user']['id'],
          'topic' => $_POST['topic'],
          'question' => $_POST['question']
        );
        $insertedQuestion = $this->ForumDAO->insert($data);
        if (!$insertedQuestion) {
          $errors = $this->ForumDAO->validate($data);

          $this->set('errors', $errors);
        } else {
          $_SESSION['info'] = '<p class="sessions__bold">Uw vraag werd succesvol geupload</p>';
          header('Location: index.php?page=tipsQuestions#questionPart');
          exit();
        }
      }
    }

    $questions = $this->ForumDAO->selectAllQuestions();

    // antwoorden wegscrijven naar database met js op index
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "applicationForum/json") {
      // data ophalen via php://input (is nu éénmaal zo voor formdata)
      $content = trim(file_get_contents("php://input"));
      $data = json_decode($content, true); // JSON omzetten naar assoc array

      // toevoegen van een quote in de database en geef een error terug in geval van fout
      $insertedQuestion = $this->ForumDAO->insertAwnser($data);
      if (!$insertedQuestion) {
        $errors = $this->ForumDAO->validateAwnser($data);
        $this->set('errors', $errors);
        echo json_encode($errors);
      } else {

        $awnsers = $this->ForumDAO->selectAwnsersByQuestion($data['question_id']);

        echo json_encode($awnsers);
      }
      // stop met PHP uit te voeren, JavaScript mag overnemen
      exit();
    }



    //antwoorden wegschrijven naar db
    if (!empty($_POST['action'])) {
      if ($_POST['action'] == 'post-awnser') {
        $data = array(
          'question_id' => $_POST['question_id'],
          'user-id' => $_SESSION['user']['id'],
          'awnser' => $_POST['awnser']
        );
        $insertedQuestion = $this->ForumDAO->insertAwnser($data);
        if (!$insertedQuestion) {
          $errors = $this->ForumDAO->validateAwnser($data);
          $this->set('errors', $errors);
        } else {
          header('Location: index.php?page=tipsQuestions#awnser' . $_POST['question_id']);
          exit();
        }
      }
    }

    $questions = '';
    // haalt alle recente vragen op
    $questions = $this->ForumDAO->selectAllQuestions();

    // koppelt antwoorden en user met vragen
    foreach ($questions as $index => $question) {
      // er wordt een veld quotes toegeveogd aan de array
      $questions[$index]['awnsers'] = $this->ForumDAO->selectAwnsersByQuestion($question['id']);
      $questions[$index]['user'] = $this->PostDAO->selectUserByPost($question['user_id']);
    }



    $this->set('questions', $questions);

    // stuurt alle posts door naar js. Dit doe ik omdat er anders complicaties optreden als het zoekveld leeg is
    if ($_SERVER['HTTP_ACCEPT'] == 'applicationAllQuestions/json') {
      echo json_encode($questions);
      
      exit();
    }




    // zoekt vragen
    if (!empty($_GET['search-title'])) {
      $questions = $this->ForumDAO->selectPostBySearch($_GET['search-title']);
      // als de request uit JavaScript kwam worden de acteurs teruggegeven in JSON formaat
      if ($_SERVER['HTTP_ACCEPT'] == 'application/json') {
        // koppelt antwoorden met vragen
        foreach ($questions as $index => $question) {
          // er wordt een veld quotes toegeveogd aan de array. Dit veld is opnieuw een array die meerdere quotes kan bevatten
          $questions[$index]['awnsers'] = $this->ForumDAO->selectAwnsersByQuestion($question['id']);
          $questions[$index]['user'] = $this->PostDAO->selectUserByPost($question['user_id']);
        }
        echo json_encode($questions);
        exit();
      }
      // koppelt antwoorden met vragen
      foreach ($questions as $index => $question) {
        // er wordt een veld quotes toegeveogd aan de array. Dit veld is opnieuw een array die meerdere quotes kan bevatten
        $questions[$index]['awnsers'] = $this->ForumDAO->selectAwnsersByQuestion($question['id']);
        $questions[$index]['user'] = $this->PostDAO->selectUserByPost($question['user_id']);
      }

      $this->set('questions', $questions);
    }
  }
}
