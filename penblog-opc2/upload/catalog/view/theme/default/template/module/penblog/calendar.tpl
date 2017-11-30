<div id="<?php echo $module; ?>" data-date="<?php echo $today; ?>" data-date-format="yyyy-mm-dd"></div>
<script type="text/javascript">
$('#<?php echo $module; ?>').datepicker({
	todayBtn: 'linked'
});
$('#<?php echo $module; ?>').datepicker()
    .on('changeDate', function(e) {
    	var value = $(this).datepicker('getFormattedDate');
		
		url = 'index.php?route=penblog/search&date_added=' +  encodeURIComponent(value);
		
		location = url;
    });
</script>
