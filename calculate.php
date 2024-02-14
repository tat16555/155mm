<?php
function calculate_shooting_parameters($latitude_origin, $longitude_origin, $latitude_target, $longitude_target, $initial_velocity) {
    // คำนวณมุมการยิง
    $delta_latitude = $latitude_target - $latitude_origin;
    $delta_longitude = $longitude_target - $longitude_origin;

    $shooting_angle = rad2deg(atan2($delta_latitude, $delta_longitude));

    // คำนวณองศาในการหันของปืนใหญ่
    $vertical_distance = $delta_latitude;
    $horizontal_distance = $delta_longitude;
    $elevation_angle = rad2deg(atan($vertical_distance / $horizontal_distance));

    // คำนวณระยะเวลาเดินทางของกระสุน
    $horizontal_distance = sqrt($delta_latitude**2 + $delta_longitude**2);
    $travel_time = $horizontal_distance / $initial_velocity;

    // คำนวณแรงตกกระทบ
    $mass_of_bullet = 0.01; // มวลของลูกปืนใหญ่ (kg)
    $initial_speed = $initial_velocity; // ความเร็วเริ่มต้นของลูกปืน (m/s)

    // คำนวณระยะทางที่ลูกปืนเคลื่อนที่ (สมมุติว่าเคลื่อนที่แนวราบ)
    $distance_traveled = $initial_speed * $travel_time;

    // คำนวณความเร็วสุดท้าย
    $final_speed = sqrt($initial_speed**2 + 2 * get_acceleration($initial_speed, $distance_traveled) * $distance_traveled);

    // คำนวณแรงตกกระทบ
    $force_of_impact = $mass_of_bullet * get_acceleration($initial_speed, $distance_traveled);

    // บันทึกข้อมูลลงในไฟล์ txt
    $data = "Latitude of Origin: $latitude_origin\n";
    $data .= "Longitude of Origin: $longitude_origin\n";
    $data .= "Latitude of Target: $latitude_target\n";
    $data .= "Longitude of Target: $longitude_target\n";
    $data .= "Initial Velocity (m/s): $initial_velocity\n";
    $data .= "Shooting Angle: $shooting_angle degrees\n";
    $data .= "Elevation Angle: $elevation_angle degrees\n";
    $data .= "Travel Time: $travel_time seconds\n";
    $data .= "Final Speed: $final_speed m/s\n";
    $data .= "Force of Impact: $force_of_impact N\n\n";

    $filename = 'calculation_results.txt';
    file_put_contents($filename, $data, FILE_APPEND);

    return array($shooting_angle, $elevation_angle, $travel_time, $force_of_impact);
}

function get_acceleration($initial_speed, $distance_traveled) {
    // คำนวณความเร็วที่เปลี่ยนแปลง
    $change_in_speed = $initial_speed; // ปรับจาก $final_speed เป็น $initial_speed

    // คำนวณความเร่ง
    $acceleration = $change_in_speed / $distance_traveled;

    return $acceleration;
}
?>
