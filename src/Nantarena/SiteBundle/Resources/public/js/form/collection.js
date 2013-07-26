$(function() {

    $(".collection_holder").on('click', '.collection_add', function(e) {
        e.preventDefault();

        var collectionHolder = $(this).parents(".collection_holder");

        var prototype = collectionHolder.data('prototype');
        var index = collectionHolder.data('count');

        var newForm = prototype.replace(/__name__/g, index);
        collectionHolder.data('count', index + 1);

        $(this).parents('tr').before(newForm);
    });

    $(".collection_holder").on('click', '.collection_delete', function(e) {
        e.preventDefault();
        $(this).parents('tr').remove();
    });

});
