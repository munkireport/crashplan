<div class="col-lg-4 col-md-6">
    <div class="card" id="crashplan-widget">
        <div class="card-header" data-container="body">
            <i class="fa fa-clock-o"></i>
                <span data-i18n="crashplan.widget_title"></span>
                <a href="/show/listing/crashplan/crashplan" class="pull-right"><i class="fa fa-list"></i></a>
        </div>
        <div class="card-body text-center"></div>
    </div><!-- /panel -->
</div><!-- /col -->

<script>
$(document).on('appUpdate', function(e, lang) {

    $.getJSON( appUrl + '/module/crashplan/get_stats', function( data ) {

        if(data.error){
            // alert(data.error);
            return;
        }

        var panel = $('#crashplan-widget div.card-body'),
        baseUrl = appUrl + '/show/listing/crashplan/crashplan';
        panel.empty();

        // Set statuses
        if(data.week_plus != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-danger"><span class="bigger-150">'+data.week_plus+'</span><br>'+i18n.t('backup.week_plus')+'</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-danger disabled"><span class="bigger-150">'+data.week_plus+'</span><br>'+i18n.t('backup.week_plus')+'</a>');
        }
        
        if(data.lastweek != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-warning"><span class="bigger-150">'+data.lastweek+'</span><br>'+i18n.t('backup.lastweek')+'</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-warning disabled"><span class="bigger-150">'+data.lastweek+'</span><br>'+i18n.t('backup.lastweek')+'</a>');
        }
        
        if(data.today != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success"><span class="bigger-150">'+data.today+'</span><br>'+i18n.t('backup.today')+'</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success disabled"><span class="bigger-150">'+data.today+'</span><br>'+i18n.t('backup.today')+'</a>');
        }

    });
});
</script>
