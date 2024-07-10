// функция для загрузки городов
// создаёт запрос на сервер getCities.php, передавая id страны
function loadCities(countryId) {
    fetch('pages/getCities.php?countryId=' + countryId)
        .then(response => response.json())//результат(строка json) преобразуется в объект JS
        .then(data => {
            console.log(data);
            const citySelect = document.getElementById('citySelect');//выпадающий список
            citySelect.innerHTML = '<option value="0">Select city...</option>';
            data.forEach(city => {
                citySelect.innerHTML += `<option value="${city.id}">${city.city}</option>`;
            });
        });
}

// функция для загрузки отелей
function loadHotels(cityId) {
    fetch('pages/getHotels.php?cityId=' + cityId)
        .then(response => response.json())
        .then(data => {
            const hotelTable = document.getElementById('hotelList');
            hotelTable.innerHTML = `
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Hotel</th>
                            <th>Price</th>
                            <th>Stars</th>
                            <th>More Info</th>
                        </tr>
                    </thead>
                    <tbody>
       <!--для каждого элемента массива (каждого объекта отеля), map возвращает строку HTML, описывающую этот отель -->
                        ${data.map(hotel => `
                            <tr>
                                <td>${hotel.hotel}</td>
                                <td>$${hotel.cost}</td>
                                <td>${hotel.stars}</td>
                                <td><a href="pages/hotelinfo.php?hotel=${hotel.id}" target="_blank">More info</a></td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>`;
        })
        .catch(error => console.error('Error loading hotels:', error));
}
