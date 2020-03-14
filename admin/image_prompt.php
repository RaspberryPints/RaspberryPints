<?php
require_once __DIR__.'/header.php';
?>
<body>
    <form enctype="multipart/form-data" action="includes/upload_image.php" method="POST">
        <input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
        <input type="hidden" name="target" value="<?php echo __DIR__.'/../img/'.(isset($_POST["targetDir"])?$_POST["targetDir"]:'tap/tap').$_GET['id'] ?>"/>
        <input type="hidden" name="redirect" value=""/>
        <input type="hidden" name="deleteOthers" value=""/>
        <input type="submit" class="btn" value="Upload" /><br /><br />'
    </form>'
<script>
$('input[type=file]').change(function() {
	$(this).parent("form").find("input[type='submit']").trigger("click");
});
$('input[type=file]').trigger("click");
</script>
</body>
</html>