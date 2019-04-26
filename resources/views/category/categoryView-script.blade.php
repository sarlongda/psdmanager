<script type="text/javascript">
    jQuery(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-edit-category', function () {
            var url = $(this).data('action');
            var title = $(this).data('category-title');
            $('#category_title').val(title);
            $('#form-category-edit').attr('action', url);
        });

        $(document).on('click', '.btn-delete-category', function () {
            var url = $(this).data('action');
            $('#form-category-delete').attr('action', url);
        });

    })
</script>