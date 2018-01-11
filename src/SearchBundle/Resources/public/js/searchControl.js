var search = (function() {
    //cache DOM
    var $searchInput = $("#search-input");
    var $searchButton = $("#search-button");
    var $path = $("#search-path");

    // variables
    var path = $path.text();

    //bind events
    $searchInput.on("keypress", enterStartSearch);
    $searchButton.on("click", startSearch);



    function enterStartSearch(event) {
        if (event.which == 13) {
            startSearch();
        }
    }

    function startSearch(event) {
        var val = $searchInput.val();
        if (val != "") {
            val = "/" + val;
        }
        window.location.href = encodeURI(path + val);
    }



})();