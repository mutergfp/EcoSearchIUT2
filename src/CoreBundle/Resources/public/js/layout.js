$( document ).ready(function(){
    /*//cache DOM
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

    $('select').material_select();
    */

    // cache DOM
    var $getTagsURL = $('#tags-path');

    $(".button-collapse").sideNav();

    getData($getTagsURL.text());

    function getData(url) {
        $.getJSON(encodeURI(url), function(json) {
            var data = json.reduce(function(prev, cur) {
                prev[cur] = null;
                return prev;
            }, {});

            $('input.autocomplete').autocomplete({
                data: data,
                limit: 5,
                onAutocomplete: function(val) {
                },
                minLength: 1
            });
        });
    }

    $('select').material_select();

});