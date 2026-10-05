<button type="button" wire:click="exportQrPdf" wire:loading.attr="disabled" wire:target="exportQrPdf"
        aria-label="Descargar QR del torneo en PDF A4" title="Descargar QR del torneo en PDF A4"
        class="{{ $mobile
            ? 'shrink-0 flex flex-col items-center justify-center gap-1 w-12 h-12 rounded-xl bg-primary/5 border border-primary/20 text-primary active:scale-95 disabled:opacity-60'
            : 'inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary/5 text-primary border border-primary/20 text-sm font-semibold hover:bg-primary/10 transition-colors disabled:opacity-60 disabled:cursor-not-allowed' }}">
    <svg wire:loading.remove wire:target="exportQrPdf" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h6v6H3zM15 3h6v6h-6zM3 15h6v6H3zM15 15h2v2h-2zM21 15v3M15 21h3M21 21h.01"/>
    </svg>
    <svg wire:loading wire:target="exportQrPdf" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="4"/>
        <path stroke-linecap="round" stroke-width="4" d="M22 12a10 10 0 00-10-10"/>
    </svg>
    <span wire:loading.remove wire:target="exportQrPdf" class="{{ $mobile ? 'text-[9px] font-bold leading-none' : '' }}">{{ $mobile ? 'QR' : 'Descargar QR' }}</span>
    <span wire:loading wire:target="exportQrPdf" class="{{ $mobile ? 'text-[9px] font-bold leading-none' : '' }}">{{ $mobile ? 'Generando' : 'Generando…' }}</span>
</button>
