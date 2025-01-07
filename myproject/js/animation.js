$(document).ready(function () {
    const oscarImage = $('#oscar');

    oscarImage.on('click', function () {
        $(this).toggleClass('powiekszony'); // Przełączenie klasy powiększenia
    });
});

