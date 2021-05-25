<h2 data-i18n="crashplan.title"></h2>
<div id="crashplan-tab"></div>

<div id="crashplan-msg" data-i18n="listing.loading" class="col-lg-12 text-center"></div>

<script>
$(document).on('appReady', function(){
	$.getJSON(appUrl + '/module/crashplan/get_tab_data/' + serialNumber, function(d){
        // Check if we have data
        if(!d.destination && d.destination !== null && d.destination !== 0){
            $('#crashplan-msg').text(i18n.t('no_data'));
            $('#crashplan-header').removeClass('hide');

        } else {

            // Hide
            $('#crashplan-msg').text('');
            $('#crashplan-view').removeClass('hide');

            // Generate rows from data
            var rows = '';
            var backup_status_rows = '';
            var backup_config_rows = '';
            var license_rows = '';

            for (var prop in d){

                // Do nothing for empty values to blank them
                if (d[prop] !== 0 && d[prop] == '' || d[prop] == null){
                    rows = rows

                // Format date - rows
                } else if((prop == "app_log_time" || prop == "cp_guid_change_time" ) && d[prop] > 0){
                    if(d[prop] > 3000000000){
                        var date = new Date((d[prop] * 1));
                    } else {
                        var date = new Date((d[prop] * 1000));
                    }
                    rows = rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td><span title="'+moment(date).fromNow()+'">'+moment(date).format('llll')+'</span></td></tr>';

                // Format date - backup_status_rows
                } else if((prop == "last_connected" || prop == "backup_start_time" || prop == "last_success" || prop == "last_failure") && d[prop] > 0){
                    if(d[prop] > 3000000000){
                        var date = new Date((d[prop] * 1));
                    } else {
                        var date = new Date((d[prop] * 1000));
                    }
                    backup_status_rows = backup_status_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td><span title="'+moment(date).fromNow()+'">'+moment(date).format('llll')+'</span></td></tr>';

                    // Client detail view
                    if (prop == "last_success" || prop == "last_failure" ){
                        $('.crashplan-'+prop).html('<span title="'+moment(date).fromNow()+'">'+moment(date).format('llll')+'</span>');
                    }

                // Format date - license_rows
                } else if((prop == "auth_date") && d[prop] > 0){
                    if(d[prop] > 3000000000){
                        var date = new Date((d[prop] * 1));
                    } else {
                        var date = new Date((d[prop] * 1000));
                    }
                    license_rows = license_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td><span title="'+moment(date).fromNow()+'">'+moment(date).format('llll')+'</span></td></tr>';

                // Format date - backup_config_rows
                } else if((prop == "backup_paths_last_modified") && d[prop] > 0){
                    if(d[prop] > 3000000000){
                        var date = new Date((d[prop] * 1));
                    } else {
                        var date = new Date((d[prop] * 1000));
                    }
                    backup_config_rows = backup_config_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td><span title="'+moment(date).fromNow()+'">'+moment(date).format('llll')+'</span></td></tr>';
                    
                // Format yes/no - backup_config_rows
                } else if((prop == "backup_enabled" || prop == "backup_scanning" || prop == "backup_check_for_deletes" || prop == "backup_open_files" || prop == "backup_compression" || prop == "backup_encryption" || prop == "backup_keep_deleted") && d[prop] == 0){
                    backup_config_rows = backup_config_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                } else if((prop == "backup_enabled" || prop == "backup_scanning" || prop == "backup_check_for_deletes" || prop == "backup_open_files" || prop == "backup_compression" || prop == "backup_encryption" || prop == "backup_keep_deleted") && d[prop] == 1){
                    backup_config_rows = backup_config_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';                        
                // Format yes/no - license_rows
                } else if((prop == "license_authorized") && d[prop] == 0){
                    license_rows = license_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                } else if((prop == "license_authorized") && d[prop] == 1){
                    license_rows = license_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';

                 // Format bytes
                } else if(prop == "app_log_size" || prop == "history_log_size"){
                    rows = rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+fileSize(d[prop], 2)+'</td></tr>';

                 // Format duration
                } else if(prop == "duration"){
                    backup_status_rows = backup_status_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td><span title="'+d[prop]+' seconds">'+moment.duration(parseInt(d[prop]), "seconds").humanize()+'</span></td></tr>';

                // Format backup_paths
                } else if(prop == "backup_paths"){
                    backup_config_rows = backup_config_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop].replace(/\n/g, "<br>").replace(/\\/g, "").replace(/, /g, "<br>")+'</td></tr>';

                // Collect rows
                } else if(prop == "cp_username" || prop == "guid" || prop == "org_name" || prop == "cp_guid_new" || prop == "cp_guid_old" || prop == "app_log_locale" || prop == "cp_version" || prop == "org_type"){
                    rows = rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop]+'</td></tr>';

                // Collect license_rows
                } else if(prop == "auth_rules" || prop == "license_model" || prop == "license_features"){
                    license_rows = license_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop]+'</td></tr>';

                // Collect backup_status_rows
                } else if(prop == "backup_total_files" || prop == "backup_total_size" || prop == "backup_start_files" || prop == "backup_end_files" || prop == "backup_sent" || prop == "backup_sent_speed"){
                    backup_status_rows = backup_status_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop]+'</td></tr>';

                // Build out client detail view from backup_status_rows
                } else if(prop == "reason"){
                    backup_status_rows = backup_status_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                    
                    // Client detail view
                    $('.crashplan-'+prop).text(d[prop]);

                // Build out client detail view from backup_config_rows
                } else if(prop == "destination"){
                    backup_config_rows = backup_config_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                    
                    // Client detail view
                    $('.crashplan-'+prop).text(d[prop]);

                // Else, build out backup_config_rows from entries
                } else {
                    backup_config_rows = backup_config_rows + '<tr><th>'+i18n.t('crashplan.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                }

            }

            $('#crashplan-tab')
                .append($('<div style="max-width:600px;">')
                    .append($('<table>')
                        .addClass('table table-striped table-condensed')
                        .append($('<tbody>')
                            .append(rows))))

            // Only show backup status table if data exists
            if (backup_status_rows !== ""){
                $('#crashplan-tab')
                    .append($('<h4>')
                        .append($('<i>')
                            .addClass('fa fa-clock-o'))
                        .append(' '+i18n.t('crashplan.backup_status')))
                    .append($('<div style="max-width:600px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody>')
                                .append(backup_status_rows))));
            }

            // Only show license table if data exists
            if (license_rows !== ""){
                $('#crashplan-tab')
                    .append($('<h4>')
                        .append($('<i>')
                            .addClass('fa fa-id-card'))
                        .append(' '+i18n.t('crashplan.license_info')))
                    .append($('<div style="max-width:600px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody>')
                                .append(license_rows))));
            }


            // Only show backup config table if data exists
            if (backup_config_rows !== ""){
                $('#crashplan-tab')
                    .append($('<h4>')
                        .append($('<i>')
                            .addClass('fa fa-wrench'))
                        .append(' '+i18n.t('crashplan.backup_config')))
                    .append($('<div style="max-width:600px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody>')
                                .append(backup_config_rows))));
            }
        }
	});
});
</script>
