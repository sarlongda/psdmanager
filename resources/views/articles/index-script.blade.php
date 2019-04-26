<script type="text/javascript">
    jQuery(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-delete-article', function () {
            var url = $(this).data('action');
            $('#form-article-delete').attr('action', url);
        });

    })
</script>