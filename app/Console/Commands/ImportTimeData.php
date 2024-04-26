<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InTime;
use App\Models\OutTime;
use Illuminate\Support\Facades\DB;

class ImportTimeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:time-data';

    protected $description = 'Import time data from TXT files';

    public function handle()
    {
        $fileContents = file_get_contents(public_path('out-time.txt'));
$lines = explode("\n", $fileContents);
$header = array_shift($lines);
$fields = explode(',', $header);
$data = [];

foreach ($lines as $lineNumber => $line) {
    // Check if the line is empty or only contains whitespace
    if (empty(trim($line))) {
        continue; // Skip empty lines
    }

    $values = explode(',', $line);
    
    // Check if the number of values matches the number of fields
    if (count($values) !== count($fields)) {
        // Log the error
        error_log("Error parsing line {$lineNumber}: Number of values does not match number of fields.");
        continue; // Skip this line
    }
    
    $values = array_map('trim', $values); // Trim whitespace from each value
    $row = array_combine($fields, $values);
    $data[] = $row;
}

foreach ($data as $row) {
    // Trim whitespace from keys in the $row array
    $row = array_map('trim', $row);

    // Create the OutTime model instance
    OutTime::create([
        'EMP_CODE' => $row['EMP_CODE'],
        'NAME' => $row['NAME'],
        'EMAIL' => $row['EMAIL'],
        'DATE' => $row['DATE'],
        'OUT_TIME' => $row['OUT_TIME'],
    ]);
}

// Parse and store data for InTime model
$fileContents = file_get_contents(public_path('in-time.txt'));
$lines = explode("\n", $fileContents);
$header = array_shift($lines);
$fields = explode(',', $header);
$data = [];

foreach ($lines as $lineNumber => $line) {
    // Check if the line is empty or only contains whitespace
    if (empty(trim($line))) {
        continue; // Skip empty lines
    }

    $values = explode(',', $line);
    
    // Check if the number of values matches the number of fields
    if (count($values) !== count($fields)) {
        // Log the error
        error_log("Error parsing line {$lineNumber}: Number of values does not match number of fields.");
        continue; // Skip this line
    }
    
    $values = array_map('trim', $values); // Trim whitespace from each value
    $row = array_combine($fields, $values);
    $data[] = $row;
}

foreach ($data as $row) {
    // Trim whitespace from keys in the $row array
    $row = array_map('trim', $row);

    // Create the InTime model instance
    InTime::create([
        'EMP_CODE' => $row['EMP_CODE'],
        'NAME' => $row['NAME'],
        'EMAIL' => $row['EMAIL'],
        'DATE' => $row['DATE'],
        'IN_TIME' => $row['IN_TIME'],
    ]);
}
        $this->info('Time data imported successfully.');
    }
}
