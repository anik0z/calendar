(function() {
    const listDays = document.getElementsByClassName('eventAdd');

    for(let i = 0;i < listDays.length;i++){
        listDays[i].addEventListener('dblclick', function (e) {
            // activate the form
            this.childNodes[2].submit();
        });
    }

})();

