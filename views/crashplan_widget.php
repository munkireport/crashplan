<div class="col-lg-4 col-md-6">
    <div class="card">
        <div class="card-header" data-container="body" title="">
            <i class="fa fa-clock-o"></i>
            <span data-i18n="crashplan.widget_title"></span>
            <a href="/show/listing/crashplan/crashplan" class="pull-right"><i class="fa fa-list"></i></a>
        </div>

        <div class="list-group scroll-box">
            <a id="cpp-today" href="<?= url('module/crashplan/listing') ?>"
               class="list-group-item list-group-item-success hide">
                <span class="badge">0</span>
                <span data-i18n="backup.today"></span>
            </a>
            <a id="cpp-lastweek" href="<?= url('module/crashplan/listing') ?>"
               class="list-group-item list-group-item-warning hide">
                <span class="badge">0</span>
                <span data-i18n="backup.lastweek"></span>
            </a>
            <a id="cpp-week_plus" href="<?= url('module/crashplan/listing') ?>"
               class="list-group-item list-group-item-danger hide">
                <span class="badge">0</span>
                <span data-i18n="backup.week_plus"></span>
            </a>
            <span id="cpp-nodata" data-i18n="no_clients" class="list-group-item"></span>
        </div>

    </div><!-- /panel -->

</div><!-- /col -->

<script>
  $(document).on('appReady appUpdate', function (e, lang) {

    $.getJSON(appUrl + '/module/crashplan/get_stats', function (data) {

// Show no clients span
      $('#cpp-nodata').removeClass('hide');

      $.each(data, function (prop, val) {
        if (val > 0) {
          $('#cpp-' + prop).removeClass('hide');
          $('#cpp-' + prop + ' > .badge').text(val);

          // Hide no clients span
          $('#cpp-nodata').addClass('hide');
        } else {
          $('#cpp-' + prop).addClass('hide');
        }
      });
    });
  });
</script>
