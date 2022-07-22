if (document.getElementById('manga_title')) {
    const mangaTitleInput = document.getElementById('manga_title');
    const listOfVolumeContainer = document.getElementById('list_of_volume_container');
    const numberOfVolumeinput = document.getElementById('number_of_volume_input');
    const addNewMangabutton = document.getElementById('add_new_manga');
    const buttonAddNewField = document.getElementById('buttonAddNewField');

    mangaTitleInput.addEventListener('focusout', () => {
        const title = mangaTitleInput.value;
        const options = {
            method: 'GET',
            headers: {
                'X-RapidAPI-Key': 'fc47d97221msh17b6ad84ac6ce4fp170552jsnc448ea813ea2',
                'X-RapidAPI-Host': 'jikan1.p.rapidapi.com'
            }
        };
        // fetch the first page of manga
        fetch('https://api.jikan.moe/v4/manga?letter=' + title)
        .then(response => response.json())
        .then(response =>  createListOfVolumeInput(response))
        setTimeout(CheckAllInput, 3000)
        
        
    })

    function CheckAllInput () {
        if (document.getElementById('checkAll')) {
            const checkAll = document.getElementById('checkAll');
            const allInputVolume = document.querySelectorAll('.listOfVolume');
            checkAll.onchange = () => {
                for (const InputVolume of allInputVolume) {
                    InputVolume.checked = true;
                    if (InputVolume.checked == true && checkAll.checked == false) {
                        InputVolume.checked = false;
                    }
                }
            }
        }
    }

    function createListOfVolumeInput(response) {
        let data = response['data'];
        if (data != "") {
            mangaTitleInput.value = data[0]['title'];
            if (data[0]['volumes']) {
                let j = 1;
                for (let i = 0; i < data[0]['volumes']; i++) {

                    const listOfVolumeLabel = document.createElement('label');
                    listOfVolumeLabel.setAttribute('for', 'listOfVolume' + i);
                    listOfVolumeLabel.setAttribute('class', 'listOfVolumeLabel');
                    listOfVolumeLabel.classList.add('form-label');
                    listOfVolumeLabel.innerHTML = 'tome' + j;

                    const listOfVolumeInput = document.createElement('input');
                    listOfVolumeInput.type = "checkbox";
                    listOfVolumeInput.setAttribute('id', 'listOfVolume' + i);
                    listOfVolumeInput.setAttribute('name', 'volume' + i);
                    listOfVolumeInput.setAttribute('class', 'listOfVolume');
                    listOfVolumeInput.value = j;

                    listOfVolumeContainer.appendChild(listOfVolumeInput);
                    listOfVolumeContainer.appendChild(listOfVolumeLabel);

                    j++
                }
                const checkAllLabel = document.createElement('label');
                checkAllLabel.setAttribute('for', 'checkAll');
                checkAllLabel.setAttribute('class', 'checkAllLabel');
                checkAllLabel.classList.add('form-label');
                checkAllLabel.innerHTML = 'Tout cocher';

                const checkAll = document.createElement('input');
                checkAll.type = "checkbox";
                checkAll.setAttribute('id', 'checkAll');

                listOfVolumeContainer.appendChild(checkAll);  
                listOfVolumeContainer.appendChild(checkAllLabel);
                
            } else {
                const addVolumeField = document.createElement('button');
                addVolumeField.type = "button";
                addVolumeField.setAttribute('class', 'btn');
                addVolumeField.classList.add('btn-primary');
                addVolumeField.classList.add('col-6');
                addVolumeField.classList.add('mb-5');
                addVolumeField.innerHTML = "Ajouter un volume"
                addVolumeField.addEventListener('click', () => {
   
                   const listOfVolumeField = document.createElement('input');
                   listOfVolumeField.type = "number";
                   listOfVolumeField.setAttribute('class', 'listOfVolumeField');
                   listOfVolumeField.classList.add('form-control');
                   listOfVolumeField.classList.add('mb-3');
                   listOfVolumeField.setAttribute('min', '0');
                   
                   listOfVolumeContainer.appendChild(listOfVolumeField);
                   const listOfVolumeFields = document.querySelectorAll('.listOfVolumeField');
                   for (let i = 0; i < listOfVolumeFields.length; i++) {
                       const element = listOfVolumeFields[i];
                       element.setAttribute('name', 'volume' + i);
                       
                   }
                })
                buttonAddNewField.appendChild(addVolumeField);
           }
        } else {
            const addVolumeField = document.createElement('button');
            addVolumeField.type = "button";
            addVolumeField.setAttribute('class', 'btn');
            addVolumeField.classList.add('btn-primary');
            addVolumeField.classList.add('col-6');
            addVolumeField.innerHTML = "Ajouter un volume"
            addVolumeField.addEventListener('click', () => {

                const listOfVolumeField = document.createElement('input');
                listOfVolumeField.type = "number";
                listOfVolumeField.setAttribute('class', 'listOfVolumeField');
                listOfVolumeField.classList.add('form-control');
                listOfVolumeField.setAttribute('min', '0');

                listOfVolumeContainer.appendChild(listOfVolumeField);
                const listOfVolumeFields = document.querySelectorAll('.listOfVolumeField');
                for (let i = 0; i < listOfVolumeFields.length; i++) {
                    const element = listOfVolumeFields[i];
                    element.setAttribute('name', 'volume' + i);
                }
             })
             buttonAddNewField.appendChild(addVolumeField);
        }
    }

    addNewMangabutton.addEventListener('click', () => {
            const allInputVolume = document.querySelectorAll('.listOfVolume');
            if (allInputVolume.length != 0) {
            const inputChecked = [];
            let i = 0;
            for (const InputVolume of allInputVolume) {
                if (InputVolume.checked == true) {
                inputChecked.push(InputVolume.value);
                InputVolume.setAttribute('name', 'volume' + i);
                i++
                }
            }
            numberOfVolumeinput.value = inputChecked.length;
        }  
        const listOfVolumeFields = document.querySelectorAll('.listOfVolumeField');
        if (listOfVolumeFields.length != 0) {
        numberOfVolumeinput.value = listOfVolumeFields.length;
        }
    })
}