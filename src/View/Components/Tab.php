<?php

namespace Mary\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;

class Tab extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $name = null,
        public ?string $label = null,
        public ?string $icon = null
    ) {
        $this->uuid = "mary" . md5(serialize($this));
    }

    public function tabLabel(): string
    {
        return $this->icon
            ? Blade::render("<x-mary-icon name='" . $this->icon . "' class='mr-2 whitespace-nowrap' label='" . $this->label . "' />")
            : $this->label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                    <a
                        class="hidden"
                        :class="{ 'tab-active': selected === '{{ $name }}' }"
                        x-init="tabs.push({ name: '{{ $name }}', label: {{ json_encode($tabLabel()) }} })"
                    ></a>

                    <div x-show="selected === '{{ $name }}'" role="tabpanel" {{ $attributes->class("tab-content py-5 px-1") }}>
                        {{ $slot }}
                    </div>
                HTML;
    }
}
