<!-- application/modules/amalan/views/tinymce_init.php -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.7.2/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#isi_content',
    height: 500,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true
});
</script>