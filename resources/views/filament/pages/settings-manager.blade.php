<x-filament-panels::page>
    @php
        $stats = $this->getOverviewStats();
    @endphp

    <div class="space-y-6">
        <div class="fi-section-content-ctn rounded-3xl border border-gray-200 bg-white/95 shadow-sm backdrop-blur dark:border-gray-800 dark:bg-gray-900/90">
            <div class="p-6">
                <form id="settings-manager-form" wire:submit="save" class="space-y-6">
                    {{ $this->form }}
                </form>
            </div>
        </div>
    </div>

    <x-filament-actions::modals />

    <script>
        (() => {
            if (window.__settingsReorderBound) {
                return;
            }

            window.__settingsReorderBound = true;

            let draggedId = null;
            const highlightClass = 'ring-2 ring-[#865749]/45 ring-offset-2 ring-offset-white dark:ring-offset-gray-900';

            const getLivewireComponent = (element) => {
                const host = element?.closest('[wire\\:id]');

                if (! host) {
                    return null;
                }

                return window.Livewire?.find(host.getAttribute('wire:id')) ?? null;
            };

            const clearHighlights = () => {
                document.querySelectorAll('[data-setting-row]').forEach((row) => {
                    row.classList.remove(...highlightClass.split(' '));
                });
            };

            const reorder = (targetRow) => {
                const targetId = Number(targetRow?.getAttribute('data-setting-row') ?? 0);

                if (! draggedId || ! targetId || draggedId === targetId) {
                    return;
                }

                const component = getLivewireComponent(targetRow);

                if (! component) {
                    return;
                }

                component.call('reorderSettings', draggedId, targetId);
            };

            document.addEventListener('dragstart', (event) => {
                const handle = event.target.closest('[data-drag-handle-for]');

                if (! handle) {
                    return;
                }

                draggedId = Number(handle.getAttribute('data-drag-handle-for'));

                if (event.dataTransfer) {
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', String(draggedId));
                }
            }, true);

            document.addEventListener('dragover', (event) => {
                const row = event.target.closest('[data-setting-row]');

                if (! row || ! draggedId) {
                    return;
                }

                event.preventDefault();
                clearHighlights();
                row.classList.add(...highlightClass.split(' '));
            }, true);

            document.addEventListener('drop', (event) => {
                const row = event.target.closest('[data-setting-row]');

                if (! row) {
                    return;
                }

                event.preventDefault();
                reorder(row);
                draggedId = null;
                clearHighlights();
            }, true);

            document.addEventListener('dragend', () => {
                draggedId = null;
                clearHighlights();
            }, true);

            document.addEventListener('pointerdown', (event) => {
                const handle = event.target.closest('[data-drag-handle-for]');

                if (! handle) {
                    return;
                }

                draggedId = Number(handle.getAttribute('data-drag-handle-for'));
            }, true);

            document.addEventListener('pointerup', (event) => {
                const row = event.target.closest('[data-setting-row]');

                if (! row) {
                    draggedId = null;
                    clearHighlights();

                    return;
                }

                reorder(row);
                draggedId = null;
                clearHighlights();
            }, true);
        })();
    </script>
</x-filament-panels::page>
