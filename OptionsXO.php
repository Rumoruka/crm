<meta charset="UTF-8">
<form enctype="multipart/form-data" action="readxlXO.php" method="POST" onsubmit="return do_val();">

<!--<input type="text" name="fileName" id="fileName" required /><br /><br />
// -->
<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
<label>Choose a CSV File (maximum 300kb)</label><br />
<input name="uploadedfile" type="file" /><br />
<input type="submit" value="submit" />
</form>

<script>
function do_val()
{
	var fileExtension = document.getElementById('fileName').value;
	if (fileExtension.split('.').pop() != 'csv') {alert ('Please Upload a CSV File');return false;}
}
</script>