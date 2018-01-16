$(document).ready(function() {
    // cache DOM
    var $productTags = $('#searchbundle_produit_tags');
    var $getTagsURL = $('#tags-path');
    var $getTagsProduct = $("#gettagsproduct-path");
    var $productTagsSelect = $("<select name='searchbundle_produit_tags[]' multiple='multiple'></select>").insertBefore($productTags);
    var $productForm = $("form[name='searchbundle_produit']");

    // bind events
    $productForm.submit(function() {
        fillSelectTags();
        return true;
    });

    // init chips
    $productTags.material_chip();
    getProductTagsData($getTagsProduct.text());
    getTagsData($getTagsURL.text());


    function getTagsData(url) {
        $.getJSON(encodeURI(url), function(json) {
            var data = json.reduce(function(prev, cur) {
                prev[cur] = null;
                return prev;
            }, {});

            $productTags.material_chip({
                placeholder: 'Entrez un tag',
                secondaryPlaceholder: '+Tag',
                autocompleteOptions: {
                    data: data,
                    limit: Infinity,
                    minLength: 1
                }
            });

        });
    }


    function getProductTagsData(url) {
        $.getJSON(url, function(json) {
            var tagsData = json.reduce(function(prev, cur){
                prev.push({
                    tag: cur
                });
                return prev;
            }, []);
            setTimeout(function() {
                $productTags.material_chip({
                    data: tagsData
                });
            }, 200);
        });
    }

    function fillSelectTags() {
        var tagsData = $productTags.material_chip('data').forEach(function(chip) {
            $productTagsSelect.append("<option value='"+ chip.tag + "' selected='selected'>" + chip.tag + "</option>")
        });
    }
});
