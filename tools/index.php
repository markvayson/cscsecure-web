<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load local tools metadata
$dataFile = __DIR__ . '/data/tools_data.json';
$localData = [];
if (file_exists($dataFile)) {
    $localData = json_decode(file_get_contents($dataFile), true);
}

// Extract data for CST tool with fallbacks
$cstData = $localData['markvayson/CST'] ?? [
    'latest' => 'v4.1.0',
    'date' => 'Aug 02, 2026',
    'download_url' => 'downloads/CSCsecure.exe',
    'versions' => ['v4.1.0' => '#']
];

$tools_list = [
    [
        'name' => 'CSCsecure',
        'latest_version' => $cstData['latest'],
        'category' => 'Security Compliance',
        'description' => 'Standalone Windows desktop security utility for IT hardening and compliance with Abu Dhabi Healthcare Information and Cyber Security standards. Built with PowerShell, C++, and XAML.',
        'date' => $cstData['date'],
        'repo_url' => 'https://github.com/markvayson/CST',
        'download_url' => $cstData['download_url'],
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'theme' => [
            'bg' => 'bg-indigo-600',
            'text' => 'text-indigo-600',
            'light_bg' => 'bg-indigo-50',
            'border' => 'border-indigo-100',
            'shadow' => 'shadow-indigo-500/20'
        ],
        'versions' => $cstData['versions']
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