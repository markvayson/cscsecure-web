<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
    <!-- Left Info -->
    <div class="lg:col-span-5 space-y-3">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl <?= $tool['theme']['bg'] ?> text-white flex items-center justify-center shadow-md <?= $tool['theme']['shadow'] ?>">
                    <?= $tool['icon'] ?>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-900"><?= $tool['name'] ?></h2>
                        <span class="<?= $tool['theme']['light_bg'] ?> <?= $tool['theme']['text'] ?> text-xs font-semibold px-2 py-0.5 rounded-full border <?= $tool['theme']['border'] ?>"><?= $tool['latest_version'] ?></span>
                    </div>
                    <span class="inline-block bg-slate-100 text-slate-600 text-xs px-2 py-0.5 rounded mt-1 font-medium"><?= $tool['category'] ?></span>
                </div>
            </div>
        </div>
        <p class="text-slate-500 text-sm leading-relaxed"><?= $tool['description'] ?></p>
        <div class="flex items-center gap-4 text-xs text-slate-400 pt-1">
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Updated: <?= $tool['date'] ?></span>
        </div>
    </div>

    <!-- Middle: Timeline -->
    <div class="lg:col-span-4 border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 lg:pt-0 lg:pl-8">
        <div class="text-xs font-semibold text-slate-900 uppercase tracking-wider mb-3">Release History</div>
        <div class="relative pl-6 space-y-3 text-sm before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
            <?php 
            $is_first = true;
            foreach($tool['versions'] as $version => $link): 
            ?>
            <div class="relative flex items-center justify-between <?= !$is_first ? 'text-slate-500' : '' ?>">
                <span class="absolute -left-6 top-1.5 w-2.5 h-2.5 rounded-full <?= $is_first ? $tool['theme']['bg'] : 'bg-slate-300' ?> ring-4 ring-white"></span>
                <div class="flex items-center gap-2">
                    <span class="<?= $is_first ? 'font-bold text-slate-800' : 'font-medium text-slate-700' ?>"><?= $version ?></span>
                    <?php if($is_first): ?>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-1.5 py-0.2 rounded">Latest</span>
                    <?php endif; ?>
                </div>
                <a href="<?= $link ?>" target="_blank" class="text-xs <?= $tool['theme']['text'] ?> hover:underline">View details &#x25BE;</a>
            </div>
            <?php 
            $is_first = false;
            endforeach; 
            ?>
        </div>
    </div>

    <!-- Right Actions -->
    <div class="lg:col-span-3 flex flex-col gap-2.5 justify-center">
        <!-- Direct local server download link -->
        <a href="<?= $tool['download_url'] ?>" download class="w-full <?= $tool['theme']['bg'] ?> hover:opacity-90 text-white font-medium px-4 py-2.5 rounded-lg flex items-center justify-center gap-2 text-sm transition-opacity shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Download Latest
        </a>
        <a href="<?= $tool['repo_url'] ?>" target="_blank" class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm transition-colors">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg> View Repository
        </a>
    </div>
</div>