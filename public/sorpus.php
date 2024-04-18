<?php

include 'main.php';

use simitsdk\phpjasperxml\PHPJasperXML;

if (isset($_GET['type']) && isset($_GET['file'])) {
    $type = $_GET['type'];
    $filedir = $_GET['file'];

    // File path
    $filename = __DIR__.'/templates/'.$filedir;

    // $config = parse_ini_file('konfig.ini');
    $config = [
        'driver' => 'array',
        'data' => [
            ['user_id' => 0, 'fullname' => 'name1', 'email' => 'email1@a.com', 'gender' => 'M'],
        ],
    ];

    // Generate report
    $report = new PHPJasperXML();
    $report->load_xml_file($filename);

    // Loop GET Params
    foreach ($_GET as $key => $value) {
        // Exclude 'type' and 'file' parameters
        if ($key != 'type' && $key != 'file') {
            $report->setParameter([$key => $value]);
        }
    }

    // Set additional parameter
    $report->setParameter(['reporttitle' => 'Database Report With Driver : '.$config['driver']])
        ->setDataSource($config)
        ->export($type);
} else {
    echo 'Type or file parameter is missing.';
}
