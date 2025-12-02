<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\View\Components;

use Illuminate\View\Component;
use Shammaa\LaravelMultilingual\Facades\Multilingual;

class LanguageSwitcher extends Component
{
    public array $locales;
    public string $currentLocale;
    public string $view;

    /**
     * Create a new component instance
     */
    public function __construct(?string $view = null)
    {
        $this->currentLocale = app()->getLocale();
        $this->locales = $this->getLocales();
        $this->view = $view ?? 'multilingual::language-switcher';
    }

    /**
     * Get locales with their information
     */
    protected function getLocales(): array
    {
        $locales = [];
        
        foreach (Multilingual::getSupportedLocales() as $locale) {
            $locales[] = [
                'code' => $locale,
                'name' => Multilingual::getLocaleName($locale),
                'flag' => Multilingual::getLocaleFlag($locale),
                'url' => localized_url($locale),
                'is_current' => $locale === $this->currentLocale,
                'is_rtl' => Multilingual::isRtlLocale($locale),
            ];
        }

        return $locales;
    }

    /**
     * Get the view / contents that represent the component
     */
    public function render()
    {
        return view($this->view, [
            'locales' => $this->locales,
            'currentLocale' => $this->currentLocale,
        ]);
    }
}
