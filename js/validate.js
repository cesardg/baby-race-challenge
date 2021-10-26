{
  const handleSubmitForm = e => {
   // console.log('test');
    const $form = e.currentTarget;
    if (!$form.checkValidity()) {
      e.preventDefault();


      const inputs = document.querySelectorAll(`.input__form__add`);
      inputs.forEach($input => showValidationInfo($input));

    }
  }

  const handleInputField = e => {
   // console.log("tesrtrtt");
    const $input = e.currentTarget;
    const $error = $input.parentElement.querySelector(`.form-control-feedback`);
    if ($input.checkValidity()) {
      $error.innerHTML = ``;
    }
  };

  const showTypeMismatch = type => {
    switch (type) {
      case `email`:
        return `e-mailadres`;
      case `url`:
        return `website url`;
      case `tel`:
        return `telefoonnummer`;
    }
  }

  const showValidationInfo = $input => {
   // console.log(`test6`);
    // selecteren van het error veld bij elk element
    const $error = $input.parentElement.querySelector(`.form-control-feedback`);
    //console.log($error);

    // controle of het veld ingevuld is
    if ($input.validity.valueMissing) {
      $error.innerHTML = `<p>Gelieve dit veld in te vullen</p>`;
    }
    // controle of input matcht met type attribute
    if ($input.validity.typeMismatch) {
      $error.textContent = `Er wordt een ${showTypeMismatch($input.getAttribute(`type`))} verwacht`;
    }
    // controle of de maximale lengte niet overschreden is
    if ($input.validity.tooLong) {
      $error.textContent = `Input mag maximum ${$input.getAttribute(`maxlength`)} karakters bevatten`;
    }
    // controle of de minimale lengte wel gehaald werd
    if ($input.validity.tooShort) {
      $error.textContent = `Input moet minimum ${$input.getAttribute(`minlength`)} karakters bevatten`;
    }
    // controle of de input groter of gelijk is aan de kleinst mogelijke waarde
    if ($input.validity.rangeUnderflow) {
      $error.textContent = `De waarde moet groter of gelijk zijn aan ${$input.getAttribute(`min`)}`;
    }
    // controle of de input kleiner of gelijk is aan de grootst mogelijke waarde
    if ($input.validity.rangeOverflow) {
      $error.textContent = `De waarde moet kleiner of gelijk zijn aan ${$input.getAttribute(`max`)}`;
    }
  }

  const handleBlurInput = e => {
    showValidationInfo(e.currentTarget);
  };

  const init = () => {

    // add form
    const $formAdd = document.querySelector(`.form__add`);

    if ($formAdd) {
      $formAdd.noValidate = true;

      $formAdd.addEventListener(`submit`, handleSubmitForm);
    }

    //comment form
    const $formComment = document.querySelector(`.comment__form`);

    if ($formComment) {
      $formComment.noValidate = true;

      $formComment.addEventListener(`submit`, handleSubmitForm);
    }

    //login form
    const $formLogin = document.querySelector(`.login__form`);

    if ($formLogin) {
      $formLogin.noValidate = true;

      $formLogin.addEventListener(`submit`, handleSubmitForm);
    }

    //register form
    const $formRegister = document.querySelector(`.form-horizontal`);

    if ($formRegister) {
      $formRegister.noValidate = true;
      $formRegister.addEventListener(`submit`, handleSubmitForm);
    }

    //vragen form
    const $formQuestions = document.querySelector(`.question__form`);

    if ($formQuestions) {
      $formQuestions.noValidate = true;
      $formQuestions.addEventListener(`submit`, handleSubmitForm);
    }


    // wordt gedaan in forum.js

    //antwoorden form
    /*
    const formAwnser = document.querySelectorAll(`.awnser__form`);
    if (formAwnser) {
      formAwnser.forEach($form => {
        $form.noValidate = true;
        $form.addEventListener(`submit`, handleSubmitForm);
      });
    }
    */


    const $formAwnser = document.querySelector(`.awnser__form`);
    if ($formAwnser) {
      $formAwnser.noValidate = true;
      $formAwnser.addEventListener(`submit`, handleSubmitForm);
    }





    const inputs = document.querySelectorAll(`.input__form__add`);

    inputs.forEach($input => {
      $input.addEventListener(`blur`, handleBlurInput);
      $input.addEventListener(`input`, handleInputField);
    });



  };

  init();
}

