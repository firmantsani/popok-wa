<?php
echo "\n\nJoin diskusi channel https://t.me/Si_New_Bie\n\n";
system("termux-open https://t.me/+UVL6i3Ec1fpiMzll");
function save($data, $file) {
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }

    $existingData = file_get_contents($file);
    if (strpos($existingData, $data) === false) {
        $handle = fopen($file, 'a+');
        fwrite($handle, $data);
        fclose($handle);
        echo "Data baru telah ditulis ke file.\n";
    } else {
        echo "Data sudah ada di file.\n";
    }
}
function prompt($message) {
    echo $message . ": ";
    $handle = fopen("php://stdin","r");
    $line = fgets($handle);
    return trim($line);
}

function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $length > $i; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomDate($months = 3) {
    $currentDate = new DateTime();
    $maxDate = (clone $currentDate)->modify("+$months months");
    $daysRange = $maxDate->diff($currentDate)->days;
    $randomDays = rand(0, $daysRange);
    $randomDate = (clone $currentDate)->modify("+$randomDays days");
    return $randomDate->format('Y-m-d');
}

function nama() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $ex = curl_exec($ch);
    preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
    $fullName = $name[2][mt_rand(0, 14)];
    $nameParts = explode(' ', $fullName);
    
    if (count($nameParts) > 2) {
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
    } else {
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
    }
    
    return [$firstName, $lastName];
}

function generateEmail($firstName, $lastName) {
    $randomNumber = rand(1000, 9999);
    $email = strtolower($firstName . '.' . $lastName . $randomNumber . '@gmail.com');
    return $email;
}

date_default_timezone_set('Asia/Jakarta');

$phoneNumber = prompt("Masukkan nomor whatsApp aktif(misalnya 085156148047)");

$postalCodes = ['10110', '10220', '10310', '10430', '10570', '10640', '10730', '10820', '10920', '11000'];

$randomPostalCode = $postalCodes[array_rand($postalCodes)];

list($firstName, $lastName) = nama();

$email = generateEmail($firstName, $lastName);

$url = 'https://voucherpopokgratis.paperform.co/api/v1/form/65a4a6386f3e406535030872/submit';
$data = [
    'data' => [
        ['key' => 'femq3', 'value' => $firstName],
        ['key' => '9gmo6', 'value' => $lastName],
        ['key' => 'ae567', 'value' => $email],
        ['key' => '4hfob', 'value' => $phoneNumber],
        ['key' => 'aie5o', 'value' => $randomPostalCode],
        ['key' => '44o9u', 'value' => 'No'],
        ['key' => 'bfgkt'],
        ['key' => 'fj6gn', 'value' => '0 - 3 Bulan'],
        ['key' => '7v97k', 'value' => generateRandomDate(3)],
        ['key' => '9cref', 'value' => ['YA']],
        ['key' => 'eqhjp', 'value' => 'YA'],
        ['key' => 'ernp9', 'value' => 'YA'],
        ['key' => '8ceg8', 'value' => 'YA'],
        ['key' => 'clgs', 'value' => 'SETUJU']
    ],
    'payment' => null,
    'captcha' => null,
    'score' => false,
    'partialSubmissionId' => 'cm3dx05p30000406zuuiufouj',
    'deviceId' => generateRandomString(32)
];

$payload = json_encode($data);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: voucherpopokgratis.paperform.co',
    'Content-Length: ' . strlen($payload),
    'sec-ch-ua-platform: "Android"',
    'x-csrf-token: ',
    'x-xsrf-token: ',
    'sec-ch-ua: "Android WebView";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
    'sec-ch-ua-mobile: ?1',
    'User-Agent: Mozilla/5.0 (Linux; Android 14; M2101K6G Build/UKQ1.230917.001) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.39 Mobile Safari/537.36',
    'Accept: application/json',
    'Content-Type: application/json',
    'x-paperform-visitorid: 1b94ca42a3867e5bce0bb1711b4b25ac',
    'Origin: https://voucherpopokgratis.paperform.co',
    'x-requested-with: mark.via.gp',
    'sec-fetch-site: same-origin',
    'sec-fetch-mode: cors',
    'sec-fetch-dest: empty',
    'Referer: https://voucherpopokgratis.paperform.co/',
    'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
    'priority: u=1, i'
]);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

$responsejson = curl_exec($ch);

if ($responsejson === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    //echo 'Response: ' . $responsejson;
}

curl_close($ch);
$currentDateTime = date('Y-m-d H:i:s');
$url = 'https://voucherpopokgratis.paperform.co/api/v1/form/65a4a6386f3e406535030872/partial';
$data = [
    'data' => [
        ['key' => 'submitted_at', 'value' => $currentDateTime],
        ['key' => 'femq3', 'value' => $firstName],
        ['key' => '9gmo6', 'value' => $lastName],
        ['key' => 'ae567', 'value' => $email],
        ['key' => '4hfob', 'value' => $phoneNumber],
        ['key' => 'aie5o', 'value' => $randomPostalCode],
        ['key' => '44o9u', 'value' => 'No'],
        ['key' => 'bfgkt'],
        ['key' => 'fj6gn', 'value' => '0 - 3 Bulan'],
        ['key' => '7v97k', 'value' => generateRandomDate(3)],
        ['key' => '9cref', 'value' => ['YA']],
        ['key' => 'eqhjp', 'value' => 'YA'],
        ['key' => 'ernp9', 'value' => 'YA'],
        ['key' => '8ceg8', 'value' => 'YA'],
        ['key' => 'clgs', 'value' => 'SETUJU']
    ],
    'partialSubmissionId' => 'cm3dx05p30000406zuuiufouj',
    'last_answered' => 'clgs'
];

$payload = json_encode($data);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: voucherpopokgratis.paperform.co',
    'Content-Length: ' . strlen($payload),
    'sec-ch-ua-platform: "Android"',
    'x-csrf-token: ',
    'x-xsrf-token: ',
    'sec-ch-ua: "Android WebView";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
    'sec-ch-ua-mobile: ?1',
    'User-Agent: Mozilla/5.0 (Linux; Android 14; M2101K6G Build/UKQ1.230917.001) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.39 Mobile Safari/537.36',
    'Accept: application/json',
    'Content-Type: application/json',
    'x-paperform-visitorid: 1b94ca42a3867e5bce0bb1711b4b25ac',
    'Origin: https://voucherpopokgratis.paperform.co',
    'x-requested-with: mark.via.gp',
    'sec-fetch-site: same-origin',
    'sec-fetch-mode: cors',
    'sec-fetch-dest: empty',
    'Referer: https://voucherpopokgratis.paperform.co/',
    'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
    'priority: u=1, i'
]);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    //echo 'Response: ' . $response;
}
$json = $responsejson;

$data = json_decode($json, true);

if ($data === null) {
    echo "JSON tidak valid\n";
} else {
    echo "Title: " . $data["details"]["title"] . "\n";
    echo "Form User ID: " . $data["details"]["form_user_id"] . "\n";
    echo "Form ID: " . $data["details"]["form_id"] . "\n";
    echo "Submission ID: " . $data["details"]["submission_id"] . "\n";
    echo "Submitted At: " . $data["details"]["submitted_at"] . "\n";
    save($data["details"]["title"]."|".$phoneNumber."|".date('d-m-Y')."\n", "popok_proses.txt");
}
curl_close($ch);
?>