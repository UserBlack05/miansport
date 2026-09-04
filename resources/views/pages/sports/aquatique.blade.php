@extends('layouts.app')

@section('title', 'MianSport — SPORTS AQUATIQUES & NAUTIQUE')

@section('content')
<div class="wrap">
    <div class="pagehead" style="padding-top:34px;margin-bottom:34px;">
        <div class="eyebrow">Tous les sports</div>
        <h1>SPORTS AQUATIQUES & NAUTIQUE</h1>
    </div>

    <!-- Main Article + Sidebar Feed -->
    <div class="au-grid">
        <div class="au-main">
            <div class="cov-wrap" style="aspect-ratio:4/3;">
                <span class="cov-tag">SPORTS AQUATIQUES & NAUTIQUE</span>
                <img src="{{ asset($mainArticle['image'] ?? '') }}" alt="{{ $mainArticle['alt'] }}">
            </div>
            <div style="margin-top:20px;">
                <span class="fdl-cat">SPORTS AQUATIQUES & NAUTIQUE</span>
            <a class='lien' style='color:black' href="{{route('articles.show',$mainArticle['slug'])}}">
                <h2 style="font-weight:800;font-size:26px;margin:8px 0 12px;line-height:1.2;">{{ $mainArticle['titre'] }}</h2>
                <p style="color:var(--ardoise);font-size:14.5px;line-height:1.7;">{{ $mainArticle['description'] }}</p>
            </a>
            </div>
        </div>


        <div class="au-list" style="padding-left:36px;border-left:1px solid var(--ligne);">
            <div class="fdl-head">Fil d'actualité — SPORTS AQUATIQUES & NAUTIQUE</div>
            <div class="fdl">
                @foreach($feedItems as $item)
                <a class="fdl-item" href="{{route('articles.show',$item['slug'])}}">
                    <div class="cov-wrap">
                        <img src="{{ asset($item['image'] ?? '') }}" alt="{{ $item['alt'] }}">
                    </div>
                    <div class="fdl-text">
                        <span class="fdl-cat">SPORTS AQUATIQUES & NAUTIQUE</span>
                        <h4>{{ $item['titre'] }}</h4>
                    </div>
                    <span class="fdl-time">{{ $item['time'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>


    <!-- Full Feed Grid -->
    <div style="padding:10px 0 60px;border-top:1px solid var(--ligne);">
        <div class="fdl-head">Fil d'actualité complet — SPORTS AQUATIQUES & NAUTIQUE</div>
        <div class="fdg-grid">
            @foreach($fullFeedItems as $item)
            <a class="fdg-item" href="{{route('articles.show',$item['slug'])}}">
                <div class="cov-wrap">
                    <img src="{{ asset($item['image'] ?? '') }}" alt="{{ $item['alt'] }}">
                </div>
                <div>
                    <span class="fdl-cat">SPORTS AQUATIQUES & NAUTIQUE</span>
                    <h4>{{ $item['titre'] }}</h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('page-styles')
<style>
    /* Pagehead */
    .pagehead{padding:48px 0 8px;border-bottom:3px solid var(--encre);margin-bottom:44px;}
    .pagehead .eyebrow{color:var(--rouge);font-weight:800;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:10px;}
    .pagehead h1{font-family:'Anton',sans-serif;font-size:48px;text-transform:uppercase;margin-bottom:16px;}
    .pagehead p{color:var(--ardoise);font-size:15px;max-width:560px;margin-bottom:30px;}

    /* Cov wrap */
    .cov-wrap{position:relative;overflow:hidden;}
    .cov-wrap img{width:100%;height:100%;object-fit:cover;display:block;}
    .cov-tag{position:absolute;top:12px;left:12px;background:var(--rouge);color:#fff;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.6px;padding:6px 14px;z-index:2;}

    /* À la une grid */
    .au-grid{display:grid;grid-template-columns:1.4fr 1fr;gap:0;padding-bottom:50px;}
    .au-main{padding-right:36px;border-right:1px solid var(--ligne);}
    .au-main .cov-wrap{aspect-ratio:4/3;}
    .au-list{padding-left:36px;display:flex;flex-direction:column;}

    /* Fil d'actualité */
    .fdl{display:flex;flex-direction:column;}
    .fdl-item{display:flex;align-items:center;gap:14px;padding:13px 0;border-bottom:1px solid var(--ligne);text-decoration:none;color:inherit;transition:background 0.2s ease;padding-left:4px;padding-right:4px;border-radius:4px;}
    .fdl-item:hover{background:rgba(200,29,37,0.05);}
    .fdl-item .cov-wrap{flex:0 0 74px;height:74px;border-radius:4px;overflow:hidden;}
    .fdl-item .cov-wrap img{width:100%;height:100%;object-fit:cover;display:block;}
    .fdl-text{flex:1;min-width:0;}
    .fdl-cat{color:var(--rouge);font-weight:800;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;}
    .fdl-text h4{font-weight:800;font-size:14px;line-height:1.3;margin-top:4px;}
    .fdl-time{color:var(--ardoise);font-size:12px;white-space:nowrap;}
    .fdl-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:16px;font-weight:800;font-size:19px;}

    /* Grid 2x2 */
    .rg-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
    .rg-item{display:flex;gap:12px;text-decoration:none;color:inherit;transition:background 0.2s ease;padding:4px 4px 4px 0;border-radius:4px;}
    .rg-item:hover{background:rgba(200,29,37,0.05);}
    .rg-item .cov-wrap{flex:0 0 90px;height:74px;border-radius:4px;overflow:hidden;}
    .rg-item .cov-wrap img{width:100%;height:100%;object-fit:cover;display:block;}
    .rg-item h4{font-weight:800;font-size:13.5px;line-height:1.3;}
    .rg-item .fdl-cat{display:block;margin-bottom:4px;}

    /* Vidéos */
    .vgrid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
    .vcard{text-decoration:none;color:inherit;display:block;transition:transform 0.3s ease;}
    .vcard:hover{transform:translateY(-4px);}
    .vcard .vthumb{position:relative;aspect-ratio:16/9;overflow:hidden;margin-bottom:12px;border-radius:4px;}
    .vcard .vthumb img{width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.75);}
    .vcard .vthumb .ph{width:100%;height:100%;}
    .vcard h3{font-size:14.5px;font-weight:700;line-height:1.3;margin-bottom:4px;}
    .vcard .vmeta{color:var(--ardoise);font-size:12px;}
    .vplaybtn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:46px;height:46px;background:var(--rouge);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;transition:transform 0.3s ease,background 0.3s ease;}
    .vcard:hover .vplaybtn{transform:translate(-50%,-50%) scale(1.1);background:#a0161d;}
    .vduration{position:absolute;bottom:8px;right:8px;background:rgba(20,16,14,0.85);color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:3px;}
    .vcattag{position:absolute;top:10px;left:10px;background:var(--or);color:var(--encre);font-size:10.5px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;padding:3px 9px;border-radius:2px;z-index:2;}

    /* Fil d'actualité complet en grille */
    .fdg-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
    .fdg-item{display:flex;gap:16px;align-items:center;text-decoration:none;color:inherit;padding:8px;border-radius:4px;transition:background 0.2s ease;}
    .fdg-item:hover{background:rgba(200,29,37,0.05);}
    .fdg-item .cov-wrap{flex:0 0 130px;height:130px;border-radius:4px;overflow:hidden;}
    .fdg-item .cov-wrap img{width:100%;height:100%;object-fit:cover;display:block;}
    .fdg-item h4{font-weight:800;font-size:15px;line-height:1.3;margin-top:4px;}

    /* Placeholder backgrounds */
    .basket .ph, .ph.basket{background:repeating-linear-gradient(135deg,#8a4a12,#8a4a12 22px,#7a4110 22px,#7a4110 44px);}
    .tennis .ph, .ph.tennis{background:repeating-linear-gradient(90deg,#5b7d2e,#5b7d2e 26px,#4f6d28 26px,#4f6d28 52px);}
    .athle .ph, .ph.athle{background:repeating-linear-gradient(45deg,#2b3a67,#2b3a67 24px,#243158 24px,#243158 48px);}
    .boxe .ph, .ph.boxe{background:repeating-linear-gradient(60deg,#7a1f1f,#7a1f1f 22px,#661a1a 22px,#661a1a 44px);}
    .rugby .ph, .ph.rugby{background:repeating-linear-gradient(100deg,#3d5c3d,#3d5c3d 24px,#324d32 24px,#324d32 48px);}
    .foot .ph, .ph.foot{background:repeating-linear-gradient(120deg,#1d5c3a,#1d5c3a 22px,#17492e 22px,#17492e 44px);}
    .autres .ph, .ph.autres{background:repeating-linear-gradient(70deg,#5c5c5c,#5c5c5c 22px,#4a4a4a 22px,#4a4a4a 44px);}
    .handball .ph, .ph.handball{background:repeating-linear-gradient(130deg,#b5451f,#b5451f 22px,#9c3b1a 22px,#9c3b1a 44px);}
    .volley .ph, .ph.volley{background:repeating-linear-gradient(90deg,#2f6f8f,#2f6f8f 24px,#285d78 24px,#285d78 48px);}

    /* Responsive */
    @media(max-width:1024px){
        .vgrid{grid-template-columns:repeat(2,1fr);}
        .fdg-grid{grid-template-columns:1fr 1fr;}
    }
    @media(max-width:900px){
        .au-grid{grid-template-columns:1fr;gap:30px;}
        .au-main{padding-right:0;border-right:none;}
        .au-list{padding-left:0;border-left:none;}
        .fdg-grid{grid-template-columns:1fr 1fr;}
    }
    @media(max-width:768px){
        .pagehead h1{font-size:36px;}
        .rg-grid{grid-template-columns:1fr;}
        .vgrid{grid-template-columns:1fr 1fr;}
        .fdg-grid{grid-template-columns:1fr;}
        .fdg-item .cov-wrap{flex:0 0 100px;height:100px;}
    }
    @media(max-width:600px){
        .pagehead h1{font-size:28px;}
        .pagehead p{font-size:14px;}
        .vgrid{grid-template-columns:1fr;max-width:400px;margin:0 auto;}
        .au-main .cov-wrap{aspect-ratio:16/9;}
        .fdl-item{padding:10px 4px;gap:12px;}
        .fdl-item .cov-wrap{flex:0 0 56px;height:56px;}
        .fdl-text h4{font-size:13px;}
        .fdl-time{font-size:10px;}
        .rg-item .cov-wrap{flex:0 0 80px;height:64px;}
        .rg-item h4{font-size:13px;}
        .fdg-item .cov-wrap{flex:0 0 80px;height:80px;}
        .fdg-item h4{font-size:14px;}
    }
</style>
@endpush