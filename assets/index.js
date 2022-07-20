if (document.getElementById('card_container')) {
   const cardContainer = document.getElementById('card_container');
   const pageNumberButtons = document.querySelectorAll('.number_of_page_container [id]');
    const options = {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': 'fc47d97221msh17b6ad84ac6ce4fp170552jsnc448ea813ea2',
            'X-RapidAPI-Host': 'jikan1.p.rapidapi.com'
        }
    };

    fetch('https://api.jikan.moe/v4/manga?page=1')
    .then(response => response.json())
    .then(response => showImg(response))

    let i = 1;
    for (const pageNumberButton of pageNumberButtons) {
        pageNumberButton.addEventListener('click', (event) => {
            let target = event.target;
            if (target === pageNumberButton) {
                fetch('https://api.jikan.moe/v4/manga?page=' + pageNumberButton.value )
                .then(response => response.json())
                .then(response => showImg(response))

            }
        })
    }

    function showImg (response) {
        let datas = response['data'];
        if ( document.getElementsByClassName('card')) {
            const cards = document.getElementsByClassName('card');
            for (let i = 0; i < cards.length;) {
                const element = cards[i];
                element.remove();
            }
            
            
        }
        for (let i = 0; i < datas.length; i++) {
            const data = datas[i]

            const card = document.createElement('div')
            card.setAttribute('class', 'card');

            const img = document.createElement('img');
            img.setAttribute('class', 'card-img-top');
            img.setAttribute('alt', 'image du manga' + data['title']);
            img.setAttribute('src', data['images']['jpg']['image_url'])

            const title = document.createElement('h6');
            title.setAttribute('class', 'card-title');
            title.innerHTML = data['title']
            
            cardContainer.appendChild(card);
            card.appendChild(title);
            card.appendChild(img);
        }
    }
    

}
