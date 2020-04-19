<ul class="list-none my-1">
    @foreach ($templates as $key => $template)
        @if (is_string($key) && $key != 'path' && $key != 'name' && is_array($template))
            {{-- Top level directory: Heading is shown. --}}
            <li class="py-3">
                <h2 class="text-lg text-gray-900 font-bold antialiased">{{ ucwords($key) }}</h2>
                @include('frontend::frontend/templates', ['templates' => $template]) 
            </li>
        @else
            {{-- Above top level: Link is shown. --}}
            @include('frontend::frontend/sub', ['template' => $template])
        @endif
    @endforeach
</ul>
