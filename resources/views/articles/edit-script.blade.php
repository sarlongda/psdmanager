<script type="text/javascript">
    jQuery(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#btn-preview-front', function () {
            var article_id = $(this).data('article-id');
            document.getElementById('img-article-preview').src = "/PSD_Manager/Articles/Template1/" + article_id + "/" + article_id + "_prev_1.png" + "?random="+new Date().getTime();
            $('#modal-article-preview').modal('toggle');

        });

    })
</script>