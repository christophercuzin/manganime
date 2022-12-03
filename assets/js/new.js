import * as API_ENV from "../../config/packages/js.yaml";

const numberOfVolume = document.getElementById('number_of_volume');
const listOfVolumeContainer = document.getElementById('list_of_volume_container');

function listOfVolumeInput() {
    
    const numberOfVolumeValue = numberOfVolume.value;
    const allInputVolumeLabel = document.querySelectorAll('.listOfVolumeLabel');
    const listOfVolumeField = document.querySelectorAll('.listOfVolumeField');
    if(listOfVolumeField) {
        for (const VolumeField of listOfVolumeField) {
            VolumeField.remove();
        }
        for (const InputVolumeLabel of allInputVolumeLabel) {
            InputVolumeLabel.remove();
        }
    }
    let j = 1;
    for (let i = 0; i < numberOfVolumeValue; i++) {
        const listOfVolumeField = document.createElement('input');
        listOfVolumeField.type = "number";
        listOfVolumeField.setAttribute('class', 'listOfVolumeField');
        listOfVolumeField.classList.add('form-control');
        listOfVolumeField.classList.add('mb-3');
        listOfVolumeField.setAttribute('min', '0');
        listOfVolumeField.value = (j);
        
        listOfVolumeContainer.appendChild(listOfVolumeField);
        const listOfVolumeFields = document.querySelectorAll('.listOfVolumeField');
        for (let i = 0; i < listOfVolumeFields.length; i++) {
            const element = listOfVolumeFields[i];
            element.setAttribute('name', 'volume' + i);
            
        }
        j++
    }
}

function CheckInputVolumeList () {
    const allInputVolume = document.querySelectorAll('.listOfVolume');
    const numberOfVolumeValue = numberOfVolume.value;
    if (allInputVolume.length != 0) {
        for (const inputVolume of allInputVolume) {
            if (inputVolume.checked == true) {
                inputVolume.checked = false;
            }
        }
        for (let i = 0; i < numberOfVolumeValue; i++) {
            const inputVolume = allInputVolume[i];
            inputVolume.checked = true;
        }
    
    }
}

if (document.getElementById('manga_title')) {
    const mangaTitleInput = document.getElementById('manga_title');
    const numberOfVolumeinput = document.getElementById('number_of_volume_input');
    const addNewMangabutton = document.getElementById('add_new_manga');
    const apiEnv = API_ENV

            mangaTitleInput.addEventListener('keyup', () => {
                const title = mangaTitleInput.value;
                const options = {
                    method: 'GET',
                    headers: {
                        apiEnv
                    }
                };
                // fetch manga by name
                if (title != "") {
                    fetch('https://api.jikan.moe/v4/manga?letter=' + title)
                    .then(response => response.json())
                    .then(response =>  createListOfVolumeInput(response))
                    
                    if (document.querySelector('.listOfVolume')) {
                        numberOfVolume.addEventListener('focusout', () => {
                        setTimeout(CheckInputVolumeList, 3000);
                        })
                    }
                }
            })

            
        

        
    

    /* function createOptions(response) {
        let data = response['data'];
        
        const optionList = document.getElementById('option-list');
        const options = document.querySelectorAll('.option');
        for (const option of options) {
            if (option) {
                option.remove();
            }
            
        }
        if (data != "") {
            for (let i = 0; i < data.length; i++) {
                const title = data[i]['title'];
                const option = document.createElement('li')
                option.setAttribute('class', 'dropdown-item');
                option.setAttribute('class', 'option');
                option.innerHTML = title;
                optionList.appendChild(option);
                option.addEventListener('click', () => {
                    mangaTitleInput.value = option.innerHTML;
                    mangaTitleInput.classList.remove('show');
                    mangaTitleInput.setAttribute('aria-expanded', 'false');
                    mangaTitleInput.removeAttribute('data-bs-toggle');
                    optionList.removeAttribute('data-bs-popper');
                    optionList.classList.remove('show');
                })
            } 
            mangaTitleInput.classList.add('show');
            mangaTitleInput.setAttribute('aria-expanded', 'true');
            mangaTitleInput.setAttribute('data-bs-toggle', 'dropdown');
            optionList.setAttribute('data-bs-popper', 'static');
            optionList.classList.add('show');
        }
    } */
    

    function createListOfVolumeInput(response) {
        let data = response['data'];
        const allInputVolume = document.querySelectorAll('.listOfVolume');
        const allInputVolumeLabel = document.querySelectorAll('.listOfVolumeLabel');
        const listOfVolumeField = document.querySelectorAll('.listOfVolumeField');
        for (const VolumeField of listOfVolumeField) {
            VolumeField.remove();
        }
        for (const InputVolume of allInputVolume) {
            InputVolume.remove();
        }
        for (const InputVolumeLabel of allInputVolumeLabel) {
            InputVolumeLabel.remove();
        }
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
            } else if (!document.querySelector('.listOfVolume')) {
                numberOfVolume.addEventListener('focusout', () => {
                setTimeout(listOfVolumeInput, 2000);
                })
       }
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