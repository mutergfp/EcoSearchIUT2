$(document).ready(function() {
    // cache DOM
    var $productName = $('#searchbundle_produit_name');
    var $productPicture = $("#searchbundle_produit_photo");
    var $productRepo = $('.select-dropdown');
    var $productTags = $('#searchbundle_produit_tags');
    var $saveButton = $('#searchbundle_produit_save');
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
                autocompleteOptions: {
                    data: data,
                    limit: Infinity,
                    minLength: 1
                }
            });

        });
    }

    function getFormData() {
        var tagsData = $productTags.material_chip('data').reduce(function(prev, cur) {
            prev.push(cur.tag);
            return prev;
        }, []);

        return {
            name: $productName.val(),
            photo: $productPicture.val(),
            depot: $productRepo.val(),
            tags: tagsData
        }
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
            }, 100);
        });
    }

    function save(event) {
        console.log(getFormData());

        $.post(
            window.location.href,
            getFormData(),
            function(url) {
                //window.location.href = url;
            }
        );
    }


    function fillSelectTags() {
        var tagsData = $productTags.material_chip('data').forEach(function(chip) {
            $productTagsSelect.append("<option value='"+ chip.tag + "' selected='selected'>" + chip.tag + "</option>")
        });
    }
});
