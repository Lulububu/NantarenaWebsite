$(function() {

    $(".collection_holder").on('click', 'a.collection_add', function(e) {
        e.preventDefault();

        var collectionHolder = $(this).parents(".collection_holder");

        var prototype = collectionHolder.data('prototype');
        var index = collectionHolder.data('count');

        var newForm = prototype.replace(/__name__/g, index);
        collectionHolder.data('count', index + 1);

        $(this).parents('tr').before(newForm);
        $(this).trigger('collection_add_clicked');
    });

    $(".collection_holder").on('click', 'a.collection_delete', function(e) {
        e.preventDefault();
        $(this).parents('tr').remove();
        $(this).trigger('collection_delete_clicked');
    });

});
