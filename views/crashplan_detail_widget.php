<div class="col-lg-4">
    <h4><i class="fa fa-home"></i> <span data-i18n="crashplan.title"></span></h4>
    <table class="mr-crashplan-table">
    </table>
</div>

<script>

$(document).on('appReady', function(e, lang) {

    // Get backup data
    $.getJSON( appUrl + '/module/crashplan/get_data/' + serialNumber, function( data ) {

		// Draw Crashplan Unit
		var mr_table_data = '<tr><td>'+i18n.t('no_data')+'</td></tr>';
		if(data){
			mr_table_data = '';
			$.each(data, function(index, item){
				mr_table_data = mr_table_data + '<tr class="info"><th>'+i18n.t('backup.destination')+'</th><td>'+item.destination+'<td></tr>';
				mr_table_data = mr_table_data + '<tr><th>'+i18n.t('backup.last_success')+'</th><td>'+moment(item.last_success * 1000).fromNow()+'<td></tr>';
				mr_table_data = mr_table_data + '<tr><th>'+i18n.t('backup.duration')+'</th><td>'+moment.duration(item.duration, "seconds").humanize()+'<td></tr>';
				mr_table_data = mr_table_data + '<tr><th>'+i18n.t('backup.last_failure')+'</th><td>'+moment(item.last_failure * 1000).fromNow()+'<td></tr>';
				mr_table_data = mr_table_data + '<tr><th>'+i18n.t('backup.last_failure_msg')+'</th><td>'+item.reason+'<td></tr>';
			});
		}
		$('table.mr-crashplan-table')
			.empty()
			.append(mr_table_data)
	});
});

</script>