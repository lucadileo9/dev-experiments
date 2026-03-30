@props(['links'])

@if($links && count($links) > 0)
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-4">Related Links</h3>
        <ul class="list-disc list-inside space-y-2">
            @foreach($links as $link)
                <li>
                    <a href="{{ $link }}" target="_blank" class="text-primary hover:underline break-all">{{ $link }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
