@extends('layouts.app')

@section('title', 'MianSport — Magazines')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <div class="eyebrow">Kiosque Mian Sports</div>
        <h1>Nos magazines</h1>
        <p>Chaque mois, la rédaction revient en profondeur sur les histoires, portraits et enquêtes qui font le sport africain.</p>
    </div>

    <!-- Filters -->
    <div class="filters" style="margin:44px 0 36px;">
        @foreach($filters as $filter)
            <button class="fchip {{ $filter['active'] ? 'on' : '' }}">
                {{ $filter['label'] }}
            </button>
        @endforeach
    </div>

    <!-- Magazine Grid -->
    <div class="maglist">
        @foreach($issues as $issue)
            <div class="issue">
                @if($issue['image'])
                    <img src="{{ asset($issue['image']) }}" alt="{{ $issue['alt'] }}">
                @else
                    <div class="fill" style="background:#241E19; display:flex; align-items:center; justify-content:center;">
                        <span style="font-family:'Anton',sans-serif; color:#4A423A; font-size:13px; text-align:center; padding:0 18px; text-transform:uppercase;">
                            N°{{ $issue['id'] }} — {{ $issue['title'] }}
                        </span>
                    </div>
                @endif
                <div class="issue-info">
                    <div class="no">N°{{ $issue['id'] }}</div>
                    <h4>{{ $issue['title'] }}</h4>
                </div>
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

    /* Filters */
    .filters{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:36px;}
    .fchip{border:1.5px solid var(--encre);color:var(--encre);background:none;font-size:13px;font-weight:700;padding:8px 16px;border-radius:999px;cursor:pointer;transition:all 0.2s ease;}
    .fchip:hover{background:var(--encre);color:var(--papier);}
    .fchip.on{background:var(--encre);color:var(--papier);}

    /* Magazine Grid */
    .maglist{display:grid;grid-template-columns:repeat(4,1fr);gap:26px;margin-bottom:80px;}
    .issue{position:relative;aspect-ratio:3/4;overflow:hidden;box-shadow:0 12px 22px rgba(20,16,14,0.15);cursor:pointer;transition:transform 0.3s ease,box-shadow 0.3s ease;}
    .issue:hover{transform:translateY(-6px);box-shadow:0 18px 34px rgba(20,16,14,0.25);}
    .issue img{width:100%;height:100%;object-fit:cover;filter:brightness(0.68);}
    .issue .fill{width:100%;height:100%;}
    .issue-info{position:absolute;inset:0;padding:16px;display:flex;flex-direction:column;justify-content:space-between;}
    .issue-info .no{color:var(--or);font-weight:800;font-size:11px;letter-spacing:1px;}
    .issue-info h4{color:var(--papier);font-family:'Anton',sans-serif;font-size:19px;text-transform:uppercase;line-height:1.05;}

    /* Responsive */
    @media(max-width:1024px){
        .maglist{grid-template-columns:repeat(3,1fr);}
    }
    @media(max-width:768px){
        .maglist{grid-template-columns:repeat(2,1fr);}
        .pagehead h1{font-size:36px;}
    }
    @media(max-width:480px){
        .maglist{grid-template-columns:1fr;max-width:400px;margin:0 auto 60px;}
        .filters{justify-content:center;}
        .pagehead h1{font-size:28px;}
        .pagehead p{font-size:14px;}
    }
</style>
@endpush