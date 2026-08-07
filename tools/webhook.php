<?php
// Define secret key matching your GitHub Webhook Secret
define('WEBHOOK_SECRET', 'Kdc5ea4k$%$%');

// Retrieve raw request payload and signature
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// 1. Verify Webhook Signature
if (!empty(WEBHOOK_SECRET)) {
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, WEBHOOK_SECRET);
    if (!hash_equals($expectedSignature, $signature)) {
        http_response_code(403);
        die('Invalid webhook signature');
    }
}

// 2. Fetch Event Header across different server configurations
$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
if (empty($event) && function_exists('getallheaders')) {
    $headers = array_change_key_case(getallheaders(), CASE_LOWER);
    $event = $headers['x-github-event'] ?? '';
}

// Handle GitHub initial connection test ("ping")
if ($event === 'ping') {
    http_response_code(200);
    die('Pong! Webhook connection verified successfully.');
}

// Only process official release events
if ($event !== 'release') {
    http_response_code(200);
    die("Event ignored: Received '{$event}' event instead of 'release'.");
}

$data = json_decode($payload, true);
$action = $data['action'] ?? '';

// Ignore draft edits; only run when a release is published
if (!in_array($action, ['published', 'edited'])) {
    http_response_code(200);
    die("Action ignored: Received '{$action}' action.");
}

$repoPath = $data['repository']['full_name'] ?? 'markvayson/CST';
$release = $data['release'] ?? [];

$tagName = $release['tag_name'] ?? 'v1.0.0';
$publishedAt = date('M d, Y', strtotime($release['published_at'] ?? 'now'));
$releaseUrl = $release['html_url'] ?? '#';

// Dynamic filename based on version tag (e.g., CSCsecure-v4.1.0.exe)
$customFilename = "CSCsecure-{$tagName}.exe";

// 3. Locate .exe asset link in GitHub payload
$exeDownloadUrl = null;
if (!empty($release['assets'])) {
    foreach ($release['assets'] as $asset) {
        if (pathinfo($asset['name'], PATHINFO_EXTENSION) === 'exe' || stristr($asset['name'], '.exe')) {
            $exeDownloadUrl = $asset['browser_download_url'];
            break;
        }
    }
}

if (!$exeDownloadUrl) {
    http_response_code(400);
    die('Error: No .exe executable found in release assets.');
}

// Ensure required directories exist with write permissions
if (!is_dir(__DIR__ . '/downloads')) {
    mkdir(__DIR__ . '/downloads', 0755, true);
}
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0755, true);
}

// 4. Download executable file to local server
$localDownloadPath = __DIR__ . "/downloads/{$customFilename}";

$ch = curl_init($exeDownloadUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'CSCsecure-Portal');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 300);
$fileData = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 || $fileData === false) {
    http_response_code(500);
    die("Failed to download file from GitHub. HTTP Code: {$httpCode}");
}

file_put_contents($localDownloadPath, $fileData);

// 5. Update local JSON metadata file
$dataFile = __DIR__ . '/data/tools_data.json';
$localData = [];
if (file_exists($dataFile)) {
    $localData = json_decode(file_get_contents($dataFile), true) ?? [];
}

$existingVersions = $localData[$repoPath]['versions'] ?? [];

// Use array union operator (+) so the new tag always prepends and overwrites prior duplicates
$updatedVersions = [$tagName => $releaseUrl] + $existingVersions;
$updatedVersions = array_slice($updatedVersions, 0, 4, true);

$localData[$repoPath] = [
    'latest' => $tagName,
    'date' => $publishedAt,
    'download_url' => "downloads/{$customFilename}",
    'description'  => $repoDescription,
    'versions' => $updatedVersions
];

file_put_contents($dataFile, json_encode($localData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

http_response_code(200);
echo "Webhook executed successfully. Updated tools_data.json and saved file as downloads/{$customFilename}.";

// Download icon to local server automatically
$rawIconUrl = "https://raw.githubusercontent.com/{$repoPath}/master/Comtech%20Tools/cscsecure-icon.png";
$localIconPath = __DIR__ . '/assets/cscsecure-icon.png';

$chIcon = curl_init($rawIconUrl);
curl_setopt_array($chIcon, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT        => 30
]);
$iconData = curl_exec($chIcon);
curl_close($chIcon);

if ($iconData !== false) {
    file_put_contents($localIconPath, $iconData);
}