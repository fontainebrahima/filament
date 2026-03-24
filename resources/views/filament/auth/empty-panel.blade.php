@php
    $emptyPanelBackgroundImageUrl = filament('filament-auth-ui-enhancer')->getEmptyPanelBackgroundImageUrl();
    $emptyPanelBackgroundImageOpacity = filament('filament-auth-ui-enhancer')->getEmptyPanelBackgroundImageOpacity();
@endphp

<div class="relative flex h-full w-full items-center justify-center overflow-hidden px-6">
    @if($emptyPanelBackgroundImageUrl)
        <div class="absolute inset-0 h-full w-full bg-cover bg-center"
             style="background-image: url('{{ $emptyPanelBackgroundImageUrl }}'); opacity: {{ $emptyPanelBackgroundImageOpacity }}; background-position: center;">
        </div>
    @endif

    <div class="relative z-10 text-center px-6">
        <h2 class="text-4xl font-bold text-white mb-4 drop-shadow-lg">Bienvenue sur notre plateforme</h1>
        <p class="text-xl text-white/90 drop-shadow-md">Nous sommes ravis de vous revoir !</p>
    </div>
</div>
