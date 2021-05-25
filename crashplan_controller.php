<?php

/**
 * crashplan class
 *
 * @package munkireport
 * @author AvB
 **/
class Crashplan_controller extends Module_controller
{

    /*** Protect methods with auth! ****/
    function __construct()
    {
        // Store module path
        $this->module_path = dirname(__FILE__);
    }

    /**
     * Get data for widgets
     *
     * @return void
     * @author tuxudo
     **/
    public function get_widget_data($column = '')
    {
        jsonView(
            Crashplan_model::select($column . ' AS label')
                ->selectRaw('count(*) AS count')
                ->whereNotNull($column)
                ->filter()
                ->groupBy($column)
                ->orderBy('count', 'desc')
                ->get()
                ->toArray()
        );
    }

    /**
     * Get timestamp statistics for specified column
     *   *
     * @param column name that is a timestamp
     **/
    public function get_stats($column = '')
    {
        $now = time();
        $lasthour = ($now - 3600) * 1000;
        $today = ($now - 3600 * 24) * 1000;
        $week_ago = ($now - 3600 * 24 * 7) * 1000;
        $month_ago = ($now - 3600 * 24 * 30) * 1000;
        $column = preg_replace("/[^a-z0-9_]]/", '', $column);

        jsonView(
            Crashplan_model::selectRaw("COUNT(1) as count,
                COUNT(CASE WHEN ".$column." > '$lasthour' THEN 1 END) AS lasthour, 
                COUNT(CASE WHEN ".$column." BETWEEN '$today' AND '$lasthour' THEN 1 END) AS today,
                COUNT(CASE WHEN ".$column." BETWEEN '$week_ago' AND '$today' THEN 1 END) AS lastweek,
                COUNT(CASE WHEN ".$column." < '$week_ago' THEN 1 END) AS week_plus")
            ->whereNotNull($column)
            ->filter()
            ->first()
            ->toLabelCount()
        );
    }


    /**
     * Get crashplan information for serial_number
     *
     * @param string $serial serial number
     **/
    public function get_tab_data($serial_number = '')
    {
        jsonView(
            Crashplan_model::selectRaw('cp_version, cp_username, org_name, guid, org_type, license_authorized, license_model, license_features, auth_date, auth_rules, app_log_time, app_log_locale, app_log_size, backup_enabled, last_connected, backup_total_files, backup_total_size, backup_start_time, backup_start_files, last_success, backup_end_files, duration, backup_sent, last_failure, reason, backup_sent_speed, destination, backup_scanning, backup_check_for_deletes, backup_open_files, backup_compression, backup_encryption, backup_data_deduplication, backup_scan_time, backup_scan_interval, backup_frequency, backup_keep_deleted, backup_keep_deleted_minutes, backup_version_last_week, backup_version_ninety_days, backup_version_year, backup_version_previous_year, backup_paths_last_modified, backup_paths, history_log_size, cp_guid_change_time, cp_guid_new, cp_guid_old')
                ->whereSerialNumber($serial_number)
                ->filter()
                ->get()
                ->first()
                ->toArray()
        );
    }
} // End class Crashplan_controller