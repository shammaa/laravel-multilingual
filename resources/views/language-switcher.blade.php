<div class="language-switcher">
    @foreach($locales as $locale)
        <a href="{{ $locale['url'] }}" 
           class="language-switcher__item {{ $locale['is_current'] ? 'is-active' : '' }}"
           hreflang="{{ $locale['code'] }}">
            @if($locale['flag'])
                <span class="language-switcher__flag">{{ $locale['flag'] }}</span>
            @endif
            <span class="language-switcher__name">{{ $locale['name'] }}</span>
        </a>
    @endforeach
</div>
