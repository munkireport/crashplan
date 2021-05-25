<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class CrashplanMoreColumns extends Migration
{
    private $tableName = 'crashplan';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {

            // New columns
            $table->bigInteger('app_log_time')->nullable();
            $table->string('app_log_locale')->nullable();
            $table->bigInteger('app_log_size')->nullable();
            $table->string('cp_version')->nullable();
            $table->string('org_type')->nullable();
            $table->boolean('license_authorized')->nullable();
            $table->text('auth_rules')->nullable();
            $table->text('license_model')->nullable();
            $table->text('license_features')->nullable();
            $table->bigInteger('last_connected')->nullable();
            $table->boolean('backup_enabled')->nullable();
            $table->text('backup_paths')->nullable();
            $table->bigInteger('backup_paths_last_modified')->nullable();
            $table->boolean('backup_scanning')->nullable();
            $table->boolean('backup_check_for_deletes')->nullable();
            $table->bigInteger('backup_total_files')->nullable();
            $table->string('backup_total_size')->nullable();
            $table->string('backup_frequency')->nullable();
            $table->boolean('backup_open_files')->nullable();
            $table->string('backup_scan_interval')->nullable();
            $table->string('backup_scan_time')->nullable();
            $table->boolean('backup_compression')->nullable();
            $table->boolean('backup_encryption')->nullable();
            $table->string('backup_data_deduplication')->nullable();
            $table->boolean('backup_keep_deleted')->nullable();
            $table->string('backup_keep_deleted_minutes')->nullable();
            $table->string('backup_version_last_week')->nullable();
            $table->string('backup_version_ninety_days')->nullable();
            $table->string('backup_version_year')->nullable();
            $table->string('backup_version_previous_year')->nullable();
            $table->bigInteger('backup_start_time')->nullable();
            $table->string('backup_start_files')->nullable();
            $table->string('backup_end_files')->nullable();
            $table->string('backup_sent')->nullable();
            $table->string('backup_sent_speed')->nullable();
            $table->bigInteger('cp_guid_change_time')->nullable();
            $table->string('cp_guid_old')->nullable();
            $table->string('cp_guid_new')->nullable();
            $table->bigInteger('history_log_size')->nullable();
            $table->bigInteger('auth_date')->nullable();
            $table->string('org_name')->nullable();
            $table->string('guid')->nullable();
            $table->string('cp_username')->nullable();
            
            // Create indexes for new columns
            $table->index('app_log_time');
            $table->index('app_log_locale');
            $table->index('cp_version');
            $table->index('org_type');
            $table->index('license_authorized');
            $table->index('last_connected');
            $table->index('backup_enabled');
            $table->index('backup_paths_last_modified');
            $table->index('backup_scanning');
            $table->index('backup_check_for_deletes');
            $table->index('backup_total_files');
            $table->index('backup_total_size');
            $table->index('backup_frequency');
            $table->index('backup_open_files');
            $table->index('backup_scan_interval');
            $table->index('backup_scan_time');
            $table->index('backup_compression');
            $table->index('backup_encryption');
            $table->index('backup_data_deduplication');
            $table->index('backup_keep_deleted');
            $table->index('backup_keep_deleted_minutes');
            $table->index('backup_version_last_week');
            $table->index('backup_version_ninety_days');
            $table->index('backup_version_year');
            $table->index('backup_version_previous_year');
            $table->index('app_log_size');
            $table->index('backup_start_time');
            $table->index('backup_start_files');
            $table->index('backup_end_files');
            $table->index('backup_sent');
            $table->index('backup_sent_speed');
            $table->index('cp_guid_change_time');
            $table->index('cp_guid_old');
            $table->index('cp_guid_new');
            $table->index('history_log_size');
            $table->index('auth_date');
            $table->index('org_name');
            $table->index('guid');
            $table->index('cp_username');
            
        });
     }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            
            // Remove new columns
            $table->dropColumn('app_log_time');
            $table->dropColumn('app_log_locale');
            $table->dropColumn('app_log_size');
            $table->dropColumn('cp_version');
            $table->dropColumn('org_type');
            $table->dropColumn('license_authorized');
            $table->dropColumn('auth_rules');
            $table->dropColumn('license_model');
            $table->dropColumn('license_features');
            $table->dropColumn('last_connected');
            $table->dropColumn('backup_enabled');
            $table->dropColumn('backup_paths');
            $table->dropColumn('backup_paths_last_modified');
            $table->dropColumn('backup_scanning');
            $table->dropColumn('backup_check_for_deletes');
            $table->dropColumn('backup_total_files');
            $table->dropColumn('backup_total_size');
            $table->dropColumn('backup_frequency');
            $table->dropColumn('backup_open_files');
            $table->dropColumn('backup_scan_interval');
            $table->dropColumn('backup_scan_time');
            $table->dropColumn('backup_compression');
            $table->dropColumn('backup_encryption');
            $table->dropColumn('backup_data_deduplication');
            $table->dropColumn('backup_keep_deleted');
            $table->dropColumn('backup_keep_deleted_minutes');
            $table->dropColumn('backup_version_last_week');
            $table->dropColumn('backup_version_ninety_days');
            $table->dropColumn('backup_version_year');
            $table->dropColumn('backup_version_previous_year');
            $table->dropColumn('backup_start_files');
            $table->dropColumn('backup_complete_time');
            $table->dropColumn('backup_end_files');
            $table->dropColumn('backup_sent');
            $table->dropColumn('backup_sent_speed');
            $table->dropColumn('cp_guid_change_time');
            $table->dropColumn('cp_guid_old');
            $table->dropColumn('cp_guid_new');
            $table->dropColumn('history_log_size');
            $table->dropColumn('auth_date');
            $table->dropColumn('org_name');
            $table->dropColumn('guid');
            $table->dropColumn('cp_username');
        });
    }
}