<script>
function handleDelete(options) {
    const {
        id,
        route,
        table,
        title = 'Are you sure?',
        text = 'This record will be permanently deleted!',
        confirmText = 'Yes, delete it!'
    } = options;

    let deleteUrl = route.replace(':id', id);

    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (table) {
                        $(table).DataTable().ajax.reload(null, false);
                    }

                    showToast(response.message ?? 'Deleted successfully');
                },
                error: function () {
                    showToast('Failed to delete!', 'error');
                }
            });
        }

    });
}
</script>
