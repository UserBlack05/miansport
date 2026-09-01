@extends('layouts.app')

@section('title', 'MianSport — Actualités')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <div class="eyebrow">Tous les sports, en continu</div>
        <h1>Actualités</h1>
        <p>Photos, vidéos et fil d'actualité en continu : toute l'information sportive africaine et internationale, tous domaines confondus.</p>
    </div>

    <!-- Sport Categories -->
    <nav class="sportcats">
        <div class="wrap sportcats-row">
            @foreach($sportCats as $cat)
                <a href="#" class="sc {{ $cat['active'] ? 'on' : '' }}">{{ $cat['label'] }}</a>
            @endforeach
        </div>
    </nav>

    <!-- Highlights -->
    <section class="highlights">
        <div class="sect-head">
            <h2>Articles & Videos</h2>
        </div>
        <div class="hgrid">
            @foreach($highlights as $item)
                <div class="hcard {{ $item['placeholder'] }}">
                    <div class="hthumb">
                        <span class="media-badge {{ $item['type'] === 'video' ? 'video' : '' }}">
                            {{ $item['type'] === 'video' ? 'Vidéo' : 'Photo' }}
                        </span>
                        
                        @if($item['image'])
                            <img src="{{ asset('images/' . $item['image'] . '.jpg') }}" alt="{{ $item['alt'] }}">
                        @else
                            <div class="ph"></div>
                        @endif
                        
                        @if($item['type'] === 'video')
                            <span class="playbtn">▶</span>
                        @endif
                    </div>
                    <span class="cat-eyebrow">{{ $item['category'] }}</span>
                    <h3>{{ $item['title'] }}</h3>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Feed -->
    <section class="feedsect">
        <div class="sect-head">
            <h2>Fil d'actualité</h2>
            <a href="#">Tout afficher →</a>
        </div>
        <div class="feed">
            @foreach($feedItems as $item)
                <a class="feed-item" href="{{ route('actu.show', $item['id']) }}">
                    <div class="feed-thumb">
                        <div class="ph {{ $item['placeholder'] }}"></div>
                    </div>
                    <div class="feed-text">
                        <span class="feed-cat">{{ $item['category'] }}</span>
                        <h4>{{ $item['title'] }}</h4>
                    </div>
                    <span class="feed-time">{{ $item['time'] }}</span>
                </a>
            @endforeach
        </div>
    </section>
</div>
@endsection

@push('page-styles')
<style>
    /* Sport Categories */
    .sportcats{background:var(--papier);border-bottom:1px solid var(--ligne);margin-bottom:40px;}
    .sportcats-row{display:flex;gap:10px;padding:14px 32px;overflow-x:auto;}
    .sc{white-space:nowrap;color:var(--encre);text-decoration:none;font-size:12.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;padding:7px 15px;border:1.5px solid var(--ligne);border-radius:999px;transition:all 0.2s ease;}
    .sc:hover{border-color:var(--encre);}
    .sc.on{background:var(--encre);border-color:var(--encre);color:var(--papier);}

    /* Pagehead */
    .pagehead{padding:48px 0 8px;border-bottom:3px solid var(--encre);margin-bottom:44px;}
    .pagehead .eyebrow{color:var(--rouge);font-weight:800;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:10px;}
    .pagehead h1{font-family:'Anton',sans-serif;font-size:48px;text-transform:uppercase;margin-bottom:16px;}
    .pagehead p{color:var(--ardoise);font-size:15px;max-width:560px;margin-bottom:30px;}

    /* Section Head */
    .sect-head{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:28px;border-bottom:3px solid var(--encre);padding-bottom:14px;}
    .sect-head h2{font-size:26px;font-family:'Anton',sans-serif;text-transform:uppercase;}
    .sect-head a{font-size:13px;font-weight:700;color:var(--rouge);text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;}
    .sect-head a:hover{text-decoration:underline;}

    /* Highlights */
    .highlights{margin-bottom:64px;}
    .hgrid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
    .hcard{transition:transform 0.3s ease;}
    .hcard:hover{transform:translateY(-4px);}
    .hcard .hthumb{position:relative;aspect-ratio:4/3;overflow:hidden;margin-bottom:12px;background:var(--encre);border-radius:4px;}
    .hcard .hthumb img{width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.82);}
    .hcard .hthumb .ph{width:100%;height:100%;}
    .media-badge{position:absolute;top:10px;left:10px;background:rgba(20,16,14,0.75);color:var(--papier);font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;padding:4px 9px;border-radius:3px;z-index:2;}
    .media-badge.video{background:var(--rouge);}
    .hcard .playbtn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:44px;height:44px;background:var(--rouge);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;transition:transform 0.3s ease;}
    .hcard:hover .playbtn{transform:translate(-50%,-50%) scale(1.1);}
    .cat-eyebrow{display:block;color:var(--rouge);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:6px;}
    .hcard h3{font-size:16px;font-weight:700;line-height:1.3;}

    /* Placeholder backgrounds */
    .basket .ph, .ph.basket{background:repeating-linear-gradient(135deg,#8a4a12,#8a4a12 22px,#7a4110 22px,#7a4110 44px);}
    .tennis .ph, .ph.tennis{background:repeating-linear-gradient(90deg,#5b7d2e,#5b7d2e 26px,#4f6d28 26px,#4f6d28 52px);}
    .athle .ph, .ph.athle{background:repeating-linear-gradient(45deg,#2b3a67,#2b3a67 24px,#243158 24px,#243158 48px);}
    .boxe .ph, .ph.boxe{background:repeating-linear-gradient(60deg,#7a1f1f,#7a1f1f 22px,#661a1a 22px,#661a1a 44px);}
    .rugby .ph, .ph.rugby{background:repeating-linear-gradient(100deg,#3d5c3d,#3d5c3d 24px,#324d32 24px,#324d32 48px);}
    .football .ph, .ph.football{background:repeating-linear-gradient(120deg,#1d5c3a,#1d5c3a 22px,#17492e 22px,#17492e 44px);}

    /* Feed */
    .feedsect{margin-bottom:80px;}
    .feed{display:flex;flex-direction:column;}
    .feed-item{display:flex;align-items:center;gap:16px;text-decoration:none;color:inherit;padding:16px 0;border-bottom:1px solid var(--ligne);transition:background 0.2s ease;padding-left:8px;padding-right:8px;border-radius:4px;}
    .feed-item:hover{background:rgba(200,29,37,0.05);}
    .feed-item:first-child{padding-top:0;}
    .feed-thumb{flex:0 0 56px;width:56px;height:56px;border-radius:8px;overflow:hidden;background:var(--encre);}
    .feed-thumb .ph{width:100%;height:100%;}
    .feed-text{flex:1;min-width:0;}
    .feed-cat{display:block;color:var(--rouge);font-size:10.5px;font-weight:800;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:4px;}
    .feed-text h4{font-size:14.5px;font-weight:700;line-height:1.3;}
    .feed-time{flex:0 0 auto;color:var(--ardoise);font-size:12px;white-space:nowrap;}

    /* Responsive */
    @media(max-width:1024px){
        .hgrid{grid-template-columns:repeat(2,1fr);}
    }
    @media(max-width:768px){
        .pagehead h1{font-size:36px;}
        .sportcats-row{padding:10px 16px;gap:8px;}
        .sc{font-size:11px;padding:5px 12px;}
    }
    @media(max-width:600px){
        .pagehead h1{font-size:28px;}
        .pagehead p{font-size:14px;}
        .hgrid{grid-template-columns:1fr;max-width:400px;margin:0 auto;}
        .sect-head{flex-direction:column;gap:8px;align-items:flex-start;}
        .sect-head h2{font-size:22px;}
        .feed-item{padding:12px 4px;gap:12px;}
        .feed-thumb{flex:0 0 44px;width:44px;height:44px;}
        .feed-text h4{font-size:13px;}
        .feed-time{font-size:10px;}
    }
</style>
@endpush