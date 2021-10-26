{

  // deze functie zet de name / value pairs van het formulier om naar JSON formaat
  const formdataToJson = $from => {

    // bij een comment wordt ook een datum meegeven, deze functie haalt deze op

    const data = new FormData($from);
    const obj = {}

    data.forEach((value, key) => {
      console.log(key + ' : ' + value);
      obj[key] = value;

    });

    console.log(obj);
    return obj;
  }



  const handleCommentSubmit = e => {
    console.log(`test`);
    // het verzenden van het formulier naar de server tegenhouden
    const $form = e.currentTarget;
    e.preventDefault();
    // JavaScript laten overnemen om te communiceren met de server
    postComment($form.getAttribute('action'), formdataToJson($form)); // object opmaken
  };

  const postComment = async (url, data) => {
    // versturen naar de juiste route op de server en aangeven dat we een JSON response verwachten
    // de parameter body bevat de data 
    const response = await fetch(url, {
      method: "POST",
      headers: new Headers({
        'Content-Type': 'applicationForum/json'
      }),
      body: JSON.stringify(data)

    });
    // antwoord van PHP. Kan een error bevatten of een lijst van comments 
    const returned = await response.json();
    console.log(returned);
    if (returned.awnser) {
      console.log(returned.awnser);
      document.querySelector(`.form-control-feedback--question--${returned.awnserid}`).textContent = returned.awnser;
    } else {
      //document.querySelector('.error').textContent = '';

      //comments opbouwen
      showComments(returned);

    
      

    }

  };

  // comments opbouwen
  const showComments = comments => {
    console.log(comments);

    // veld leegmaken 
    document.querySelector(`.input__form__add--${comments[0].question_id}`).value = ``;

    // aantal antwoorden aanpassen in view
    amountComments = comments.length;
    document.querySelector(`.amount__awnsers--${comments[0].question_id}`).textContent = amountComments;

    const $postContainer = document.querySelector(`.awnsers__container--overflow--${comments[0].question_id}`);
    console.log(comments[0].question_id);
    let intro = ``;
    $postContainer.innerHTML = comments.map(post =>
      intro = `
              <div class="post__awnser post__question--flex ">
                                    <img class="post__question--img" src="assets/uploads/${post.path}" alt="profielfoto" width="90" height="90">
                                    <div>
                                        <p class="post__question--name">${post.gebruikersnaam}</p>
                                        <p class="post__question--question post__question--question--awnser ">${post.awnser}</p>
                                    </div>
                                </div>`).join(``);
  };




  const init = () => {
    const awnserForms = document.querySelectorAll('.awnser__form');
    if (awnserForms) {
      awnserForms.forEach($input => {
        $input.addEventListener('submit', handleCommentSubmit);
      });

    }
  }

  init();
}

