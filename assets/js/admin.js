jQuery(document).ready(function ($) {
    var mediaUploader;

    $('#category-banner-upload-button').on('click', function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Banner Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category_banner_id').val(attachment.id);
            $('#category-banner-preview').html('<img src="' + attachment.url + '" alt="Banner Preview" />');
        });

        mediaUploader.open();
    });

    $('#category-banner-remove-button').on('click', function () {
        $('#category_banner_id').val('');
        $('#category-banner-preview').html('');
    });
});
