<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dataFile = __DIR__ . '/data/tools_data.json';
$localData = [];
if (file_exists($dataFile)) {
    $localData = json_decode(file_get_contents($dataFile), true) ?? [];
}

// Extract CST tool data with safe key fallbacks
$cstData = $localData['markvayson/CST'] ?? [];

$latestVersion   = $cstData['latest'] ?? 'v4.1.0';
$updatedDate     = $cstData['date'] ?? 'Aug 02, 2026';
$downloadUrl     = $cstData['download_url'] ?? 'downloads/CSCsecure-v4.1.0.exe';
$repoDescription = $cstData['description'] ?? $cstData['repo_description'] ?? 'Standalone Windows desktop security utility for IT hardening and compliance with Abu Dhabi Healthcare Information and Cyber Security standards.';
$versions        = $cstData['versions'] ?? [
    'v4.1.0' => [
        'url'   => 'https://github.com/markvayson/CST/releases/tag/v4.1.0',
        'notes' => 'Added multithreaded fast local disk search and FortiGate CLI Telnet management hardening.'
    ]
];

// Extract latest tag release notes safely
$latestNotes = '';
if (!empty($versions) && is_array($versions)) {
    $firstVersion = reset($versions);
    if (is_array($firstVersion) && !empty($firstVersion['notes'])) {
        $latestNotes = $firstVersion['notes'];
    }
}

$tools_list = [
    [
        'name'           => 'CSCsecure',
        'latest_version' => $latestVersion,
        'category'       => 'Security Compliance',
        'description'    => $repoDescription,
        'latest_notes'   => $latestNotes,
        'date'           => $updatedDate,
        'repo_url'       => 'https://github.com/markvayson/CST',
        'download_url'   => $downloadUrl,
  'icon' => '<img src="../assets/tool-icon.png" class="w-full h-full object-contain" alt="CSCsecure Icon">',
   'theme'          => [
            'bg'       => 'bg-indigo-600',
            'text'     => 'text-indigo-600',
            'light_bg' => 'bg-indigo-50',
            'border'   => 'border-indigo-100',
            'shadow'   => 'shadow-indigo-500/20'
        ],
        'versions'       => $versions
    ]
];
?>

<!-- Include Header Component -->
<?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Title & Stats Row -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Tools</h1>
                <p class="text-slate-500 text-sm mt-1">Download our tools and view version history.</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="bg-white border border-slate-200 rounded-xl p-3.5 flex items-center gap-3.5 shadow-sm min-w-[180px]">
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-slate-900 leading-none"><?= count($tools_list) ?></div>
                        <div class="text-xs text-slate-500 mt-1">Tools Available</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tools List Loop -->
        <div class="space-y-6">
            <?php 
            foreach ($tools_list as $tool) {
                include 'tool-card.php'; 
            }
            ?>
        </div>

    </main>

<!-- Include Footer Component -->
<?php include 'footer.php'; ?>