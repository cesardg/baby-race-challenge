<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/PostDAO.php';

class UsersController extends Controller
{

  private $userDAO;
  private $PostDAO;

  function __construct()
  {
    $this->userDAO = new UserDAO();
    $this->PostDAO = new PostDAO();
  }



  public function login()
  {
    $this->set('title', 'Join us');
    $this->set('currentPage', 'login');

    $errors = array();


    if (!empty($_POST)) {
      if (!empty($_POST['email'])) {
        if (!empty($_POST['password'])) {
          $existing = $this->userDAO->selectByEmail($_POST['email']);
          if (!empty($existing)) {
            if (password_verify($_POST['password'], $existing['password'])) {
              $_SESSION['user'] = $existing;
              $_SESSION['info'] = '<p class="sessions__bold">U bent succesvol ingelogd</p>';
              header('location:index.php?page=acount');
              exit();
            } else {
              $errors['email'] = 'ongekende email / paswoord';
              $errors['password'] = 'ongekende email / paswoord';
            }
          } else {
            $errors['email'] = 'ongekende email / paswoord';
            $errors['password'] = 'ongekende email / paswoord';
          }
        } else {
          $errors['password'] = 'Geef aub uw paswoord op';
        }
      } else {

        $errors['email'] = 'Geef aub uw email op';
      }
    }

    $this->set('errors', $errors);
  }

  public function logout()
  {
    if (!empty($_SESSION['user'])) {
      unset($_SESSION['user']);
    }
    $_SESSION['info'] = '<p class="sessions__bold">U bent uitgelogd, tot de volgende keer!</p>';
    header('location:index.php?page=login');
    exit();
  }

  public function acount()
  {
    $this->set('title', 'Uw acount gegevens');
    $this->set('currentPage', 'acount');

    //selecteerd posts per gebruiker
    $userPosts = false;

    $userPosts = $this->PostDAO->selectPostsByUser($_SESSION['user']['id']);
    $this->set('userPosts', $userPosts);
  }

  public function register()
  {

    $this->set('title', 'registeren');
    $this->set('currentPage', 'register');

    if (!empty($_POST)) {
      $errors = array();
      if (empty($_POST['email'])) {
        $errors['email'] = 'Geef aub uw email op';
      } else {
        $existing = $this->userDAO->selectByEmail($_POST['email']);
        if (!empty($existing)) {
          $errors['email'] = 'Dit email adres bestaat al';
        }
      }
      if (empty($_POST['password'])) {
        $errors['password'] = 'Geef aub een paswoord op';
      }
      if (empty($_POST['voornaam'])) {
        $errors['voornaam'] = 'Geef aub uw voornaam op';
      }

      if (empty($_POST['naam'])) {
        $errors['naam'] = 'Geef aub u naam op';
      }

      if (empty($_POST['gebruikersnaam'])) {
        $errors['gebruikersnaam'] = 'Geef aub uw gebruikersnaam op';
      }


      if ($_POST['confirm_password'] != $_POST['password']) {
        $errors['confirm_password'] = 'Passwords do not match';
      }

      if (empty($_FILES['image']['name'])) {
        $relativeFileName = "anoniem.png";
      } else {
        if (empty($errors)) {
          // controleer of het een afbeelding is van het type jpg, png of gif
          $whitelist_type = array('image/jpeg', 'image/png', 'image/gif');
          if (!in_array($_FILES['image']['type'], $whitelist_type)) {
            $errors['image'] = 'please select a jpg, png or gif';
          }
        }

        if (empty($errors)) {
          // controleer de afmetingen van het bestand: pas deze gerust aan voor je eigen project

          $size = getimagesize($_FILES['image']['tmp_name']);
          if ($size[0] < 250 || $size[1] < 250) {
            $errors['image'] = 'De foto moet 250 bij 250 pixels groot zijn';
          }
        }
        $this->set('errors', $errors);

        if (empty($errors)) {
          // map met een random naam aanmaken voor de upload: redelijk zeker dat er geen conflict is met andere uploads
          $projectFolder = realpath(__DIR__);
          $targetFolder = $projectFolder . '/../assets/uploads';
          $targetFolder = tempnam($targetFolder, '');
          unlink($targetFolder);
          mkdir($targetFolder, 0777, true);
          $targetFileName = $targetFolder . '/' . $_FILES['image']['name'];

          // via de functie _resizeAndCrop() de afbeelding croppen en resizen tot de gevraagde afmeting
          $this->_resizeAndCrop($_FILES['image']['tmp_name'], $targetFileName, 250, 250);
          $relativeFileName = substr($targetFileName, 5 + strlen($projectFolder));
        }
      }

      if (empty($errors)) {
        $inserteduser = $this->userDAO->insert(array(
          'email' => $_POST['email'],
          'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
          'voornaam' => $_POST['voornaam'],
          'naam' => $_POST['naam'],
          'gebruikersnaam' => $_POST['gebruikersnaam'],
          'path' => $relativeFileName

        ));
        if (!empty($inserteduser)) {
          $_SESSION['user'] = $inserteduser;
          $_SESSION['info'] = '<p class="sessions__bold">U bent succesvol geregistreerd</p>';
          header('location:index.php?page=acount');
          exit();
        }
      }
      $_SESSION['error'] = 'Registration Failed!';
      $this->set('errors', $errors);
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
}
