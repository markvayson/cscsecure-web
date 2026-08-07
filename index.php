<?php
// 1. Fetch GitHub Releases via cPanel Server (Bypasses facility firewall blocks)
$repo = 'markvayson/CST';
$api_url = "https://api.github.com/repos/$repo/releases";

// GitHub requires a User-Agent header
$options = [
    'http' => [
        'method' => "GET",
        'header' => "User-Agent: Comtech-Server-App\r\n"
    ]
];
$context = stream_context_create($options);
$response = @file_get_contents($api_url, false, $context);

$releases = [];
if ($response) {
    $releases = json_decode($response, true);
}

// 2. Define data for the Hero Section (Latest Release)
$latest = $releases[0] ?? null;
$latest_version = $latest ? htmlspecialchars($latest['tag_name']) : 'v1.0.0';
$latest_date = $latest ? date("M d, Y", strtotime($latest['published_at'])) : date("M d, Y");

$latest_download = 'CSCsecure.exe'; // Fallback
if ($latest) {
    foreach ($latest['assets'] as $asset) {
        if (pathinfo($asset['name'], PATHINFO_EXTENSION) === 'exe') {
            $latest_download = $asset['browser_download_url'];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download CSCsecure - Comtech Systems</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            800: '#0f172a',
                            900: '#0a1128',
                            950: '#060a17',
                        },
                        brand: {
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header & Hero Section -->
    <div class="bg-navy-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b15_1px,transparent_1px),linear-gradient(to_bottom,#1e293b15_1px,transparent_1px)] bg-[size:24px_24px]"></div>

        <!-- Navigation Bar -->
        <header class="relative z-10 border-b border-slate-800 max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-brand-600/40">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-extrabold text-lg tracking-tight text-white block leading-none">CSCsecure</span>
                    <span class="text-[11px] text-slate-400 font-medium tracking-wide">Powerful. Lightweight. Reliable.</span>
                </div>
            </div>

            <!-- Action Button -->
            <div>
                <a href="https://github.com/markvayson/CST" target="_blank" class="inline-flex items-center gap-2 bg-slate-800/80 hover:bg-slate-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg border border-slate-700 transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                    </svg>
                    View on GitHub
                </a>
            </div>
        </header>

        <!-- Hero Content Banner -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-12 md:py-16 grid lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-brand-600/20 border border-brand-500/30 flex items-center justify-center text-brand-500 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Download CSCsecure</h1>
                        <p class="text-slate-400 text-sm md:text-base mt-1">Get the latest version or explore previous releases.</p>
                    </div>
                </div>
            </div>

            <!-- Dynamic Latest Card -->
            <div class="lg:col-span-5 bg-white text-slate-800 rounded-2xl p-6 shadow-2xl border border-slate-100 flex flex-col justify-between space-y-6">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="inline-block bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider mb-2">
                            Latest
                        </span>
                        <div class="flex items-center gap-2">
                            <h2 class="text-3xl font-black text-slate-900"><?php echo $latest_version; ?></h2>
                        </div>
                    </div>
                    <a href="<?php echo $latest_download; ?>" download class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-lg transition flex items-center gap-2">
                        Download <?php echo $latest_version; ?>
                    </a>
                </div>
                <div class="text-xs text-slate-500 border-t border-slate-100 pt-4">
                    <span>Released: <?php echo $latest_date; ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Body -->
    <main class="max-w-7xl mx-auto px-6 py-12 w-full grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Dynamic GitHub Releases List -->
        <div class="lg:col-span-8 space-y-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">All Releases</h2>
                <p class="text-slate-500 text-sm mt-1">Full history synced directly from GitHub.</p>
            </div>

            <?php if (empty($releases)): ?>
                <div class="bg-white rounded-2xl border p-6 text-center text-slate-500">
                    No releases found or unable to connect to GitHub.
                </div>
            <?php else: ?>
                <!-- PHP Loop through releases -->
                <?php foreach (array_slice($releases, 0, 5) as $index => $release): 
                    $version = htmlspecialchars($release['tag_name']);
                    $date = date("M d, Y", strtotime($release['published_at']));
                    $is_latest = ($index === 0);
                    
                    // Extract EXE download and size
                    $download_url = $release['html_url'];
                    $file_size = "N/A";
                    foreach ($release['assets'] as $asset) {
                        if (pathinfo($asset['name'], PATHINFO_EXTENSION) === 'exe') {
                            $download_url = $asset['browser_download_url'];
                            $file_size = round($asset['size'] / 1048576, 1) . " MB";
                            break;
                        }
                    }

                    // Format GitHub Markdown Body into list items
                    $notes = strip_tags($release['body']);
                    $lines = explode("\n", $notes);
                ?>
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition">
                    <div class="grid md:grid-cols-12 gap-6 items-start">
                        
                        <div class="md:col-span-3 space-y-1">
                            <h3 class="text-2xl font-black text-brand-600"><?php echo $version; ?></h3>
                            <p class="text-xs text-slate-400"><?php echo $date; ?></p>
                            <?php if($is_latest): ?>
                                <span class="inline-block bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded mt-2">Latest</span>
                            <?php endif; ?>
                        </div>

                        <div class="md:col-span-5 space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700">Release Notes</h4>
                            <ul class="text-xs text-slate-600 space-y-1.5 list-disc list-inside line-clamp-4">
                                <?php 
                                foreach($lines as $line) {
                                    $line = trim(str_replace(['-', '*'], '', $line));
                                    if(!empty($line)) {
                                        echo "<li>" . htmlspecialchars($line) . "</li>";
                                    }
                                }
                                ?>
                            </ul>
                            <div class="pt-2 flex items-center gap-4 text-[11px] text-slate-400 font-medium">
                                <span>Windows Executable</span>
                                <span>•</span>
                                <span><?php echo $file_size; ?></span>
                            </div>
                        </div>

                        <div class="md:col-span-4 flex flex-col items-end justify-between h-full space-y-4">
                            <a href="<?php echo $download_url; ?>" download class="w-full <?php echo $is_latest ? 'bg-brand-600 text-white hover:bg-brand-700' : 'border border-brand-600 text-brand-600 hover:bg-brand-50'; ?> font-bold text-xs py-2.5 px-4 rounded-xl shadow transition text-center flex items-center justify-center gap-2">
                                Download <?php echo $version; ?>
                            </a>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <!-- Right Column -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-slate-900 text-sm">System Requirements</h3>
                </div>
                <ul class="text-xs text-slate-600 space-y-3 pt-2">
                    <li>Windows 10 or later (64-bit)</li>
                    <li>PowerShell Administrative Access</li>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>