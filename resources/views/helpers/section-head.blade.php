<div class="mx-auto flex px-3 py-4 bg-brand-blue-500 text-white border-b-4 border-brand-blue-900 rounded shadow">
    <div class="flex flex-shrink-0 items-center">
        <i class="material-icons text-4xl">{{ $icon ?? 'turned_in' }}</i>
    </div>
    <div class="ml-6 pt-1 w-4/6">
        <h4 class="text-lg leading-tight">{{ $title ?? 'Section Title' }}</h4>
        <p class="text-xs text-brand-blue-200 leading-normal">{{ $description ?? 'Section Description' }}</p>
    </div>
    <div class="hidden md:flex w-2/6 justify-end items-center">
        @if (isset($url) && isset($button))
            <a href="{{ $url ?? '#' }}" class="white-btn py-2 px-4 lg:px-10 shadow font-bold hover:bg-brand-blue-100 hover:border-brand-blue-100">
                {{ $button ?? 'Button' }}
            </a>
        @endif
    </div>
    <div class="flex md:hidden w-2/6 justify-end items-center">
        @if (isset($url) && isset($button))
            <a href="{{ $url ?? '#' }}" class="white-btn py-2 px-4 lg:px-10 shadow font-bold hover:bg-brand-blue-100 hover:border-brand-blue-100 flex items-center">
                <i class="material-icons">airplay</i>
            </a>
        @endif
    </div>
</div>
