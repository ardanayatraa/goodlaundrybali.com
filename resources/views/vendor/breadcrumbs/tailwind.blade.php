@unless ($breadcrumbs->isEmpty())
    <nav class="container mx-auto text-right">
        <ol class="inline-flex items-center space-x-2 text-sm text-gray-600">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}" class="text-blue-600 hover:text-blue-800">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="font-medium text-gray-800">
                        {{ $breadcrumb->title }}
                    </li>
                @endif

                @unless($loop->last)
                    <li class="text-gray-500">/</li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
