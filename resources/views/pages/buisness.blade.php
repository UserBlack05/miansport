@extends('layouts.app')

@section('title', 'MianSport — Accueil')

@section('content')
    
    <div class="category-hero">
        <h1 class="display">SPORT & BUISNESS</h1>
        <p>{{ $category->description ?? "L'économie du sport, les investissements, les mutations des clubs, les droits médias et les carrières." }}</p>
    </div>

    {{-- Main content --}}
    <main class="container">

        {{-- Featured article + sidebar --}}
        @if($mainArticle)
            <div class="featured-row">
                <div class="featured-card">
                    <div class="featured-thumb">
                        @if($mainArticle->image)
                            <img src="{{ $mainArticle->image }}" alt="{{ $mainArticle->titre }}">
                        @else
                            <span class="fallback-text">Image à la une — [emplacement photo article]</span>
                        @endif
                    </div>
                    <div class="featured-body">
                        <span class="tag-categories">
                            @forelse($mainArticle->categories as $cat)
                                {{ strtoupper($cat->nom) }}
                                @if(!$loop->last) • @endif
                            @empty
                                CATÉGORIES
                            @endforelse
                        </span>
                        <h2 class="ecriture">
                            <a href="{{ route('articles.show', $mainArticle->slug) }}">
                                {{ $mainArticle->titre }}
                            </a>
                        </h2>
                        <p>{{ Str::limit($mainArticle->description ?? $mainArticle->excerpt, 160) }}</p>
                    </div>
                </div>

                <div class="sidebar-list">
                    @forelse($feedItems as $sidebar)
                        <div class="side-card">
                            <span class="tag-categories">
                                @forelse($sidebar->categories as $cat)
                                    {{ strtoupper($cat->nom) }}
                                    @if(!$loop->last) • @endif
                                @empty
                                    CATÉGORIES
                                @endforelse
                            </span>
                            <h3 class="ecriture">
                                <a href="{{ route('articles.show', $sidebar->slug) }}">
                                    {{ Str::limit($sidebar->titre, 80) }}
                                </a>
                            </h3>
                        </div>
                    @empty
                        <div class="side-card">
                            <span class="tag-categories">CATÉGORIES</span>
                            <h3 class="display">Aucun article récent dans cette catégorie</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- All news --}}
        <div class="all-news-head">
            <h2 class="display">Toute l'actualité - SPORT & BUISNESS</h2>
        </div>

        @if($gridItems->isNotEmpty())
            <div class="news-grid">
                @foreach($gridItems as $article)
                    <article class="news-card">
                        <div class="card-thumb">
                            @if($article->image)
                                <img src="{{ $article->image }}" alt="{{ $article->titre }}">
                            @else
                                <span class="fallback-text">Vignette article</span>
                            @endif
                        </div>
                        <a href="{{ route('articles.show', $article->slug) }}" class="title">
                            {{ Str::limit($article->titre, 100) }}
                        </a>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination">
                {{ $articles->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon">📝</div>
                <h3>Aucun article trouvé</h3>
                <p>Il n'y a pas encore d'articles dans cette catégorie.</p>
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
            --cream: #FBF3E6;
            --grey-line: #E3E3E3;
            --grey-text: #6B6B6B;
            --placeholder-text: #8C8C8C;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            color: var(--black);
            background: var(--cream);
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        .display {
            
            text-transform: uppercase;
            letter-spacing: 0.01em;
        }
        .ecriture{
            font-weight: 1000;
            text-transform: uppercase;
            letter-spacing: 0.01em;
        }

        /* ---- Top bar ---- */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 40px;
            background: var(--cream);
        }
        .icon-btn {
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: none;
            border: none;
        }
        .logo {
          
            font-size: 32px;
            letter-spacing: 0.02em;
            color: var(--black);
        }
        .logo span {
            
            color: var(--red);
            font-size: 36px;
            margin-left: 2px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }
        .avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2.5px solid var(--black);
        }
        .subscribe-btn {
            background: var(--black);
            color: var(--white);
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.04em;
            padding: 13px 22px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .subscribe-btn:hover {
            background: var(--red);
        }

        /* ---- Ticker ---- */
        .ticker {
            background: var(--red);
            color: var(--white);
            display: flex;
            align-items: center;
        }
        .ticker-label {
            
            font-size: 13px;
            letter-spacing: 0.05em;
            padding: 9px 22px;
            background: rgba(0, 0, 0, 0.15);
            white-space: nowrap;
        }
        .ticker-body {
            padding: 9px 22px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* ---- Primary nav ---- */
        .primary-nav {
            background: var(--black);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0 40px;
            overflow-x: auto;
        }
        .primary-nav a {
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 16px 12px;
            white-space: nowrap;
            transition: color 0.2s ease;
        }
        .primary-nav a:hover {
            color: var(--red);
        }
        .primary-nav a.active {
            color: var(--red);
        }

        /* ---- Category hero band ---- */
        .category-hero {
            background: var(--black);
            color: var(--white);
            padding: 44px 40px 56px;
        }
        .category-hero h1 {
            
            font-size: 56px;
            line-height: 1;
        }
        .category-hero p {
            max-width: 640px;
            margin-top: 18px;
            font-size: 17px;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.85);
        }

        /* ---- Container ---- */
        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* ---- Featured section ---- */
        .featured-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 26px;
            padding: 36px 0 20px;
        }
        .featured-card {
            background: var(--white);
            border: 1px solid var(--grey-line);
            border-radius: 4px;
            overflow: hidden;
            transition: transform 0.2s ease;
        }
        .featured-card:hover {
            transform: translateY(-4px);
        }
        .featured-thumb {
            width: 100%;
            aspect-ratio: 16/10;
            background: repeating-linear-gradient(135deg, #E9E9E9, #E9E9E9 12px, #DFDFDF 12px, #DFDFDF 24px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--placeholder-text);
            font-size: 13px;
            text-align: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }
        .featured-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }
        .featured-thumb .fallback-text {
            position: relative;
            z-index: 1;
        }
        .featured-body {
            padding: 22px 26px 28px;
        }
        .tag-categories {
            color: var(--red);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
            display: block;
        }
        .featured-body h2 {
            
            font-size: 24px;
            line-height: 1.25;
            margin-bottom: 14px;
            max-width: 600px;
        }
        .featured-body h2 a:hover {
            color: var(--red);
        }
        .featured-body p {
            font-size: 15px;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
        }

        /* ---- Sidebar list ---- */
        .sidebar-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .side-card {
            background: var(--white);
            border: 1px solid var(--grey-line);
            border-radius: 4px;
            padding: 18px 20px;
            transition: transform 0.2s ease;
        }
        .side-card:hover {
            transform: translateX(4px);
        }
        .side-card .tag-categories {
            margin-bottom: 8px;
        }
        .side-card h3 {
            
            font-size: 16px;
            line-height: 1.3;
        }
        .side-card h3 a:hover {
            color: var(--red);
        }

        /* ---- All-news heading ---- */
        .all-news-head {
            padding: 44px 0 26px;
            border-top: 1px solid var(--grey-line);
            margin-top: 20px;
        }
        .all-news-head h2 {
            
            font-size: 32px;
        }

        /* ---- News grid ---- */
        .news-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 34px 30px;
            padding-bottom: 60px;
        }
        .news-card {
            transition: transform 0.2s ease;
        }
        .news-card:hover {
            transform: translateY(-4px);
        }
        .news-card .card-thumb {
            width: 100%;
            aspect-ratio: 16/10;
            background: repeating-linear-gradient(135deg, #E9E9E9, #E9E9E9 12px, #DFDFDF 12px, #DFDFDF 24px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--placeholder-text);
            font-size: 12px;
            text-align: center;
            padding: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            position: relative;
        }
        .news-card .card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }
        .news-card .card-thumb .fallback-text {
            position: relative;
            z-index: 1;
        }
        .news-card .title {
            font-size: 16px;
            font-weight: 600;
            line-height: 1.5;
            text-decoration: underline;
        }
        .news-card .title:hover {
            color: var(--red);
        }

        /* ---- Pagination ---- */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            padding: 20px 0 60px;
        }
        .pagination a, .pagination span {
            padding: 10px 16px;
            border: 1px solid var(--grey-line);
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .pagination a:hover {
            background: var(--black);
            color: var(--white);
            border-color: var(--black);
        }
        .pagination .active {
            background: var(--red);
            color: var(--white);
            border-color: var(--red);
        }

        /* ---- Empty state ---- */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--grey-text);
        }
        .empty-state .icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        .empty-state h3 {
            
            font-size: 24px;
            margin-bottom: 12px;
        }

        @media (max-width: 900px) {
            .featured-row {
                grid-template-columns: 1fr;
            }
            .news-grid {
                grid-template-columns: 1fr;
            }
            .category-hero h1 {
                font-size: 38px;
            }
            .topbar {
                padding: 16px 20px;
            }
            .container,
            .category-hero,
            .primary-nav {
                padding-left: 20px;
                padding-right: 20px;
            }
            .logo {
                font-size: 24px;
            }
            .logo span {
                font-size: 28px;
            }
        }
        @media (max-width: 480px) {
            .topbar-right .subscribe-btn {
                padding: 10px 16px;
                font-size: 11px;
            }
            .avatar-circle {
                width: 28px;
                height: 28px;
            }
            .category-hero h1 {
                font-size: 28px;
            }
            .category-hero p {
                font-size: 15px;
            }
            .featured-body h2 {
                font-size: 20px;
            }
            .all-news-head h2 {
                font-size: 24px;
            }
        }
    </style>