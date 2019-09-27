<div class="block w-full text-center py-10">
    @if (isset($icon))
        <i class="material-icons text-brand-blue-500 text-6xl my-5">
            {{ $icon }}
        </i>
    @endif
    @if (isset($heading))
        <h4 class="text-2xl text-brand-blue-500">
            {{ $heading }}
        </h4>
    @endif
    @if (isset($description))
        <p class="text-gray-500 text-sm mb-5">
            {{ $description }}
        </p>
    @endif
    @if (isset($route))
        <div class="mt-5">
            <a href="{{ $route }}" class="brand-btn">{{ $button ?? 'Create' }}</a>
        </div>
    @endif
</div>
