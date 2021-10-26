{


  const handleInputSearch = () => {
    getPosts();
  }

  const getPosts = async () => {

    // url instellen voor het action attribute van de form
    const $form = document.querySelector('.search__form');
    const name = document.querySelector('.search__field').value;
    const url = `${$form.getAttribute('action')}&search-title=${name}`;

    console.log(name);


    // deze if statement zorgt ervoor dat de eerste letter van de zoekactie niet blijft staan als je alles wegdoet. Normaal blijft de eerste letter wel staan omdat er geen input event meer is
    if (name.length != 0) {
      console.log('nu is er iets ingetypt');

      // fetch om de JSON data op te halen
      const response = await fetch(url, {
        headers: new Headers({
          Accept: 'application/json'
        })
      });
      // resultaat opslaan in variabele posts
      const searchedPosts = await response.json();
      // titel aan passen

      console.log(searchedPosts);
      // posts aanmaken
      updateList(searchedPosts);

      //toont error indien problemen of geen posts gevonden
      showError(searchedPosts);

      // de url in de titelbalk aanpassen
      // en zorgen dat de back-button in de browser werkt
      window.history.pushState(
        {},
        '',
        `${window.location.href.split('?')[0]}?page=tipsQuestions&search-title=${name}`
      );

    } else {
      console.log('nu staat er niets getypt');

      // terug alle posts ophalen want er is niet ingetypt
      const response = await fetch(url, {
        headers: new Headers({
          Accept: 'applicationAllQuestions/json'
        })
      });
      // resultaat opslaan in variabele posts
      const allRecentPosts = await response.json();
      updateList(allRecentPosts);

      // foutmelding terug weg doen
      document.querySelector(`.not__found__message`).innerHTML = "";

      window.history.pushState(
        {},
        '',
        `${window.location.href.split('?')[0]}?page=tipsQuestions&search-title=`
      );
    }
  }


  const updateList = posts => {
    console.log(posts);
    const $postContainer = document.querySelector('.posted__question__container');
    let intro = ``;
    $postContainer.innerHTML = posts.map(post =>
      intro = `
        <div class="post__question__wrapper">
                    <div class="post__question">
                        <p>Onderwerp: <span>${post.topic}</span></p>
                        <div class="post__question--flex">
                            <img class="post__question--img" src="assets/uploads/${post.user[0].path}" alt="pf 2 experts" width="100" height="100">
                            <div>
                                <p class="post__question--name">${post.user[0].gebruikersnaam}</p>
                                <p class="post__question--question">${post.question}</p>
                            </div>
                        </div>
                    </div>
                    <div class="post__question post__awnsers">
                        <p>
                            Antwoorden (${post.awnsers.length}):
                        </p>

                        <div class="awnsers__container--overflow">
                        <a class="view__awnsers__link" href="index.php?page=tipsQuestions#awnser${post.id}">bekijk antwoorden</a>
                        </div>
                    </div>
                </div>`).join(``);
  }

  const showError = posts => {
    const $errorMessageNotFound = document.querySelector(`.not__found__message`);
    console.log($errorMessageNotFound);
    $errorMessageNotFound.innerHTML = '';
    if (posts.length == 0) {
      console.log(`er zijn geen post met deze zoekterm`);
      $errorMessageNotFound.innerHTML = '<p>Oeps, er zijn geen vragen over dit onderwerp, je kan zelf wel een vraag stellen</p>';
    }
  }

  const handleClickButton = () => {
    window.location.hash = 'questionPart'
  }

  const init = () => {
    // toevoegen van een class has-js: aangeven dat JavaScript beschikbaar is
    document.documentElement.classList.add(`has-js`);

    const $searchField = document.querySelector('.search__field');
    if ($searchField) {
      $searchField.addEventListener('input', handleInputSearch);
    }

    //    document.querySelector('.search__button__lay--out').addEventListener('click', handleClickButton);

  }

  init();
}




