<?php
header("Content-Type: application/json; charset=UTF-8");
echo json_encode(["status" => "ok", "time" => date("Y-m-d H:i:s")]);
