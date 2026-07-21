<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(
        public ?string $title = null,
        public string $activeNav = 'beranda',
        public ?string $backUrl = null,
        public bool $hideHeader = false
    ) {}

    public function render(): View
    {
        return view('layouts.app');
    }
}
