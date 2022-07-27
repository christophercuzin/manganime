if (document.getElementById('card_container')) {
   const cardContainer = document.getElementById('card_container');
   const pageNumberButtons = document.querySelectorAll('.number_of_page_container [id]');
   // create connection to the api
    const options = {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': 'fc47d97221msh17b6ad84ac6ce4fp170552jsnc448ea813ea2',
            'X-RapidAPI-Host': 'jikan1.p.rapidapi.com'
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

    if (document.getElementById('search')) {
        const search = document.getElementById('search');
        const searchButton = document.getElementById('searchButton');
        searchButton.addEventListener('click', () => {
            const title = search.value;
            const options = {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': 'fc47d97221msh17b6ad84ac6ce4fp170552jsnc448ea813ea2',
                    'X-RapidAPI-Host': 'jikan1.p.rapidapi.com'
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
                // set type of input
                mangaTitle.type = 'hidden';
                mangaNumberOfVolumes.type = 'hidden';
                mangaDescription.type = 'hidden';
                mangaStatus.type = 'hidden';
                mangaAuthor.type = 'hidden';
                mangaGenre.type = 'hidden';
                mangaImage.type = 'hidden';
                // insert data into input value
                mangaTitle.value = data['title'];
                mangaNumberOfVolumes.value = data['volumes'];
                mangaDescription.value = data['synopsis'];
                mangaStatus.value = data['status'];
                if (data['authors'].length != 0) {
                    mangaAuthor.value = data['authors'][0]['name'];
                }   
                for (const genre of data['genres']) {
                    mangaGenre.value = mangaGenre.value + genre['name'] + ', ';
                }
                mangaImage.value = data['images']['webp']['image_url'];
                //set name of the input
                mangaTitle.setAttribute('name', 'mangaTitle' + i);
                mangaNumberOfVolumes.setAttribute('name', 'mangaNumberOfVolumes' + i);
                mangaDescription.setAttribute('name', 'mangaDescription' + i);
                mangaStatus.setAttribute('name', 'mangaStatus' + i);
                mangaAuthor.setAttribute('name', 'mangaAuthor' + i);
                mangaGenre.setAttribute('name', 'mangaGenre' + i);
                mangaImage.setAttribute('name', 'mangaImage' + i);
                // insert input into the page
                cardContainer.appendChild(mangaTitle);
                cardContainer.appendChild(mangaNumberOfVolumes);
                cardContainer.appendChild(mangaDescription);
                cardContainer.appendChild(mangaStatus);
                cardContainer.appendChild(mangaAuthor);
                cardContainer.appendChild(mangaGenre);
                cardContainer.appendChild(mangaImage);
            }
            // count number of manga was fetch
            numberOfManga.value = datas.length;
        }
    }
}
