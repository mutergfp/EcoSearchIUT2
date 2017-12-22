$( document ).ready(function(){
    //cache DOM
    var $hiddenTags = $(".hidden-tag");

    $(".button-collapse").sideNav();


    $('input.autocomplete').autocomplete({
        data: getData($hiddenTags),
        limit: 5,
            onAutocomplete: function(val) {
        },
        minLength: 1
    });


    function getData($tags) {
        $tags = Array.prototype.slice.call($tags);
        return $tags.reduce(function(prev, $cur) {
            prev[$cur.innerText] = null;
            return prev;
        }, {});
    }
});