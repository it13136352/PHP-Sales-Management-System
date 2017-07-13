<div class="footer">©

<script>
$('#datepicker').datepicker({
    onSelect: function () {
        $('#data').text(this.value);
    }
});
</script>

 
<form>
<label>Start Time </lable>
<input type="text" id="datepicker" name="date" />
<label>End Time </lable>
<input type="text" id="datepicker" name="date" />
</form>

<?php /*?>$copyYear = 2013; 
$curYear = date('Y'); 
echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
<?php */?>