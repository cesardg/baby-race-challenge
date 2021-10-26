{
  const handleSubmitForm = e => {
    e.preventDefault();
    submitWithJS();
  };

  const handleInputField = e => {
    submitWithJS();
  }

  const submitWithJS = async () => {
    // data van het formulier ophalen
    // check de console voor de resultaten
    const $form = document.querySelector('.filter__sort--form');
    const data = new FormData($form);
    const entries = [...data.entries()];
    console.log('entries:', entries);
    const qs = new URLSearchParams(entries).toString();
    console.log('querystring', qs);
    const url = `${$form.getAttribute('action')}?${qs}`;
    console.log('url', url);

    // request naar de server
    const response = await fetch(url, {
      headers: new Headers({
        Accept: 'applicationFilter/json'
      })
    });
    // opslaan van de films die de server heeft teruggeeven
    const posts = await response.json();
    console.log(posts);

    //niet alleen de volgorde veranderd bij een imput, maar  ook de view, dit wordt hier gedaan
    console.log(entries[1][1]);
    if (entries[1][1] == "klassiek") {
      updateViewKlassiek(posts);
      // fontsize kleiner maken als naam groter is dan 8 letters
      const postNames = Array.from(document.querySelectorAll('.post__name'));

      postNames.map(post => {
        if (post.textContent.length > 8) {
          console.log(post)
          post.classList.add('big__name--smaller');
        }
      })

    } else {
      console.log("racetrack")
      updateViewRacetrack(posts);

      // zorgt voor juiste horizontale posities bij galerij racebaan view (zelfde code van in animations.js, maar het moet hier ook staan, anders werkt het niet)
      const postTimes = document.querySelectorAll(`.racetrack__time`);
      const postIds = document.querySelectorAll(`.racetrack__id`);
      if (postTimes) {
        adjustPosition(postTimes, postIds);
      }
    }




    // aanpassen van de url en beschikbaar maken van de back button
    window.history.pushState(
      {},
      '',
      `${window.location.href.split('?')[0]}?${qs}`
    );
  }

  const updateViewKlassiek = posts => {

    const $postcontainer = document.querySelector('.post__gallery__container');
    // elementen aanmaken via JavaScript ipv via PHP
    $postcontainer.innerHTML = posts.map(post => {
      return `
         <a class="post__gallery--link" href="index.php?page=detail&id=${post.id}">
                    <div class="post__card--hof post__card--gallery">
                        <div class="name__time__wrapper">
                            <p class="post__name">${post.name}</p>
                            <div class="icoon__time__wrapper">
                                <img src="assets/img/chronoicoonsmall.png" alt="icoon chronometer" width="27" height="30">
                                <p class="post__time">${post.time}</p>
                            </div>
                        </div>
                        <p class="post__parents">Baby van ${post.user[0].gebruikersnaam} en ${post.parent2}</p>
                        <div class="filter__wrapper">
                            <img class="post__card--hof--img" src="assets/uploads/${post.path}" alt="post kruipende baby <?php echo $post['name']; ?>" width="323" height="323">
                            <div class="post__filter">
                                <p>hier komt filter</p>
                            </div>
                            <img class="post__finish__filter" src="assets/img/finishpostfilter.svg" alt="finish filter" width="201" height="65">

                        </div>

                    </div>
                </a>`;
    }).join(``);
  };

  const updateViewRacetrack = postsracetrack => {
    //console.log(postsracetrack);
    const $postcontainer = document.querySelector('.post__gallery__container');
    // elementen aanmaken via JavaScript ipv via PHP
    $postcontainer.innerHTML = postsracetrack.map((postracetrack, index) => {
      //console.log(postracetrack);
      return `
        <div class="racetrack__item">
                    <div class="racetrack__item--info">
                        <p>${index + 1}</p>
                        <div>
                            <div class="racetrack__item--wrapper racetrack__item--wrapper--${postracetrack.id}">
                                <p class="no__display racetrack__time">${postracetrack.time}</p>
                                <p class="no__display racetrack__id">${postracetrack.id}</p>
                                <p class="racetrack__name"> <a href="index.php?page=detail&id=${postracetrack.id}"> ${postracetrack.name} </a>
                                </p>
                                <a href="index.php?page=detail&id=${postracetrack.id}"> <img class="racetrack__img" src="assets/uploads/${postracetrack.path}" alt="foto baby" width="150" height="150"> </a>
                            </div>
                        </div>
                    </div>
                    <img class="finishline__racetrack" src="assets/img/finishlineracetrack.svg" alt="finishline" height="250">
                </div>`;
    }).join(``);
  };

  const adjustPosition = (postTimes, postIds) => {
    const times = [];
    const ids = [];

    const arrayTimes = Array.from(postTimes);
    const arrayIds = Array.from(postIds);

    // haalt inhoud op van de id's
    arrayIds.forEach(element => ids.push(parseInt(element.textContent)));
    //console.log(ids);

    // haalt inhoud op van de tijd 
    arrayTimes.forEach(element => times.push((element.textContent)));

    const usefullTimes = [];
    // zet deze om naar gebruiksvriendelijke cijfers (komma getal niet nodig)
    times.forEach(element => usefullTimes.push(parseInt(element.substring(0, 2))));
    //console.log(usefullTimes);

    const highesTime = Math.max.apply(null, usefullTimes);

    const containerWitdh = 82;

    const combine = []

    // uitleg bij de volgende for each: 
    // hier maak ik een array in een array, het eeste element is de id van een post, 
    //het 2de element is de plaats (in lengte, rem) van dat element in de racebaan. Deze waarde is altijd relatief van de min en max tijd kan veranderen
    ids.forEach(element => combine.push([element, ((usefullTimes[ids.indexOf(element)]) / highesTime) * containerWitdh]));
    //console.log(combine);


    combine.forEach(function (element) {
      //console.log(element);
      document.querySelector(`.racetrack__item--wrapper--${element[0]}`).style.transform = `translate(-${element[1]}rem, 0rem)`
    });
  }





  const init = () => {
    const filterfield = document.querySelectorAll('.filter__field');
    if (filterfield) {
      filterfield.forEach($field => $field.addEventListener('input', handleInputField));

    }

    const $filtersort = document.querySelector('.filter__sort--form');
    if ($filtersort) {
      $filtersort.addEventListener('submit', handleSubmitForm);
    }

  }

  init();
}
