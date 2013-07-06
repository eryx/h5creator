<?php
$projPath = h5creator_proj::path($this->req->proj);
$projInfo = h5creator_proj::info($this->req->proj);
if (!isset($projInfo['projid'])) {
    die("Bad Request");
}

if (!isset($this->req->data) || strlen($this->req->data) == 0) {
    die("The instance does not exist");
}
list($datasetid, $tableid) = explode("/", $this->req->data);

$fsd = $projPath."/data/{$datasetid}.ds.json";
if (!file_exists($fsd)) {
    die("Bad Request");
}
$dataInfo = file_get_contents($fsd);
$dataInfo = json_decode($dataInfo, true);

$fst = $projPath."/data/{$datasetid}_{$tableid}.tbl.json";
if (!file_exists($fst)) {
    die("Bad Request");
}
$tableInfo = file_get_contents($fst);
$tableInfo = json_decode($tableInfo, true);

$fieldtypes = array(
    'int' => 'Integer',
    'uint' => 'Integer - Unsigned',
    'uinti' => 'Integer - Auto Increment',
    'varchar' => 'Varchar',
    'string' => 'Text',
    'timestamp' => 'Unix Timestamp',
    //'blob' => 'blob',
);
$fieldidxs = array(
    '0' => '---',
    '1' => 'Index',
    '2' => 'Primary',
    '3' => 'Unique',
);


$schema = $tableInfo['schema'];

?>

<table class="table table-hover" width="100%">
    <thead>
    <tr>
        <th>Column</th>
        <th>Type</th>
        <th>Index</th>
    </tr>
    </thead>
    <?php
    if (!is_array($schema)) {
        $schema = array();
    }
    foreach ($schema as $v) {
    ?>
      <tr>
          <td><strong><?=$v['name']?></strong></td>
          <td>
              <?php 
              echo $fieldtypes[$v['type']];
              if (intval($v['len']) > 0) {
                  echo " ({$v['len']})";
              }
              ?>
          </td>
          <td><?php echo $fieldidxs[$v['idx']]?></td>
      </tr>
    <?php
    }
    if ($projInfo['projid'] == $dataInfo['projid']) {
    ?>
    <tr>
        <td></td>
        <td><button class="btn" onclick="_data_inlet_schema_edit()">Edit</button></td>
        <td></td>
    </tr>
    <?php } ?> 
</table>
