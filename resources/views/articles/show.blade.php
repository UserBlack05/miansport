{{-- resources/views/articles/show.blade.php --}}
@extends('layouts.app')
@section('{{ $article->titre }}', 'MianSport — {{$article->categories->nom}}')

@section('content')
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">



    <main class="container">

        {{-- Section label (première catégorie) --}}
        <div class="section-label display">
            {{ $article->categories->first()->nom ?? 'Article' }}
        </div>

        {{-- Titre --}}
        <h1 class="article-title ">{{ $article->titre }}</h1>

        {{-- Meta row --}}
        <div class="meta-row">
            <div class="meta-field">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.5"/>
                    <path d="M5 20c0-4 3.2-6.5 7-6.5s7 2.5 7 6.5"/>
                </svg>
                <span>Auteur : <span class="author-name">{{ $article->author ?? 'MianSport' }}</span></span>
            </div>
            <div class="meta-field">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <rect x="3.5" y="5" width="17" height="15" rx="1.5"/>
                    <line x1="3.5" y1="9.5" x2="20.5" y2="9.5"/>
                    <line x1="8" y1="3" x2="8" y2="7"/>
                    <line x1="16" y1="3" x2="16" y2="7"/>
                </svg>
                <span>{{ $article->datedecreation->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="meta-field">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <circle cx="12" cy="12" r="8.5"/>
                    <path d="M12 7v5l3.5 2"/>
                </svg>
                <span>{{ $article->reading_time ?? 3 }} min de lecture</span>
            </div>
            <div class="meta-field">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <path d="M4 20l1-4.5L15.5 5 19 8.5 8.5 19 4 20z"/>
                    <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"/>
                </svg>
                <span>Modifié le : {{ $article->updated_at->format('d/m/Y') }}</span>
            </div>
        </div>

        {{-- Hero row --}}
        <div class="hero-row">
            <div class="hero-placeholder">
                @if($article->image)
                    <img src="{{ $article->image }}" alt="{{ $article->titre }}">
                @else
                    <span class="fallback-text">Image à la une — [emplacement photo article]</span>
                @endif
            </div>
            <div class="ad-placeholder">
                <div class="eyebrow">ESPACE</div>
                <div class="display">PUBLICITAIRE</div>
            </div>
        </div>

        {{-- Pull quote (description) --}}
        @if($article->description)
            <div class="pull-quote">
                <div class="mark">“</div>
                <p>{{ $article->description }}</p>
            </div>
        @endif

        {{-- Article body --}}
        <div class="article-body">
            {!! $article->content !!}
        </div>

        {{-- Articles similaires --}}
        @if(isset($similarArticles) && $similarArticles->isNotEmpty())
            <div class="related-head">
                <h2 class="display">Articles de la même catégorie</h2>
                
            </div>

            <div class="related-grid">
                @foreach($similarArticles as $similar)
                    <article class="related-card">
                        <div class="card-thumb">
                            @if($similar->image)
                                <img src="{{ $similar->image }}" alt="{{ $similar->titre }}">
                            @else
                                <span class="fallback-text">Vignette article</span>
                            @endif
                        </div>
                        <a href="{{ route('articles.show', $similar->slug) }}" class="title">
                            {{ Str::limit($similar->titre, 80) }}
                        </a>
                    </article>
                @endforeach
            </div>
        @endif

    </main>
@endsection

@push('page-styles')

<style>
        :root {
            --red: #E4032E;
            --black: #0D0D0D;
            --white: #FFFFFF;
            --grey-bg: #F4F4F4;
            --grey-line: #E3E3E3;
            --grey-text: #6B6B6B;
            --placeholder-bg: #DADADA;
            --placeholder-text: #8C8C8C;
        }
        * {box-sizing: border-box;
            margin: 0;
            padding: 0;}
        body {
            font-family: 'Inter', sans-serif;
            color: var(--black);
            background: var(--white);
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        .display {
            font-family: 'Anton', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.01em;
        }

        /* ---- Category pills ---- */
        .pill-row {
            display: flex;
            gap: 12px;
            padding: 20px 32px;
            overflow-x: auto;
            border-bottom: 1px solid var(--grey-line);
        }
        .pill {
            border: 1.5px solid var(--black);
            border-radius: 20px;
            padding: 9px 18px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.03em;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .pill:hover {
            background: var(--black);
            color: var(--white);
        }
        .pill.selected {
            background: var(--black);
            color: var(--white);
        }

        /* ---- Main container ---- */
        .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 32px;
        }

        .section-label {
            font-family: 'Anton', sans-serif;
            font-size: 44px;
            padding: 36px 0 8px;
        }

        .article-title {
            font-size: 38px;
            line-height: 1.15;
            max-width: 900px;
            padding-bottom: 28px;
            font-weight:bold;
        }

        /* ---- Meta row ---- */
        .meta-row {
            display: flex;
            align-items: center;
            gap: 36px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--black);
            flex-wrap: wrap;
        }
        .meta-field {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--placeholder-text);
            font-size: 14px;
        }
        .meta-field svg {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
            stroke: var(--black);
        }
        .meta-field .author-name {
            color: var(--black);
            font-weight: 600;
        }

        /* ---- Hero row ---- */
        .hero-row {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 28px;
            padding: 28px 0 0;
        }
        .hero-placeholder {
            width: 100%;
            aspect-ratio: 16/11;
            background: repeating-linear-gradient(135deg, #E9E9E9, #E9E9E9 12px, #DFDFDF 12px, #DFDFDF 24px);
            border: 1px solid var(--grey-line);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--placeholder-text);
            font-size: 13px;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }
        .hero-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }
        .hero-placeholder .fallback-text {
            position: relative;
            z-index: 1;
        }

        .ad-placeholder {
            background: #EDEDED;
            border: 1px dashed #B9B9B9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 100%;
            min-height: 320px;
            text-align: center;
        }
        .ad-placeholder .eyebrow {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
        .ad-placeholder .display {
            font-size: 30px;
            color: var(--black);
        }

        /* ---- Pull quote ---- */
        .pull-quote {
            display: flex;
            gap: 20px;
            background: #FBF4E4;
            border-left: 6px solid var(--red);
            padding: 26px 30px;
            margin: 32px 0;
        }
        .pull-quote .mark {
            font-family: 'Anton', sans-serif;
            font-size: 44px;
            color: var(--red);
            line-height: 0.6;
            padding-top: 14px;
        }
        .pull-quote p {
            font-style: italic;
            font-size: 17px;
            line-height: 1.6;
            color: #3A3A3A;
            max-width: 820px;
        }

        /* ---- Article body ---- */
        .article-body {
            max-width: 820px;
            padding-bottom: 20px;
        }
        .article-body p {
            font-size: 16px;
            line-height: 1.75;
            margin-bottom: 20px;
        }
        .article-body h3 {
            font-family: 'Anton', sans-serif;
            font-size: 20px;
            margin-bottom: 14px;
            margin-top: 6px;
        }

        /* ---- Related articles ---- */
        .related-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding: 44px 0 22px;
            border-top: 2px solid var(--black);
            margin-top: 20px;
        }
        .related-head h2 {
            font-family: 'Anton', sans-serif;
            font-size: 32px;
        }
        .related-head a {
            font-size: 13px;
            font-weight: 700;
            color: var(--red);
            letter-spacing: 0.02em;
            white-space: nowrap;
        }
        .related-head a:hover {
            text-decoration: underline;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px 24px;
            padding-bottom: 60px;
        }
        .related-card {
            transition: transform 0.2s ease;
        }
        .related-card:hover {
            transform: translateY(-4px);
        }
        .related-card .card-thumb {
            width: 100%;
            aspect-ratio: 4/3;
            background: #E4E4E4;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--placeholder-text);
            font-size: 12px;
            text-align: center;
            padding: 12px;
            margin-bottom: 14px;
            overflow: hidden;
            position: relative;
        }
        .related-card .card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }
        .related-card .card-thumb .fallback-text {
            position: relative;
            z-index: 1;
        }
        .related-card .title {
            font-size: 14.5px;
            font-weight: 600;
            line-height: 1.45;
        }
        .related-card .title:hover {
            color: var(--red);
        }

        @media (max-width: 820px) {
            .hero-row {
                grid-template-columns: 1fr;
            }
            .related-grid {
                grid-template-columns: 1fr 1fr;
            }
            .article-title {
                font-size: 28px;
            }
            .container {
                padding: 0 18px;
            }
            .pill-row {
                padding-left: 18px;
                padding-right: 18px;
            }
        }
        @media (max-width: 560px) {
            .related-grid {
                grid-template-columns: 1fr;
            }
            .meta-row {
                gap: 18px;
            }
            .article-title {
                font-size: 24px;
            }
            .section-label {
                font-size: 32px;
            }
        }
    </style>