$( document ).ready(function(){
    //cache DOM
    var $hiddenTags = $(".hidden-tag");

    $(".button-collapse").sideNav();


    $('input.autocomplete').autocomplete({
        data: getData($hiddenTags),
        limit: 5,
            onAutocomplete: function(val) {
        },
        minLength: 1,
    });


    function getData($tags) {
        var data = {};
        for (var i = 0; i < $tags.length; i++) {
            data[$tags[i].innerText] = null;
        }
        return data;
    }
});