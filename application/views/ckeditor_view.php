<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>A Simple Page with CKEditor</title>
        <!-- Make sure the path to CKEditor is correct. -->
        <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
        <script src="/sys/ckeditor/ckeditor.js"></script>
        <script src="/sys/ckfinder/ckfinder.js"></script>
    </head>
    <body>
        <form>
            <textarea name="editor1" id="editor1" rows="10" cols="80">
                This is my textarea to be replaced with CKEditor.
            </textarea>
            <?php if ($value): ?>
                結果:
                <textarea style='width:100%' rows="10" cols="80"><?= $value ?></textarea>
            <?php endif; ?>

            <script>
                $(function ()
                {
                    var ck_editor1 = CKEDITOR.replace( 'editor1',
                    {
                        filebrowserBrowseUrl      : 'sys/ckfinder/ckfinder.html',
                        filebrowserImageBrowseUrl : 'sys/ckfinder/ckfinder.html?type=Images',
                        filebrowserFlashBrowseUrl : 'sys/ckfinder/ckfinder.html?type=Flash',
                        filebrowserUploadUrl      : 'sys/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                        filebrowserImageUploadUrl : 'sys/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                        filebrowserFlashUploadUrl : 'sys/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                    });
                    CKFinder.setupCKEditor( ck_editor1, '/sys/ckfinder/') ;
                });
            </script>
            <input type='submit'>
        </form>
    </body>
</html>