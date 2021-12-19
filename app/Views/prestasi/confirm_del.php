<script>
    function deletePrestasi(element) {
        const url = element.getAttribute('data-url')
        Swal.fire({
            title: "Warning",
            text: `Yakin menghapus data prestasi? Proses ini tidak dapat diulang`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#169b6b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url
            }
        })
    }
</script>