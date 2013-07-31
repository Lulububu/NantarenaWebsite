$(function() {

    $("body").on('dragover', ".imageUpload", function(e) {
        e.preventDefault();
    });

    $("body").on('drop', ".imageUpload", function(e) {
        e.preventDefault();
        imageUpload($(this), e.originalEvent.dataTransfer.files[0]);
    });

    $("body").on('click', ".imageUpload button.upload", function(e) {
        e.preventDefault();
        $("input[type=file]", $(this).parents(".imageUpload")).click();
    });

    $("body").on('click', ".imageUpload button.delete", function(e) {
        e.preventDefault();
        var handler = $(this).parents(".imageUpload");

        $(".empty", $(handler)).removeClass('hide');
        $("button.upload", $(handler)).removeClass('hide');
        $(".thb", $(handler)).addClass('hide');
        $(this).addClass('hide');
        $("input[type=hidden]", $(handler)).val('');
    });

    $("body").on('change', ".imageUpload input[type=file]", function(e) {
        var file = $(this).prop('files')[0];
        imageUpload($(this).parents(".imageUpload"), file);
    });
});

function imageUpload(handler, file)
{
    if (!file || !file.type.match(/image.*/)) return;

    $(".empty", handler).addClass('hide');
    $(".uploading", handler).removeClass('hide');

    var img = document.createElement("img");
    var reader = new FileReader();
    reader.onload = function(e) {
        img.src = e.target.result;

        var fd = new FormData();
        fd.append("image", file);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "https://api.imgur.com/3/image.json");
        xhr.onload = function() {
            var link = JSON.parse(xhr.responseText).data.link;
            $("input[type=hidden]", handler).val(link);
            $(".thb img", handler).attr('src', link);
            $(".empty", $(handler)).addClass('hide');
            $("button.upload", $(handler)).addClass('hide');
            $(".uploading", $(handler)).addClass('hide');
            $("button.delete", $(handler)).removeClass('hide');
            $(".thb", $(handler)).removeClass('hide');
        }
        xhr.upload.addEventListener("progress", function(e) {
            if (e.lengthComputable) {
                var percentage = Math.round((e.loaded * 100) / e.total);
                $(".uploading span", handler).text(percentage + "%");
            }
        }, false);

        xhr.setRequestHeader('Authorization', 'Client-ID 995735d20e824ab');
        xhr.send(fd);
    }

    reader.readAsDataURL(file);
}
