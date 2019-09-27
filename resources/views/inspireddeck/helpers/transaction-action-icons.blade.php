<span class="fa-layers fa-fw">
    <i class="fas fa-circle"></i>
    @if ($action === 'activation')
        <i class="fas fa-power-off icon" data-fa-transform="shrink-8"></i>
    @elseif ($action === 'balance')
        <i class="fas fa-credit-card icon" data-fa-transform="shrink-8"></i>
    @elseif ($action === 'credit')
        <i class="fas fa-arrow-up icon" data-fa-transform="shrink-8"></i>
    @elseif ($action === 'debit')
        <i class="fas fa-arrow-down icon" data-fa-transform="shrink-8"></i>
    @elseif ($action === 'generate')
        <i class="fas fa-cogs icon" data-fa-transform="shrink-8"></i>
    @elseif ($action === 'import')
        <i class="fas fa-file-import icon" data-fa-transform="shrink-8"></i>
    @elseif ($action === 'issue')
        <i class="fas fa-hand-paper icon" data-fa-transform="shrink-8"></i>
    @else
        <i class="fas fas fas fa-credit-card icon" data-fa-transform="shrink-8"></i>
    @endif
    <span class="fa-layers-counter fa-layers-bottom-right action-status {{ $action }}"></span>
</span>