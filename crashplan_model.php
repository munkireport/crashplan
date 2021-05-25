<?php

use munkireport\models\MRModel as Eloquent;

class Crashplan_model extends Eloquent
{
    protected $table = 'crashplan';

    protected $fillable = [
        'serial_number',
        'destination',
        'last_success',
        'duration',
        'last_failure',
        'reason',
        'app_log_time',
        'app_log_locale',
        'app_log_size',
        'cp_version',
        'org_type',
        'license_authorized',
        'auth_rules',
        'license_model',
        'license_features',
        'last_connected',
        'backup_enabled',
        'backup_paths',
        'backup_paths_last_modified',
        'backup_scanning',
        'backup_check_for_deletes',
        'backup_total_files',
        'backup_total_size',
        'backup_frequency',
        'backup_open_files',
        'backup_scan_interval',
        'backup_scan_time',
        'backup_compression',
        'backup_encryption',
        'backup_data_deduplication',
        'backup_keep_deleted',
        'backup_keep_deleted_minutes',
        'backup_version_last_week',
        'backup_version_ninety_days',
        'backup_version_year',
        'backup_version_previous_year',
        'backup_start_time',
        'backup_start_files',
        'backup_complete_time',
        'backup_end_files',
        'backup_sent',
        'backup_sent_speed',
        'cp_guid_change_time',
        'cp_guid_old',
        'cp_guid_new',
        'history_log_size',
        'auth_date',
        'org_name',
        'guid',
        'cp_username',
    ];

    public $timestamps = false;
}
