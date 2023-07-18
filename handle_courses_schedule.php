<?php
$row = 1;
$schedule_array = array();
if (($handle = fopen("courses_schedule_220811.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row == 1) {
            $schedule_array['cols'] = $data;
        } else {
            $schedule_array[$data[0]] = $data;
        }
        $row++;
    }
    fclose($handle);
}
echo json_encode($schedule_array, JSON_HEX_QUOT | JSON_HEX_TAG);