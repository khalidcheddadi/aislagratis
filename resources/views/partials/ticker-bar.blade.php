<div class="ticker-bar" aria-label="Noticias">
    <span class="ticker-label"><i class="fa-solid fa-bolt"></i> Novedades</span>
    <div class="ticker-wrap">
        <div class="ticker-track" id="tickerTrack">
            @foreach(config('aislaplus.ticker') as $item)
                <span class="ticker-item"><i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['text'] }}</span>
                <span class="ticker-sep">◆</span>
            @endforeach
            <span class="ticker-item"><i class="fa-solid fa-phone"></i> Llama ahora: {{ config('aislaplus.phone') }}</span>
            <span class="ticker-sep">◆</span>
        </div>
    </div>
</div>
