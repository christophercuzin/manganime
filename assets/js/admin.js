import * as API_ENV from "../../config/packages/js.yaml";

if (document.getElementById('card_container')) {
   const cardContainer = document.getElementById('card_container');
   const pageNumberButtons = document.querySelectorAll('.number_of_page_container [id]');
   const apiEnv = API_ENV;
   
    
   // create connection to the api
    const options = {
        method: 'GET',
        headers: {
            apiEnv,
        }
    };
    // fetch the first page of manga
    fetch('https://api.jikan.moe/v4/manga?page=1')
    .then(response => response.json())
    .then(response => [createInput(response), displayMangaDetails(response)])
    
    // function use to fetch another page whith paging
    let i = 1;
    for (const pageNumberButton of pageNumberButtons) {
        pageNumberButton.addEventListener('click', (event) => {
            let target = event.target;
            if (target === pageNumberButton) {
                fetch('https://api.jikan.moe/v4/manga?page=' + pageNumberButton.value )
                .then(response => response.json())
                .then(response => [createInput(response), displayMangaDetails(response)])
            }
        })
    }
    // function use to fetch manga by name with search bar
    if (document.getElementById('search')) {
        const search = document.getElementById('search');
        const searchButton = document.getElementById('searchButton');
        searchButton.addEventListener('click', () => {
            const title = search.value;
            const options = {
                method: 'GET',
                headers: {
                    apiEnv,
                }
            };
            fetch('https://api.jikan.moe/v4/manga?type=manga&letter=' + title)
            .then(response => response.json())
            .then(response => [createInput(response), displayMangaDetails(response)])
        })
    }

    // function use to display all manga was fetch
    function displayMangaDetails (response) {
        let datas = response['data'];

        // remove old elments displayed to display new element
        if ( document.getElementsByClassName('card')) {
            const cards = document.getElementsByClassName('card');
            for (let i = 0; i < cards.length;) {
                const element = cards[i];
                element.remove();
            }
        }
        // use loop on the data fetch to display only the data i need
        for (let i = 0; i < datas.length; i++) {
            const data = datas[i]

            // create element to display all the data 
            const card = document.createElement('div')
            card.setAttribute('class', 'card');
            card.classList.add('col-sm-12');

            const img = document.createElement('img');
            img.setAttribute('class', 'card-img-top');
            img.setAttribute('alt', 'image du manga' + data['title']);
            img.setAttribute('src', data['images']['webp']['image_url'])

            const title = document.createElement('h6');
            title.setAttribute('class', 'card-title');
            title.innerHTML = data['title']
            
            cardContainer.appendChild(card);
            card.appendChild(title);
            card.appendChild(img);
        }
    }
    // function use to create input
    function createInput(response) {
        const allInput = document.querySelectorAll('.adminInput');
        for (const input of allInput) {
            input.remove();
        }
        let datas = response['data'];
        if (document.getElementById('numberOfManga')) {
            const numberOfManga = document.getElementById('numberOfManga');
            for (let i = 0; i < datas.length; i++) {
                const data = datas[i]

                //create all input to insert all manga fetch into DB
                const mangaTitle = document.createElement('input');
                const mangaNumberOfVolumes = document.createElement('input');
                const mangaDescription = document.createElement('input');
                const mangaStatus = document.createElement('input');
                const mangaAuthor = document.createElement('input');
                const mangaGenre = document.createElement('input');
                const mangaImage = document.createElement('input');
                const mangaType = document.createElement('input');
                const mangaRate = document.createElement('input');
                // set type of input
                mangaTitle.type = 'hidden';
                mangaNumberOfVolumes.type = 'hidden';
                mangaDescription.type = 'hidden';
                mangaStatus.type = 'hidden';
                mangaAuthor.type = 'hidden';
                mangaGenre.type = 'hidden';
                mangaImage.type = 'hidden';
                mangaType.type = 'hidden';
                mangaRate.type = 'hidden';
                // insert data into input value
                mangaTitle.value = data['title'];
                mangaNumberOfVolumes.value = data['volumes'];
                mangaDescription.value = data['synopsis'];
                mangaStatus.value = data['status'];
                if (data['authors'].length != 0) {
                    mangaAuthor.value = data['authors'][0]['name'];
                }  
                const arrayMangaGenre = []; 
                for (const genre of data['genres']) {
                    arrayMangaGenre.push(genre['name']);
                }
                mangaGenre.value = arrayMangaGenre;
                mangaImage.value = data['images']['webp']['image_url'];
                if (data['demographics'].length != 0) {
                mangaType.value = data['demographics'][0]['name'];
                }
                mangaRate.value = data['score'];
                //set name of the input
                mangaTitle.setAttribute('name', 'mangaTitle' + i);
                mangaNumberOfVolumes.setAttribute('name', 'mangaNumberOfVolumes' + i);
                mangaDescription.setAttribute('name', 'mangaDescription' + i);
                mangaStatus.setAttribute('name', 'mangaStatus' + i);
                mangaAuthor.setAttribute('name', 'mangaAuthor' + i);
                mangaGenre.setAttribute('name', 'mangaGenre' + i);
                mangaImage.setAttribute('name', 'mangaImage' + i);
                mangaType.setAttribute('name', 'mangaType' + i);
                mangaRate.setAttribute('name', 'mangaRate' + i);
                // set class
                mangaTitle.setAttribute('class', 'adminInput');
                mangaNumberOfVolumes.setAttribute('class', 'adminInput');
                mangaDescription.setAttribute('class', 'adminInput');
                mangaStatus.setAttribute('class', 'adminInput');
                mangaAuthor.setAttribute('class', 'adminInput');
                mangaGenre.setAttribute('class', 'adminInput');
                mangaImage.setAttribute('class', 'adminInput');
                mangaType.setAttribute('class', 'adminInput');
                mangaRate.setAttribute('class', 'adminInput');
                // insert input into the page
                cardContainer.appendChild(mangaTitle);
                cardContainer.appendChild(mangaNumberOfVolumes);
                cardContainer.appendChild(mangaDescription);
                cardContainer.appendChild(mangaStatus);
                cardContainer.appendChild(mangaAuthor);
                cardContainer.appendChild(mangaGenre);
                cardContainer.appendChild(mangaImage);
                cardContainer.appendChild(mangaType);
                cardContainer.appendChild(mangaRate);
            }
            // count number of manga was fetch
            numberOfManga.value = datas.length;
        }
    }
}
