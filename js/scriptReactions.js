{
  // deze functie zet de name / value pairs van het formulier om naar JSON formaat

  const formdataToJson = $from => {


    const data = new FormData($from);
    const obj = {}

    data.forEach((value, key) => {
      console.log(key + ' : ' + value);
      obj[key] = value;
    });

    console.log(obj);
    return obj;
  }

  const handleReactionSubmit = e => {
    console.log(`formulier`)
    // het verzenden van het formulier naar de server tegenhouden
    const $form = e.currentTarget;
    e.preventDefault();
    // JavaScript laten overnemen om te communiceren met de server
    postReaction($form.getAttribute('action'), formdataToJson($form)); // object opmaken
  };

  const postReaction = async (url, data) => {
    // versturen naar de juiste route op de server en aangeven dat we een JSON response verwachten
    // de parameter body bevat de data
    const response = await fetch(url, {
      method: "POST",
      headers: new Headers({
        'Content-Type': 'applicationReaction/json'
      }),
      body: JSON.stringify(data)

    });
    // antwoord van PHP. Kan een error bevatten of een lijst reacties
    const returned = await response.json();
    if (returned.error) {
      console.log(returned.error);
      // session en error niet van toepassing hier
    } else {
      console.log(returned);

      // aantal reacties aanpassen in view
      let i;
      for (i = 0; i < returned.length; i++) {
        document.querySelector(`.amount__reaction__${returned[i].name}`).textContent = returned[i].likes
      }
    }
  };

  const init = () => {
    // toevoegen van een class has-js: aangeven dat JavaScript beschikbaar is
    document.documentElement.classList.add(`has-js`);
    const $reactionForm = document.querySelector('.reaction__form');
    if ($reactionForm) {
      $reactionForm.addEventListener('input', handleReactionSubmit);
    }
  }

  init();
}
