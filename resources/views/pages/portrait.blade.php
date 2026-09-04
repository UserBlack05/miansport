{{-- resources/views/pages/portraits/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portraits & Interviews - MianSport</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --rouge: #C81D25;
            --encre: #14100E;
            --papier: #FAF8F5;
            --ardoise: #4B4844;
            --or: #B8862F;
            --ligne: #E4DFD6;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--papier);
            color: var(--encre);
        }
        .wrap {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* page specific styles */
        .pagehead {
            padding: 48px 0 8px;
            border-bottom: 3px solid var(--encre);
            margin-bottom: 44px;
        }
        .pagehead .eyebrow {
            color: var(--rouge);
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .pagehead h1 {
            font-family: 'Anton', sans-serif;
            font-size: 48px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .pagehead p {
            color: var(--ardoise);
            font-size: 15px;
            max-width: 560px;
            margin-bottom: 30px;
        }

        /* ---- Rubrique : Portrait glissant ---- */
        .carousel-portraits {
            margin-bottom: 60px;
            overflow: hidden;
            position: relative;
        }
        .carousel-portraits .sect-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 28px;
            border-bottom: 3px solid var(--encre);
            padding-bottom: 14px;
        }
        .carousel-portraits .sect-head h2 {
            font-family: 'Anton', sans-serif;
            font-size: 26px;
            text-transform: uppercase;
        }
        .carousel-portraits .sect-head a {
            color: var(--rouge);
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .carousel-portraits .sect-head a:hover {
            text-decoration: underline;
        }
        .carousel-track {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 8px 4px 20px;
            scroll-behavior: smooth;
        }
        .carousel-track::-webkit-scrollbar {
            height: 6px;
        }
        .carousel-track::-webkit-scrollbar-thumb {
            background: var(--ardoise);
            border-radius: 10px;
        }
        .carousel-item {
            flex: 0 0 280px;
            scroll-snap-align: start;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s;
        }
        .carousel-item:hover {
            transform: translateY(-6px);
        }
        .carousel-item .cov-wrap {
            aspect-ratio: 4/3;
            background: var(--ligne);
            overflow: hidden;
        }
        .carousel-item .cov-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .carousel-item .info {
            padding: 16px 16px 20px;
        }
        .carousel-item .info .name {
            font-family: 'Anton', sans-serif;
            font-size: 18px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .carousel-item .info .role {
            color: var(--rouge);
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .carousel-item .info p {
            font-size: 13px;
            color: var(--ardoise);
            line-height: 1.5;
        }

        /* ---- Mise en avant événementielle ---- */
        .feature-event {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 70px;
            padding: 40px 0;
            border-top: 2px solid var(--ligne);
            border-bottom: 2px solid var(--ligne);
        }
        .feature-event .event-img .cov-wrap {
            aspect-ratio: 4/3;
            background: var(--encre);
            overflow: hidden;
        }
        .feature-event .event-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .feature-event .event-tag {
            display: inline-block;
            background: var(--rouge);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 6px 16px;
            margin-bottom: 14px;
        }
        .feature-event h2 {
            font-family: 'Anton', sans-serif;
            font-size: 32px;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 12px;
        }
        .feature-event p {
            color: var(--ardoise);
            font-size: 15px;
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 20px;
        }
        .feature-event .btn {
            background: var(--encre);
            color: var(--papier);
            border: none;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }
        .feature-event .btn:hover {
            background: var(--rouge);
        }

        /* ---- Interviews vidéo ---- */
        .video-interviews {
            margin-bottom: 60px;
        }
        .video-interviews .sect-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 28px;
            border-bottom: 3px solid var(--encre);
            padding-bottom: 14px;
        }
        .video-interviews .sect-head h2 {
            font-family: 'Anton', sans-serif;
            font-size: 26px;
            text-transform: uppercase;
        }
        .video-interviews .sect-head a {
            color: var(--rouge);
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .video-interviews .sect-head a:hover {
            text-decoration: underline;
        }
        .video-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .video-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .video-card:hover {
            transform: translateY(-4px);
        }
        .video-card .cov-wrap {
            position: relative;
            aspect-ratio: 16/9;
            background: var(--encre);
            overflow: hidden;
        }
        .video-card .cov-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .video-card .playbtn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 52px;
            height: 52px;
            background: var(--rouge);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s;
        }
        .video-card:hover .playbtn {
            transform: translate(-50%, -50%) scale(1.1);
        }
        .video-card .info {
            padding: 16px;
        }
        .video-card .info h4 {
            font-weight: 700;
            font-size: 15px;
            line-height: 1.3;
            margin-bottom: 4px;
        }
        .video-card .info .meta {
            font-size: 12px;
            color: var(--ardoise);
        }

        /* ---- Empty state ---- */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--ardoise);
        }
        .empty-state .icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        .empty-state h3 {
            font-family: 'Anton', sans-serif;
            font-size: 24px;
            margin-bottom: 12px;
        }

        @media (max-width: 800px) {
            .feature-event {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .video-grid {
                grid-template-columns: 1fr 1fr;
            }
            .carousel-item {
                flex: 0 0 220px;
            }
            .pagehead h1 {
                font-size: 36px;
            }
        }
        @media (max-width: 560px) {
            .video-grid {
                grid-template-columns: 1fr;
            }
            .carousel-item {
                flex: 0 0 180px;
            }
            .pagehead h1 {
                font-size: 28px;
            }
            .feature-event h2 {
                font-size: 24px;
            }
            .wrap {
                padding: 0 16px;
            }
        }

        /* ---- Placeholders ---- */
        .ph {
            background: repeating-linear-gradient(135deg, #8a4a12, #8a4a12 22px, #7a4110 22px, #7a4110 44px);
        }
        .ph.basket {
            background: repeating-linear-gradient(135deg, #8a4a12, #8a4a12 22px, #7a4110 22px, #7a4110 44px);
        }
        .ph.tennis {
            background: repeating-linear-gradient(90deg, #5b7d2e, #5b7d2e 26px, #4f6d28 26px, #4f6d28 52px);
        }
        .ph.athle {
            background: repeating-linear-gradient(45deg, #2b3a67, #2b3a67 24px, #243158 24px, #243158 48px);
        }
        .ph.boxe {
            background: repeating-linear-gradient(60deg, #7a1f1f, #7a1f1f 22px, #661a1a 22px, #661a1a 44px);
        }
        .ph.rugby {
            background: repeating-linear-gradient(100deg, #3d5c3d, #3d5c3d 24px, #324d32 24px, #324d32 48px);
        }
        .ph.foot {
            background: repeating-linear-gradient(120deg, #1d5c3a, #1d5c3a 22px, #17492e 22px, #17492e 44px);
        }
        .ph.autres {
            background: repeating-linear-gradient(70deg, #5c5c5c, #5c5c5c 22px, #4a4a4a 22px, #4a4a4a 44px);
        }
        .ph.competition {
            background: repeating-linear-gradient(50deg, #8a6d1d, #8a6d1d 22px, #705a17 22px, #705a17 44px);
        }
        .ph.univers {
            background: repeating-linear-gradient(110deg, #5c3d7a, #5c3d7a 22px, #4a3164 22px, #4a3164 44px);
        }
        .ph.handball {
            background: repeating-linear-gradient(130deg, #b5451f, #b5451f 22px, #9c3b1a 22px, #9c3b1a 44px);
        }
        .ph.volley {
            background: repeating-linear-gradient(90deg, #2f6f8f, #2f6f8f 24px, #285d78 24px, #285d78 48px);
        }
        .ph.course {
            background: repeating-linear-gradient(140deg, #b5731f, #b5731f 22px, #9c621a 22px, #9c621a 44px);
        }
        .ph.esport {
            background: repeating-linear-gradient(65deg, #3d2f7a, #3d2f7a 22px, #332664 22px, #332664 44px);
        }
        .ph.golf {
            background: repeating-linear-gradient(95deg, #2f6b3d, #2f6b3d 24px, #275a33 24px, #275a33 48px);
        }
        .home-rubric-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            border-bottom: 3px solid var(--encre);
            padding-bottom: 14px;
            margin-bottom: 30px;
        }
        .home-rubric-head h2 {
            font-family: 'Anton', sans-serif;
            font-size: 34px;
            text-transform: uppercase;
            line-height: 1;
        }
        .home-rubric-head a {
            color: var(--rouge);
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .home-rubric-head a:hover {
            text-decoration: underline;
        }

        .cov-wrap .fallback-text {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: var(--ardoise);
            font-size: 13px;
            text-align: center;
            padding: 20px;
            background: var(--ligne);
        }
        .lien{text-decoration:none;text-decoration-line: none;}
    </style>
</head>
<body>

    <div class="wrap">

        {{-- Page Header --}}
        <div class="pagehead">
            <div class="eyebrow">Rubrique</div>
            <h1>Portraits &amp; Interviews</h1>
            <p>Les visages qui font le sport africain, racontés en profondeur : portraits immersifs, événements marquants et interviews vidéo.</p>
        </div>

        {{-- CAROUSSEL PORTRAITS GLISSANTS --}}
        <div class="carousel-portraits">
            <div class="home-rubric-head">
                <h2>Portraits glissants</h2>
                
            </div>

            @if(isset($feedItems) && $feedItems->isNotEmpty())
                <div class="carousel-track">
                    @foreach($feedItems as $portrait)
                        <div class="carousel-item">
                            <div class="cov-wrap">
                                @if($portrait->image)
                                    <img src="{{ $portrait->image }}" alt="{{ $portrait->titre }}">
                                @else
                                    <div class="fallback-text">📷 Portrait</div>
                                @endif
                            </div>
                            <a class='lien' href="{{ route('articles.show', $mainArticle->slug) }}">
                            <div class="info">
                                <div class="name">{{ Str::limit($portrait->titre, 30) }}</div>
                                <div class="role">
                                    @forelse($portrait->categories as $cat)
                                        {{ $cat->nom }}
                                        @if(!$loop->last) · @endif
                                    @empty
                                        Portrait
                                    @endforelse
                                </div>
                                <p>{{ Str::limit($portrait->description ?? $portrait->excerpt, 90) }}</p>
                            </div>
                        </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">📸</div>
                    <h3>Aucun portrait disponible</h3>
                    <p>Les portraits seront bientôt disponibles.</p>
                </div>
            @endif
        </div>

        {{-- MISE EN AVANT ÉVÉNEMENTIELLE --}}
        @if(isset($mainArticle) && $mainArticle)
            <div class="feature-event">
                <div class="event-img">
                    <div class="cov-wrap">
                        @if($mainArticle->image)
                            <img src="{{ $mainArticle->image }}" alt="{{ $mainArticle->titre }}">
                        @else
                            <div class="fallback-text">📷 Image à la une</div>
                        @endif
                    </div>
                </div>
                <div class="event-text">
                    <span class="event-tag">
                        @forelse($mainArticle->categories as $cat)
                            {{ $cat->nom }}
                            @if(!$loop->last) · @endif
                        @empty
                            Événement
                        @endforelse
                    </span>
                    <h2>{{ $mainArticle->titre }}</h2>
                    <p>{{ Str::limit($mainArticle->description ?? $mainArticle->excerpt, 180) }}</p>
                    <a href="{{ route('articles.show', $mainArticle->slug) }}" class="btn">Lire le portrait</a>
                </div>
            </div>
        @endif

        {{-- INTERVIEWS VIDÉO --}}
        @if(isset($videos) && count($videos) > 0)
            <div class="video-interviews">
                <div class="home-rubric-head">
                    <h2>Interviews en vidéo</h2>
                    <a href="">Voir toutes les vidéos →</a>
                </div>
                <div class="video-grid">
                    @foreach($videos as $video)
                        <div class="video-card">
                            <div class="cov-wrap">
                                @if($video['image'])
                                    <img src="{{ $video['image'] }}" alt="{{ $video['alt'] ?? $video['title'] }}">
                                @else
                                    <div class="fallback-text">🎬 Vidéo</div>
                                @endif
                                <span class="playbtn">▶</span>
                            </div>
                            <div class="info">
                                <h4>{{ $video['title'] }}</h4>
                                <span class="meta">{{ $video['duration'] ?? '' }} · {{ $video['time'] ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!--{{-- FIL D'ACTUALITÉ (Feed) --}}
        @if(isset($feedItems) && $feedItems->isNotEmpty())
            <div class="home-rubric-head" style="margin-top: 20px;">
                <h2>À la une</h2>
                <a href="">Voir tous les articles →</a>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding-bottom: 60px;">
                @foreach($feedItems as $item)
                    <article style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <div style="aspect-ratio: 16/9; overflow: hidden; background: var(--ligne);">
                            @if($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->titre }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; color: var(--ardoise); font-size: 13px;">
                                    📰 Article
                                </div>
                            @endif
                        </div>
                        <div style="padding: 16px;">
                            <a href="{{ route('articles.show', $item->slug) }}" style="text-decoration: none; color: var(--encre); font-weight: 700; font-size: 16px; line-height: 1.3;">
                                {{ $item->titre }}
                            </a>
                            <div style="font-size: 12px; color: var(--ardoise); margin-top: 6px;">
                                {{ $item->datedecreation->format('d/m/Y') }}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif-->

    </div>

</body>
</html>