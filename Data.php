<?php
class Data
{
  private static $file = 'file.json';

  public static function getData()
  {
    $json = file_get_contents(self::$file);
    return json_decode($json, true);
  }

  public static function saveData($data)
  {
    $json = json_encode($data);
    file_put_contents(self::$file, $json);
  }

  public static function getSortedData()
  {
    $data = self::getData();

    $combined = array_map(null, $data['brands'], $data['growthPercentages']);
    usort($combined, function ($a, $b) {
      return $b[1] <=> $a[1];
    });

    $data['brands'] = array_column($combined, 0);
    $data['growthPercentages'] = array_column($combined, 1);

    return $data;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $index = $_POST['index'];
  $values = $_POST['growthPercentages'];

  $data = Data::getSortedData();
  $data['growthPercentages'][$index] = (float)$values;
  Data::saveData($data);

  echo json_encode(['status' => 'success']);
}
