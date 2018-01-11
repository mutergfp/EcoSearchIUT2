$(document).ready(function() {
    // cache DOM
    var $productName = $('#searchbundle_produit_name');
    var $productPicture = $("#searchbundle_produit_photo");
    var $productRepo = $('.select-dropdown');
    var $productTags = $('#searchbundle_produit_tags');
    var $saveButton = $('#searchbundle_save_button');
    var $getTagsURL = $('#tags-path');

    // bind events
    $saveButton.on('click', save);


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

    function save(event) {
        $.post(
            window.location.href,
            getFormData(),
            function(url) {
                window.location.href = url;
            }
        );
    }
});
