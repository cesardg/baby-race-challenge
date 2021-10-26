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
        'Content-Type': 'applicationComment/json'
      }),
      body: JSON.stringify(data)

    });
    // antwoord van PHP. Kan een error bevatten of een lijst van comments 
    const returned = await response.json();
    console.log(returned);
    if (returned.text) {
      console.log(returned.text);
      document.querySelector('.error').textContent = returned.text
    } else {
      document.querySelector('.error').textContent = '';

      //comments opbouwen
      showComments(returned);


      // veld leegmaken 
      document.querySelector('.input__form__add').value = ``;

      // aantal comments aanpassen in view
      amountComments = returned.length;
      document.querySelector('.comment__amount').textContent = amountComments;

      // indien de eerste comment de tekst: er zijn nog geen comments leegmaken
      const $errorNoComments = document.querySelector('.error__no__comments');
      if ($errorNoComments) {
        $errorNoComments.textContent = ``;
      }
    }

  };

  // comments opbouwen
  const showComments = comments => {
    const $parent = document.querySelector('.comment__list');
    $parent.innerHTML = ``;
    comments.forEach(comment => {
      const $li = document.createElement('li');
      $li.classList.add('comment')
      $li.innerHTML = `     <span class="comment__date"> ${comment.parent}</span>
                                          ${comment.comment}`;
      $parent.appendChild($li);
    });
  };




  const init = () => {
    const $commentForm = document.querySelector('.comment__form');
    if ($commentForm) {
      $commentForm.addEventListener('submit', handleCommentSubmit);
    }
  }

  init();
}
