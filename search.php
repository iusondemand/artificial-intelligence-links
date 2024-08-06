<?php
# for bookmarklet: find links and draw a box on the right. Opens in a new page. No real time search... can you help ? :)

header('Content-Type: application/json');

// Path to the CSV file
$csvFile = 'link.csv';

// Check if the file exists
if (!file_exists($csvFile)) {
    echo json_encode(['error' => 'File not found.']);
    exit;
}

// Get the search term from the query parameter
$search = isset($_GET['q']) ? $_GET['q'] : '';
$search = trim(strip_tags($search));

// Read the file and parse its contents
$rows = file($csvFile);
$delimiter = '|';
$header = ['name', 'url', 'desc']; // Assuming the header is always name, url, desc

$links = [];
foreach ($rows as $row) {
    // Split the row by the delimiter
    $row = explode($delimiter, trim($row));
    if (count($row) === 3) {
        $link = array_combine($header, $row);
        // Check if the search term is in any part of the row
        if (stripos($row[0], $search) !== false || stripos($row[1], $search) !== false || stripos($row[2], $search) !== false) {
            $links[] = ['name' => $link['name'], 'url' => $link['url']];
        }
    }
}

echo json_encode($links);
?>
