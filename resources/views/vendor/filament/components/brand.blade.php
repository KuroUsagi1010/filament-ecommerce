<div
    x-data="{ mode: 'light' }"
    x-on:dark-mode-toggled.window="mode = $event.detail"
>

{{-- CANT MAKE THE SPACES WORK AAA --}}
    <div class="flex items-center" x-show="mode === 'light'">
        <div>
            <img src="{{ asset('logo/brand.svg') }}" alt="Brand Logo">
        </div>
        <p  class="ml-3">E-Commerce</p>
    </div>
 
    <div class="flex items-center" x-show="mode === 'dark'">
        <div class="px-3">
            <img src="{{ asset('logo/brand.svg') }}" alt="Brand Logo">
        </div>
        <p class="ml-3 text-2xl">E-Commerce</p>
    </div>
</div>