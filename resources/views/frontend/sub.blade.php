<li class="text-sm antialiased py-1">
    <a 
        class="hover:text-blue-600 font-mono align-middle"
        href="{{ $template['path'] }}" 
        title="{{ $template['located'] }}"
    >
        {{ $template['name'] }}
    </a>

    @if (isset($template['description']) && $template['description'])
        <span class="text-xs text-gray-600">({{ $template['description'] }})</span>
    @endif

</li>
