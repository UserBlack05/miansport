@extends('layouts.app')

@section('title', 'MianSport — Vidéos')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <div class="eyebrow">Mian Sports en images</div>
        <h1>Vidéos</h1>
        <p>Interviews, résumés de matchs et immersions — retrouvez toute notre production vidéo, à la une sur notre chaîne YouTube.</p>
    </div>

    <!-- Featured Video -->
    <div class="featured">
        <img src="{{ asset('images/' . $featuredVideo['image'] . '.jpg') }}" alt="{{ $featuredVideo['alt'] }}">
        <span class="bigplay">▶</span>
        <div class="featured-info">
            <div>
                <span class="tag">{{ $featuredVideo['category'] }}</span>
                <h2>{{ $featuredVideo['title'] }}</h2>
            </div>
        </div>
        <span class="duration">{{ $featuredVideo['duration'] }}</span>
    </div>

    <!-- Filters -->
    <div class="filters" style="margin-bottom:36px;">
        @foreach($filters as $filter)
            <button class="fchip {{ $filter['active'] ? 'on' : '' }}">
                {{ $filter['label'] }}
            </button>
        @endforeach
    </div>

    <!-- Video Grid -->
    <div class="sect-head">
        <h2>Toutes les vidéos</h2>
        <a href="https://www.youtube.com/@mian_media">S'abonner sur YouTube →</a>
    </div>

    <div class="vgrid">
        @foreach($videos as $video)
            <div class="vcard {{ $video['placeholder'] }}">
                <div class="vthumb">
                    <span class="cat-tag">{{ $video['category'] }}</span>
                    
                    @if($video['image'])
                        <img src="{{ asset('images/' . $video['image'] . '.jpg') }}" alt="{{ $video['alt'] }}">
                    @else
                        <div class="ph"></div>
                    @endif
                    
                    <span class="playbtn">▶</span>
                    <span class="duration">{{ $video['duration'] }}</span>
                </div>
                <h3>{{ $video['title'] }}</h3>
                <div class="vmeta">{{ $video['category'] }} · {{ $video['date'] }}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('page-styles')
<style>
    /* Pagehead */
    .pagehead{padding:48px 0 8px;border-bottom:3px solid var(--encre);margin-bottom:44px;}
    .pagehead .eyebrow{color:var(--rouge);font-weight:800;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:10px;}
    .pagehead h1{font-family:'Anton',sans-serif;font-size:48px;text-transform:uppercase;margin-bottom:16px;}
    .pagehead p{color:var(--ardoise);font-size:15px;max-width:520px;margin-bottom:30px;}

    /* Featured Video */
    .featured{position:relative;aspect-ratio:21/9;overflow:hidden;margin-bottom:50px;background:var(--encre);}
    .featured img{width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.6);}
    .featured-info{position:absolute;left:36px;right:36px;bottom:30px;display:flex;justify-content:space-between;align-items:flex-end;}
    .featured-info .tag{display:inline-block;background:var(--rouge);color:var(--papier);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;padding:6px 14px;margin-bottom:14px;}
    .featured-info h2{color:var(--papier);font-family:'Anton',sans-serif;font-size:30px;text-transform:uppercase;max-width:600px;line-height:1.05;}
    .featured .bigplay{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:78px;height:78px;background:var(--rouge);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:24px;cursor:pointer;transition:transform 0.3s ease;}
    .featured .bigplay:hover{transform:translate(-50%,-50%) scale(1.1);}
    .featured .duration{position:absolute;right:36px;bottom:30px;background:rgba(20,16,14,0.85);color:#fff;font-size:12px;font-weight:700;padding:4px 10px;border-radius:3px;}

    /* Filters */
    .filters{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:36px;}
    .fchip{border:1.5px solid var(--encre);color:var(--encre);background:none;font-size:13px;font-weight:700;padding:8px 16px;border-radius:999px;cursor:pointer;transition:all 0.2s ease;}
    .fchip:hover{background:var(--encre);color:var(--papier);}
    .fchip.on{background:var(--encre);color:var(--papier);}

    /* Section Head */
    .sect-head{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:32px;border-bottom:3px solid var(--encre);padding-bottom:14px;}
    .sect-head h2{font-size:26px;font-family:'Anton',sans-serif;text-transform:uppercase;}
    .sect-head a{font-size:13px;font-weight:700;color:var(--rouge);text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;}
    .sect-head a:hover{text-decoration:underline;}

    /* Video Grid */
    .vgrid{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-bottom:80px;}
    .vcard{text-decoration:none;color:inherit;display:block;transition:transform 0.3s ease;}
    .vcard:hover{transform:translateY(-4px);}
    .vcard .vthumb{position:relative;aspect-ratio:16/9;overflow:hidden;background:var(--encre);margin-bottom:12px;border-radius:4px;}
    .vcard .vthumb img{width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.7);}
    .vcard .vthumb .ph{width:100%;height:100%;}
    .vcard h3{font-size:15.5px;font-weight:700;line-height:1.3;margin-bottom:6px;}
    .vcard .vmeta{color:var(--ardoise);font-size:12px;}
    .playbtn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:48px;height:48px;background:var(--rouge);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;transition:transform 0.3s ease,background 0.3s ease;}
    .vcard:hover .playbtn{transform:translate(-50%,-50%) scale(1.1);background:#a0161d;}
    .duration{position:absolute;bottom:8px;right:8px;background:rgba(20,16,14,0.85);color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:3px;}
    .cat-tag{position:absolute;top:10px;left:10px;background:var(--or);color:var(--encre);font-size:10.5px;font-weight:800;text-transform:uppercase;letter-spacing:0.6px;padding:3px 9px;border-radius:2px;}

    /* Placeholder backgrounds */
    .basket .ph, .ph.basket{background:repeating-linear-gradient(135deg,#8a4a12,#8a4a12 22px,#7a4110 22px,#7a4110 44px);}
    .tennis .ph, .ph.tennis{background:repeating-linear-gradient(90deg,#5b7d2e,#5b7d2e 26px,#4f6d28 26px,#4f6d28 52px);}
    .athle .ph, .ph.athle{background:repeating-linear-gradient(45deg,#2b3a67,#2b3a67 24px,#243158 24px,#243158 48px);}
    .football .ph, .ph.football{background:repeating-linear-gradient(120deg,#1d5c3a,#1d5c3a 22px,#17492e 22px,#17492e 44px);}

    /* Responsive */
    @media(max-width:1024px){
        .vgrid{grid-template-columns:repeat(2,1fr);}
    }
    @media(max-width:768px){
        .pagehead h1{font-size:36px;}
        .featured-info h2{font-size:22px;}
        .featured .bigplay{width:56px;height:56px;font-size:18px;}
        .featured-info{left:20px;right:20px;bottom:20px;}
    }
    @media(max-width:600px){
        .vgrid{grid-template-columns:1fr;max-width:400px;margin:0 auto 60px;}
        .pagehead h1{font-size:28px;}
        .pagehead p{font-size:14px;}
        .sect-head{flex-direction:column;gap:8px;align-items:flex-start;}
        .filters{justify-content:center;}
        .featured{aspect-ratio:16/9;}
        .featured-info h2{font-size:18px;}
        .featured .bigplay{width:44px;height:44px;font-size:14px;}
        .featured .duration{right:16px;bottom:16px;font-size:10px;}
        .featured-info .tag{font-size:9px;padding:4px 10px;}
    }
</style>
@endpush