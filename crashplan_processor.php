<?php

use CFPropertyList\CFPropertyList;
use munkireport\processors\Processor;

class Crashplan_processor extends Processor
{
    public function run($data)
    {
        // Check if we have data
		if ( ! $data){
			throw new Exception("Error Processing Request: No property list found", 1);
        } else if (substr( $data, 0, 30 ) == '<?xml version="1.0" encoding="' ) { // If plist/xml based, process with new xml based handler

            // Delete previous set
            Crashplan_model::where('serial_number', $this->serial_number)->delete();

            $parser = new CFPropertyList();
            $parser->parse($data, CFPropertyList::FORMAT_XML);
            $mylist = $parser->toArray();

            $model = Crashplan_model::firstOrNew(['serial_number' => $this->serial_number]);

            $model->fill($mylist);
            $model->save();

        } else { // Else process with old txt based handler
            throw new Exception("Error Processing Request: CrashPlan module needs updated on client", 1);
        }
    }   
}
