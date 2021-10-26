{

    const handelScrollDocument = () => {


        //zorgt ervoor dat de baby van links naar rechts kruipt als je scrolt
        const usefullScrollHeightBabyHorizontal = ((document.documentElement.scrollTop) - 2000) / 18;
        const $horizontalBaby = document.querySelector(`.baby5__img`);
        if ($horizontalBaby && usefullScrollHeightBabyHorizontal < 85) {
            $horizontalBaby.style.transform = `translate(${usefullScrollHeightBabyHorizontal}rem, 13rem)`
        }

        //zorgt ervoor dat baby 1 naar onder kruipt
        const usefullScrollHeightBabby1 = (((document.documentElement.scrollTop) - 200) / -15) + 60;
        // console.log(usefullScrollHeightBabby1);
        const $baby1 = document.querySelector(`.crawlingbaby1`);
        if ($baby1) {

            $baby1.style.transform = `rotate(180deg) translate(2rem, ${usefullScrollHeightBabby1}rem)`
        }

        //zorgt ervoor dat baby 2 naar onder kruipt
        const usefullScrollHeightBabby2 = (((document.documentElement.scrollTop) - 200) / -10) + 100;
        //   console.log(usefullScrollHeightBabby2);
        const $baby2 = document.querySelector(`.crawlingbaby2`);
        if ($baby2) {

            $baby2.style.transform = `rotate(180deg) scale(0.9) translate(-12rem, ${usefullScrollHeightBabby2}rem)`
        }

        //zorgt ervoor dat baby 3 naar onder kruipt
        const usefullScrollHeightBabby3 = (((document.documentElement.scrollTop) - 180) / 85) - 10;
        // console.log(usefullScrollHeightBabby3);
        const $baby3 = document.querySelector(`.crawlingbaby3`);
        if ($baby3) {

            $baby3.style.transform = `rotate(180deg) scale(0.9) translate(0rem, -${usefullScrollHeightBabby3}rem)`
        }

        //zorgt ervoor dat de baby vliegt
        const usefullScrollHeightBabby4 = (((document.documentElement.scrollTop) - 3330) / 50);
        const usefullScrollWitdh = ((document.documentElement.scrollTop) - 3350) / 17;
        // console.log(usefullScrollHeightBabby4);
        const $baby4 = document.querySelector(`.rgc__img--right`);
        if ($baby4) {
            $baby4.style.transform = `translate(-${usefullScrollWitdh}rem, ${usefullScrollHeightBabby4}rem)`
        }
    }


    const adjustPosition = (postTimes, postIds) => {
        const times = [];
        const ids = [];

        const arrayTimes = Array.from(postTimes);
        const arrayIds = Array.from(postIds);

        // haalt inhoud op van de id's
        arrayIds.forEach(element => ids.push(parseInt(element.textContent)));
       // console.log(ids);

        // haalt inhoud op van de tijd 
        arrayTimes.forEach(element => times.push((element.textContent)));

        const usefullTimes = [];
        // zet deze om naar gebruiksvriendelijke cijfers (komma getal niet nodig)
        times.forEach(element => usefullTimes.push(parseInt(element.substring(0, 2))));
       // console.log(usefullTimes);

        const highesTime = Math.max.apply(null, usefullTimes);

        const containerWitdh = 82;

        const combine = []

        // uitleg bij de volgende for each: 
        // hier maak ik een array in een array, het eeste element is de id van een post, 
        //het 2de element is de plaats (in lengte, rem) van dat element in de racebaan. Deze waarde is altijd relatief van de min en max tijd kan veranderen
        ids.forEach(element => combine.push([element, ((usefullTimes[ids.indexOf(element)]) / highesTime) * containerWitdh]));
       // console.log(combine);


        combine.forEach(function (element) {
           // console.log(element);
            document.querySelector(`.racetrack__item--wrapper--${element[0]}`).style.transform = `translate(-${element[1]}rem, 0rem)`
        });
    }


    const handleClickForm = (e) => {
        const $babyFormImg = document.querySelector(`.form__add__image`);
        const $field = e.target.name;
        //const $button = e.target.value;
        // console.log($button);
        let crawlHeight = 0;
        if ($field == "image") {
            crawlHeight = 9;
        } else if ($field == "name-baby") {
            crawlHeight = 23;
        } else if ($field == "name-partner") {
            crawlHeight = 35;
        } else if ($field == "time") {
            crawlHeight = 45;
        }
        $babyFormImg.style.transform = `scaleY(-1) translate(0rem, -${crawlHeight}rem)`
       // console.log($field)

    }


    const handleHoverButton = (e) => {
        const $button = e.target.value;

        const $babyFormImg = document.querySelector(`.form__add__image`);
        if ($button == "Plaats bericht" && document.querySelector(`.input__form__add--time`).value != "") {
            $babyFormImg.style.transform = `scaleY(-1) translate(0rem, -50rem)`
        }
    }

    const init = () => {

        // zorgt voor de animaties tijdens het scrollen
        document.addEventListener(`scroll`, handelScrollDocument);

        // zorgt voor juiste horizontale posities bij galerij racebaan view
        const postTimes = document.querySelectorAll(`.racetrack__time`);
        const postIds = document.querySelectorAll(`.racetrack__id`);
        if (postTimes) {
            adjustPosition(postTimes, postIds);
        }

        // zorgt voor animaties bij het forum om een foto toe te voegen
        const $formAdd = document.querySelector(`.form__add`);
        if ($formAdd) {
            $formAdd.addEventListener(`click`, handleClickForm);
            $formAdd.addEventListener(`mouseover`, handleHoverButton);
        }
    };
    init();
}