@extends('layouts.app')

@section('title', 'MianSport — Accueil')

@section('content')
    <!-- Hero Slider -->
    <section class="hero" id="heroSlider">
        @foreach($heroSlides as $index => $slide)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
                <div class="hero-text">
                    
                    <h1>
                        {!! $slide['titre'] !!}
                    </h1>
                    <p>{{ $slide['description'] }}</p>
                    <div class="hero-meta">Mian Sports · {{ $slide['datedecreation'] }}</div>
                </div>
                <div class="hero-img">
                    @if($slide['image'])
                        <img alt="{{ $slide['alt'] }}" src="{{ asset($slide['image']) }}"/>
                    @else
                        <div class="ph {{ $slide['placeholder'] ?? 'athle' }}" style="height:100%;"></div>
                    @endif
                </div>
            </div>
        @endforeach
        
        <button aria-label="Précédent" class="hero-arrow prev" onclick="heroPrev()">‹</button>
        <button aria-label="Suivant" class="hero-arrow next" onclick="heroNext()">›</button>
        
        <div class="hero-dots">
            @foreach($heroSlides as $index => $slide)
                <button aria-label="Diapositive {{ $index + 1 }}" 
                        class="hero-dot {{ $index === 0 ? 'active' : '' }}" 
                        onclick="heroGoTo({{ $index }})"></button>
            @endforeach
        </div>
    </section>

    <!-- À la une -->
    <section class="ms-section ms-alaune">
        <div class="ms-wrap">
            <div class="home-rubric-head">
                <h2>À LA UNE</h2>
               <!-- <a href="{{ route('actu') }}">Voir tout </a>-->
            </div>
            
            <div class="lead">
                <img alt="À la Une — Africa Sports" src="{{ asset($une['image'] ?? '') }}"/>
                <div class="lead-copy">
                    @foreach($une->categories as $category)
                            <span class="ms-kicker">{{  $category->nom ?? 'À la Une' }}</span>
                    @endforeach
                    <a  href="{{route('articles.show',$une['slug'])}}"><h3>{{ $une['titre'] }}</h3></a>
                    <p class="ms-copy" style="color:#ddd">{{ $une['description'] }}</p>
                </div>
            </div>
            
            <div class="rail">
                @foreach($uneArticles as $article)
                    <a class="rail-card" href="{{ route('articles.show', $article['slug'])}}">
                        <img alt="{{ $article['alt'] }}" src="{{ asset($article['image']) }}"/>
                        <div>
                        @foreach($article->categories as $category)
                            <span class="ms-kicker">{{  $category->nom ?? 'À la Une' }}</span>
                             @endforeach
                            <h3 class="ms-title" style="color: #050505; font-size:18px">{{ $article['titre'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Football -->
    <section class="rubric-block r-foot" style="background: black">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2 style="color:white">FOOTBALL</h2>
                <a href="{{ route('sports.football') }}">Voir tout </a>
            </div>
            <div class="football-grid">
            <a class='lien' href="{{route('articles.show',$une['slug'])}}">
                <article class="sport-feature" style="background-image:url({{ $footballmainArticle['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                    <div >
                        @foreach($footballmainArticle->categories as $category)
                        <div class="rubric-kicker" >{{  $category->nom }}</div>
                        @endforeach
                        <h3 style="font-size: 25px;">{{ $footballmainArticle['titre'] }}</h3>
                    </div>
                </article>
                </a>
                <div class="sport-side">
                    @foreach($footballfeedItems as $football)
                        <a class='lien' href="{{route('articles.show',$football['slug'])}}">
                        <article class="sport-story">
                        @foreach($footballmainArticle->categories as $category)
                        <span> {{ $category->nom }} </span>
                        @endforeach
                  <h4>{{ $football['titre'] }}</h4>
                        </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Basketball -->
    <section class="rubric-block r-foot" style="background: var(--papier);">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2 style="color: #090909;">BASKETBALL</h2>
                <a href="{{ route('sports.Basketball') }}">Voir tout</a>
            </div>
            <div class="football-grid">
                <a class='lien' href="{{route('articles.show',$basketmainArticle['slug'])}}">
                <article class="sport-feature" class="sport-feature" style="background-image:url({{ $basketmainArticle['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                    <div>
                       @foreach($basketmainArticle->categories as $category)
                        <div class="rubric-kicker" >{{  $category->nom }}</div>
                        @endforeach
                        <h3 style="font-size: 25px;">{{ $basketmainArticle['titre'] }}</h3>
                    </div>
                </article>
                </a>
                <div class="sport-side">
                    @foreach($basketfeedItems ?? [] as $basket)
                    <a class='lien' href="{{route('articles.show',$basket['slug'])}}">
                        <article class="sport-story">
                         @foreach($basketmainArticle->categories as $category)
                        <span> {{ $category->nom }} </span>
                        @endforeach
                            <h4>{{ $basket['titre'] }}</h4>
                        </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Magazine -->
    <section class="home-magazine" style="width: 100%;">
        <div class="wrap">
            <div class="mag-ref-grid">
                <a aria-label="Lire l'édition {{ $magazine['edition'] }}" class="mag-ref-cover" href="{{ route('magazine.show', $magazine['id']) }}">
                    <img alt="Couverture de l'édition {{ $magazine['edition'] }} — {{ $magazine['title'] }}" src="{{ asset($magazine['cover']) }}"/>
                </a>
                <div class="mag-ref-right">
                    <div class="mag-ref-top">
                        <h2 class="mag-ref-edition">Edition N°{{ $magazine['edition'] }}</h2>
                        <div class="mag-ref-actions">
                            <a class="mag-ref-btn dark" href="{{ route('magazine.show', $magazine['id']) }}">Lire l'édition</a>
                            <a class="mag-ref-btn gray" href="{{ route('magazine') }}">Tous les magazines <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                    <div class="mag-ref-divider"></div>
                    <div class="mag-ref-fan">
                        @foreach($magazine['covers'] ?? [] as $cover)
                            <a aria-label="{{ $cover['alt'] }}" class="mag-ref-card {{ $cover['class'] ?? '' }}" href="{{ route('magazine.show', $cover['id']) }}">
                                <img alt="{{ $cover['alt'] }}" src="{{ asset($cover['image']) }}"/>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Autres sports collectifs -->
    <section class="home-rubric">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>AUTRES SPORTS COLLECTIFS</h2>
                <a href="{{ route('sports.collectifs') }}">Voir tout </a>
            </div>
            <div class="rubric-layout">
                
                <div class="rubric-main" style="background-image:url({{ $collectifmainArticle['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                    <div class="cthumb">
                        <div class="ph autres"></div>
                    </div>
                    <div class="rubric-main-copy" >
                        @foreach($collectifmainArticle->categories as $category)
                        <span class='rubric-label'> {{ $category->nom }} </span>
                        @endforeach
                       <a class='lien' href="{{route('articles.show',$collectifmainArticle['slug'])}}"> <h3 class="ms-title">{{ $collectifmainArticle['titre'] }}</h3></a>
                    </div>
                    
                </div>
                <div class="rubric-side">
                    @foreach($collectiffeedItems as $item)
                    <a class="rubric-side-card" href="{{ route('articles.show', $item['slug']) }}">
                            <div class="rubric-side-thumb" style="background-image:url({{ $item['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                                <div class="cthumb">
                                    <div class="ph autres"></div>
                                </div>
                            </div>
                            <div >
                                @foreach($item->categories as $category)                
                                <div class="mini-tag">{{ $category->nom }}</div>
                                @endforeach
                               <h4>{{ $item['titre'] }}</h4>
                            
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Combat & Arts martiaux -->
    <section class="rubric-block r-combat">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>COMBAT & ARTS MARTIAUX</h2>
                <a href="{{ route('sports.combats') }}">Voir tout </a>
            </div>
            <div style="display: grid; gap: 20px;">
                <div class="combat-grid">
                    @foreach($combatmainArticle as $item)
                     <a class='lien' href="{{route('articles.show',$item['slug'])}}">
                        <article class="combat-card" style="background-image:url({{ $item['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                            @foreach($item->categories as $category)   
                            <div class="rubric-kicker" >{{ $category->nom }}</div>
                            @endforeach
                           <h3 class="ms-title">{{ $item['titre'] }}</h3>
                        </article>
                        </a>
                    @endforeach
                </div>
                <div class="combat-grid">
                    @foreach($combatfeedItems as $item)
                    <a class='lien' href="{{route('articles.show',$item['slug'])}}">
                        <article class="combat-card" style="background-image:url({{ $item['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                            @foreach($item->categories as $category)   
                            <div class="rubric-kicker" >{{ $category->nom }}</div>
                            @endforeach
                           <h3 class="ms-title">{{ $item['titre'] }}</h3>
                        </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Athlétisme, Course & Multisport -->
    <section class="home-rubric">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>ATHLETISME, COURSE & MULTISPORT</h2>
                <a href="{{ route('sports.ath&course') }}">Voir tout </a>
            </div>
            <div class="rubric-layout" >
                <div class="rubric-main" style="background-image:url({{ $athletismemainArticle['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                    <div class="cthumb">
                        <div class="ph athle"></div>
                    </div>
                    <div class="rubric-main-copy">
                        @foreach($athletismemainArticle->categories as $category)
                        <span class="rubric-label">{{ $category->nom }}</span>
                        @endforeach
                        <a class='lien' href="{{route('articles.show',$athletismemainArticle['slug'])}}"><h3 class="ms-title">{{ $athletismemainArticle['titre'] }}</h3></a>
                    </div>
                </div>
                <div class="rubric-side">
                    @foreach($athletismefeedItems as $item)
                        <a class="rubric-side-card" href="{{ route('articles.show', $item['slug']) }}">
                            <div class="rubric-side-thumb"  style="background-image:url({{ $item['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                                <div class="cthumb">
                                    <div class="ph athle"></div>
                                </div>
                            </div>
                            <div>
                            @foreach($item->categories as $category)  
                                <div class="mini-tag">{{ $category->nom }}</div>
                                <h4>{{ $item['titre'] }}</h4>
                            @endforeach
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Compétitions -->
    <section class="ms-section ms-competitions">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>Compétitions</h2>
                <a href="{{ route('competitions') }}">Voir tout </a>
            </div>
            <div class="comp-grid">
                @foreach($competitions as $competition)
                    <article class="comp-card">
                        <img alt="{{ $competition['alt'] }}" src="{{ asset($competition['image']) }}"/>
                        <div class="comp-body">
                            <h3>{{ $competition['title'] }}</h3>
                            <p>{{ $competition['description'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Portraits & Interviews -->
    <section class="ms-section ms-portraits">
        <div class="ms-wrap">
            <div class="home-rubric-head">
                <h2>PORTRAITS &amp; INTERVIEWS</h2>
                <a href="{{ route('portraits') }}">Voir tout </a>
            </div>
            <div class="ms-portrait-grid">
                @foreach($portraits as $portrait)
                    <article class="ms-person">
                        <img alt="" src="{{ asset($portrait['image']) }}"/>
                        <h3 style="font-size: 25px;">{{ $portrait['title'] }}</h3>
                        <div class="name">{{ $portrait['author'] }}</div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sports de raquette -->
    <section class="rubric-block r-horse">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>SPORTS DE RAQUETTE</h2>
                <a href="{{ route('sports.raquette') }}">Voir tout </a>
            </div>
            <div class="horse-layout">
                <a class='lien' href="{{route('articles.show',$raquettemainArticle['slug'])}}">
                <article class="horse-feature" style="background-image:url({{ $raquettemainArticle['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;"> 
                    <div>@foreach($raquettemainArticle->categories as $category)
                        <div class="rubric-kicker" > {{ $category->nom  ?? 'Raquette' }}</div>
                        @endforeach

                        <h3 class="ms-title">{{ $raquettemainArticle['titre'] }}</h3>
                    </div>
                </article>
                </a>
                <div class="horse-list">
                    @foreach($raquettefeedItems ?? [] as $item)
                    
                        <article class="horse-item" style="background-image:url({{ asset($item['image'] ?? '') }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                            @foreach($item->categories as $category)
                            <div class="rubric-kicker">{{ $category->nom }}</div>
                            @endforeach
                           <a class='lien' href="{{route('articles.show',$item['slug'])}}"> <h3>{{ $item['titre'] }}</h3></a>
                        </article>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Cyclisme -->
    <section class="rubric-block r-horse">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>CYCLISME</h2>
                <a href="{{ route('sports.cyclisme') }}">Voir tout </a>
            </div>
            <div class="horse-layout">
                <article class="horse-feature">
                    <div>
                        <div class="rubric-kicker" style="color:#e9c99e">{{ $cyclisme['feature_kicker'] ?? 'Cyclisme' }}</div>
                        <h3 class="ms-title">{{ $cyclisme['feature_title'] }}</h3>
                    </div>
                </article>
                <div class="horse-list">
                    @foreach($cyclisme['items'] ?? [] as $item)
                        <article class="horse-item">
                            <div class="rubric-kicker">{{ $item['kicker'] }}</div>
                            <h3>{{ $item['title'] }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Sports mécaniques -->
    <section class="rubric-block r-meca">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>SPORTS MECANIQUE</h2>
                <a href="{{ route('sports.mecaniques') }}">Voir tout </a>
            </div>
            <div class="meca-grid">
                @foreach($mecaniques as $mecanique)
                    <article class="meca-card">
                        <div>
                            <small>{{ $mecanique['kicker'] }}</small>
                            <h3 class="ms-title">{{ $mecanique['title'] }}</h3>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Univers -->
    <section class="rubric-block r-univers">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>UNIVERS</h2>
                <a href="{{ route('univers') }}">Voir tout </a>
            </div>
            <div class="univ-grid">
                @foreach($univers as $item)
                    <article class="univ-card">
                        <div class="rubric-kicker">{{ $item['kicker'] }}</div>
                        <h3>{{ $item['title'] }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sports aquatiques -->
    <section class="home-rubric">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>SPORTS AQUATIQUES & NAUTIQUE</h2>
                <a href="{{ route('sports.aquatiques') }}">Voir tout </a>
            </div>
            <div class="rubric-layout">
                <div class="rubric-main">
                    <div class="cthumb">
                        <div class="ph autres"></div>
                    </div>
                    <div class="rubric-main-copy">
                        <span class="rubric-label">Sports aquatiques</span>
                        <h3 class="ms-title">{{ $aquatiques['main_title'] }}</h3>
                    </div>
                </div>
                <div class="rubric-side">
                    @foreach($aquatiques['side'] ?? [] as $item)
                        <a class="rubric-side-card" href="{{ route('articles.show', $item['slug']) }}">
                            <div class="rubric-side-thumb">
                                <div class="cthumb">
                                    <div class="ph autres"></div>
                                </div>
                            </div>
                            <div>
                                <div class="mini-tag">Sports aquatiques</div>
                                <h4>{{ $item['title'] }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Gymnastique -->
    <section class="rubric-block r-horse">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>GYMNASTIQUE, FORCE & DISCIPLINES ARTISTIQUES</h2>
                <a href="{{ route('sports.gymnastique') }}">Voir tout </a>
            </div>
            <div class="horse-layout">
                <article class="horse-feature">
                    <div>
                        <div class="rubric-kicker" style="color:#e9c99e">{{ $gymnastique['feature_kicker'] ?? 'Gymnastique' }}</div>
                        <h3 class="ms-title">{{ $gymnastique['feature_title'] }}</h3>
                    </div>
                </article>
                <div class="horse-list">
                    @foreach($gymnastique['items'] ?? [] as $item)
                        <article class="horse-item">
                            <div class="rubric-kicker">{{ $item['kicker'] }}</div>
                            <h3>{{ $item['title'] }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Vidéos -->
    <section class="videosect">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>VIDEOS</h2>
                <a href="{{ route('videos') }}">Voir toutes les vidéos </a>
            </div>
            <p class="sect-sub">Interviews, résumés de matchs et immersions à retrouver sur la chaîne YouTube Mian Sports.</p>
            <div class="vgrid">
                @foreach($videos as $video)
                    <div class="vcard">
                        <div class="vthumb">
                            @if($video['image'])
                                <img alt="{{ $video['alt'] }}" src="{{ asset($video['image']) }}"/>
                            @else
                                <div class="ph {{ $video['placeholder'] ?? 'athle' }}"></div>
                            @endif
                            <span class="playbtn">▶</span>
                            <span class="duration">{{ $video['duration'] }}</span>
                        </div>
                        <h3>{{ $video['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sports de précision & adresse -->
    <section class="rubric-block ms-glisse">
        <div class="ms-wrap">
            <div class="home-rubric-head">
                <h2>SPORTS DE PRECISION & ADRESSE</h2>
                <a href="{{ route('sports.precision') }}">Voir tout </a>
            </div>
            <div class="collage">
                @foreach($precision as $item)
                    <article class="g-card">
                        <div>
                            <span class="ms-kicker" style="color:#fff">{{ $item['kicker'] }}</span>
                            <h3 class="ms-title" style="color:#fff">{{ $item['title'] }}</h3>
                            @if($item['description'] ?? false)
                                <p class="ms-copy" style="color:#ddd">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Dossiers spéciaux & analyses -->
    <section class="rubric-block r-dossiers">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>DOSSIERS SPECIAUX & ANALYSES</h2>
                <a href="{{ route('dossiers') }}">Voir tout </a>
            </div>
            <div class="dossier-grid">
                @foreach($dossiers as $dossier)
                    <article class="dossier-card">
                        <small>{{ $dossier['kicker'] }}</small>
                        <h3>{{ $dossier['title'] }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sport & Business -->
    <section class="rubric-block r-business">
        <div class="wrap">
            <div class="home-rubric-head">
                <h2>SPORT &amp; BUSINESS</h2>
                <a href="{{ route('buisness') }}">Voir tout </a>
            </div>
            <div class="business-grid">
                
                <article class="business-card business-card--main" style="background-image:url({{ $buisnessmainArticle['image'] }}); background-size: cover;
                background-position: center;
                background-repeat: no-repeat;" ;>
                    <div class="business-card__content">
                        @foreach($buisnessmainArticle->categories as $category)
                        <span class="rubric-kicker">{{$category->nom}}</span>
                        @endforeach
                       <a class='lien' href="{{route('articles.show',$buisnessmainArticle['slug'])}}"> <h3 class="ms-title">{{ $buisnessmainArticle['titre'] }}</h3></a>
                    </div>
                </article>
                
                @foreach($buisnessfeedItems as $item)
                  
                    <article class="business-card">
                        <a class='lien' href="{{route('articles.show',$item['slug'])}}">
                        @foreach($item->categories as $category)
                        <div class="rubric-kicker" >{{$category->nom}}</div>
                        @endforeach
                        <h4>{{ $item['titre'] }}</h4>
                        </a>
                    </article>
                    
                @endforeach
            </div>
        </div>
    </section>

    <!-- Popup Magazine -->
    <div id="latestMagPopup" role="dialog" aria-modal="true" aria-labelledby="latestMagTitle">
        <div class="latest-mag-modal">
            <button class="latest-mag-close" type="button" aria-label="Fermer">&times;</button>
            <div class="latest-mag-cover">
                <img id="latestMagCover" alt="Couverture du dernier magazine" src="{{ asset($magazine['cover'] ?? '') }}">
            </div>
            <div class="latest-mag-info">
                <div class="latest-mag-kicker">Nouveau magazine</div>
                <h2 id="latestMagTitle">Edition N°{{ $magazine['edition'] ?? '12' }}</h2>
                <p>Découvrez la dernière édition de MianSport : analyses, portraits, interviews et dossiers consacrés à l'actualité sportive.</p>
                <div class="latest-mag-actions">
                    <a class="latest-mag-btn primary" href="{{ route('magazine.show', $magazine['id'] ?? 1) }}">Lire l'édition</a>
                    <button class="latest-mag-btn secondary" id="latestMagLater" type="button">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Popup magazine
    (function(){
        const popup = document.getElementById('latestMagPopup');
        const close = () => popup.classList.remove('is-open');
        const open = () => popup.classList.add('is-open');
        
        document.querySelector('.latest-mag-close').addEventListener('click', close);
        document.getElementById('latestMagLater').addEventListener('click', close);
        popup.addEventListener('click', e => { if(e.target === popup) close(); });
        document.addEventListener('keydown', e => { if(e.key === 'Escape') close(); });
        window.addEventListener('load', () => setTimeout(open, 450));
    })();
</script>
@endpush

@push('page-styles')
<style>
    /* Additional styles for home page */
    .ms-section{margin: 40px; 0 78px;position:relative}
    .ms-alaune .lead{position:relative;overflow:hidden;background:#111;height: 450px;}
    .ms-alaune .lead img{width:100%;height:510px;object-fit:cover;display:block}
    .ms-alaune .lead-copy{position:absolute;left:0;bottom:0;width:min(610px,70%);padding:34px;color:#fff;background:linear-gradient(90deg,rgba(0,0,0,.92),rgba(0,0,0,.15));}
    .ms-alaune .lead-copy h3{font-size:27px;line-height:1.03;margin:8px 0 0}
    .ms-alaune .lead-copy a{text-decoration:none;color:white}
    .ms-alaune .rail{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:20px}
    .ms-alaune .rail-card{display:grid;grid-template-columns:194px 1fr;gap:16px;align-items:center;text-decoration:none;color:#111;border-top:1px solid #ddd;padding-top:14px}
    .ms-alaune .rail-card img{width:194px;height:120px;object-fit:cover}
    .ms-wrap{width:min(1240px,calc(100% - 80px));margin:auto}
    .ms-kicker{color:var(--rouge);font-weight:900;text-transform:uppercase;letter-spacing:.08em;font-size:13px}
    .ms-copy{font-size:16px;line-height:1.5;color:#333;margin:8px 0 0}
    .ms-title{font-size:22px;line-height:1.08;margin:9px 0 0;font-weight:900; color:white; }
    
    .ms-portraits{background:#050505;color:#fff;padding:54px 38px;margin-left:calc((100% - 100vw)/2);margin-right:calc((100% - 100vw)/2)}
    .ms-portraits .ms-wrap{width:min(1240px,calc(100% - 40px))}.ms-portraits .ms-head{border-color:#777}.ms-portraits .ms-head h2{font-size:55px;color:#fff}.ms-portraits .ms-head a{color:var(--rouge)}.ms-portrait-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:38px}.ms-person{padding:22px 18px;text-align:center;border-right:1px solid #777}.ms-person:last-child{border-right:0}.ms-person img{width:205px;height:205px;object-fit:cover;border-radius:45% 45% 45% 45%;display:block;margin:0 auto 18px}.ms-person .tag{color:var(--rouge);font-weight:900;font-size:20px}.ms-person h3{font-family:Georgia,serif;font-size:22px;line-height:1.15;margin:12px 0}.ms-person .name{color:#bbb;font-weight:900;letter-spacing:.04em;font-size:15px}
    
    .ms-competitions .comp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}.ms-competitions .comp-card{background:#fff;box-shadow:0 10px 28px rgba(0,0,0,.16);border-bottom:4px solid #a9d6ea;overflow:hidden}.ms-competitions .comp-card img{width:100%;height:290px;object-fit:cover}.ms-competitions .comp-body{padding:20px 20px 26px;min-height:170px;position:relative}.ms-competitions .comp-body::after{content:'🏆';position:absolute;right:12px;bottom:8px;font-size:68px;opacity:.13}.ms-competitions .comp-body h3{color:var(--rouge);font-size:29px;margin:0 0 14px}.ms-competitions .comp-body p{font-size:16px;line-height:1.45;margin:0}
    
    .r-combat{background:#120d0d;color:#fff}.r-combat .rubric-head{border-color:#4c2828}.combat-grid{display:flex;grid-template-columns:1fr 1fr;gap:20px}.combat-card{min-height:250px;border:1px solid #5b2b2b;background:radial-gradient(circle at 80% 15%,#9a2727,transparent 35%),#211313;padding:28px;display:flex;flex-direction:column;justify-content:flex-end}.combat-card:nth-child(2){background:radial-gradient(circle at 20% 15%,#b8862f,transparent 35%),#1c1610}
    .r-combat .combat-grid{grid-template-columns:1fr}
    
    .r-business{background:var(--papier);padding:58px 0;border-bottom:1px solid var(--ligne);}
    .business-grid{display:grid;grid-template-columns:1.8fr 1fr 1fr;grid-template-rows:auto auto;gap:20px;}
    .business-card--main{grid-row:1/3;background:linear-gradient(135deg,#1a1a2e,#16213e);color:#fff;padding:34px;border-radius:12px;display:flex;flex-direction:column;justify-content:flex-end;min-height:340px;position:relative;overflow:hidden;}
    .business-card--main::after{content:"📈";position:absolute;right:20px;bottom:10px;font-size:72px;opacity:0.15;}
    .business-card--main .ms-title{color:white;font-size:px;margin-top:8px;}
    .business-card--main .business-card__excerpt{color:#b0b0c8;font-size:14px;line-height:1.6;margin-top:10px;max-width:90%;}
    .business-card{background:#fff;padding:20px 22px;border-radius:12px;border:1px solid var(--ligne);display:flex;flex-direction:column;justify-content:flex-end;transition:transform 0.2s ease,box-shadow 0.2s ease;}
    .business-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,0.06);}
    .business-card a{text-decoration:none;color:black}
    .r-horse{background:var(--papier)}.horse-layout{display:grid;grid-template-columns:.9fr 1.1fr;gap:20px}.horse-feature{background:linear-gradient(135deg,#6d4325,#2c1b10);color:#fff;padding:34px;min-height:310px;display:flex;align-items:flex-end}.horse-list{display:grid;grid-template-columns:1fr 1fr;gap:12px}.horse-item{background:#fff;padding:20px;border:1px solid #dfd0bf}
    
    .r-dossiers{background:#f5f0e8}.dossier-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.dossier-card{background:#14100e;color:#fff;padding:26px;min-height:260px;display:flex;flex-direction:column;justify-content:space-between}.dossier-card:nth-child(2){background:#b8862f}.dossier-card:nth-child(3){background:#c81d25}.dossier-card small{text-transform:uppercase;letter-spacing:1px;font-weight:800}
    
    .r-meca{background:#0c0c0c;color:#fff}.r-meca .rubric-head{border-color:#333}.meca-grid{display:grid;grid-template-columns:1.6fr .8fr .8fr;gap:12px}.meca-card{min-height:250px;padding:24px;display:flex;align-items:flex-end;background:linear-gradient(135deg,#202020,#111);border:1px solid #333}.meca-card:first-child{min-height:360px;background:linear-gradient(135deg,#b22a22,#211)}.meca-card small{color:#aaa;display:block;margin-bottom:6px}
    
    .r-univers{background:var(--papier)}.univ-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}.univ-card{padding:22px;background:#fff;border-radius:4px;border-bottom:5px solid #5c3d7a;min-height:190px}.univ-card:nth-child(2){border-color:#c81d25}.univ-card:nth-child(3){border-color:#0f6e56}.univ-card:nth-child(4){border-color:#b8862f}.univ-card h3{font-family:Anton;font-size:24px;margin-top:36px}
    
    .ms-glisse .collage{display:grid;grid-template-columns:2fr 1fr 1fr;grid-template-rows:180px 180px;gap:12px}.ms-glisse .g-card{padding:24px;display:flex;align-items:end;color:#fff;background:linear-gradient(145deg,#173b31,#0c0c0c);position:relative;overflow:hidden}.ms-glisse .g-card:first-child{grid-row:1/3;background:linear-gradient(145deg,#7b251d,#111)}.ms-glisse .g-card:nth-child(2){background:linear-gradient(145deg,#3d5e17,#111)}.ms-glisse .g-card:nth-child(3){background:linear-gradient(145deg,#24516a,#111)}
    
    .rubric-block{padding:58px 0;border-bottom:1px solid #e6e2dc;}
    .football-grid{display:grid;grid-template-columns:1.5fr .9fr;gap:24px}.sport-feature{min-height:360px;padding:28px;display:flex;align-items:flex-end;background:linear-gradient(135deg,#17492e,#0b2418);position:relative;overflow:hidden}.sport-feature::before{content:'FOOTBALL';position:absolute;right:-25px;top:10px;font-size:100px;opacity:.08}.sport-feature h3{font-size:38px;line-height:1.05;color:white}.sport-side{display:grid;gap:14px}.sport-story{padding:18px;background:#1d1a17;border-left:4px solid #c81d25}.sport-story span{font-size:10px;color:#ff4b4b;font-weight:800;text-transform:uppercase}.sport-story h4{font-size:16px;margin-top:7px;color:white}
    .rubric-kicker{ font-size:11px;color:#c81d25;margin-bottom:10px; text-transform:uppercase;color:red; padding:5px 12px;font-weight:800;letter-spacing:1px;margin-bottom:7px}
    .videosect{padding:64px 0 20px;}
    .vgrid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
    .vcard .vthumb{position:relative;aspect-ratio:16/9;overflow:hidden;background:var(--encre);margin-bottom:12px;}
    .vcard .vthumb img{width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.7);}
    .vcard h3{font-size:14.5px;font-weight:700;line-height:1.3;}
    .playbtn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:46px;height:46px;background:var(--rouge);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;}
    .duration{position:absolute;bottom:8px;right:8px;background:rgba(20,16,14,0.85);color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:3px;}
    
    .rubric-layout{display:grid;grid-template-columns:1.05fr .95fr;gap:42px;align-items:start;}
    .rubric-main{position:relative;aspect-ratio:4/3;overflow:hidden;background:var(--encre);}
    .rubric-main .ph{width:100%;height:100%;}
    .rubric-main img{width:100%;height:100%;object-fit:cover;display:block;}
    .rubric-main::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 48%,rgba(20,16,14,.88));}
    .rubric-main-copy{position:absolute;left:22px;right:22px;bottom:20px;z-index:2;color:#fff;}
    .rubric-main-copy .rubric-label{display:inline-block;background:var(--rouge);padding:5px 12px;margin-bottom:10px;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;}
    .rubric-main-copy h3{font-size:30px;line-height:1.02;max-width:560px;}
    .rubric-side{display:flex;flex-direction:column;gap:18px;}
    .rubric-side-card{display:grid;grid-template-columns:118px 1fr;gap:16px;align-items:center;padding-bottom:18px;border-bottom:1px solid var(--ligne);text-decoration:none;color:inherit;}
    .rubric-side-card:last-child{border-bottom:0;padding-bottom:0;}
    .rubric-side-thumb{width:118px;height:88px;overflow:hidden;background:var(--encre);}
    .rubric-side-thumb .ph{width:100%;height:100%;}
    .rubric-side-thumb img{width:100%;height:100%;object-fit:cover;display:block;}
    .rubric-side-card .mini-tag{color:var(--rouge);font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;margin-bottom:5px;}
    .rubric-side-card h4{font-size:16px;line-height:1.25;font-weight:800;text-decoration:none}
    .lien{text-decoration:none;text-decoration-line: none;}

    .home-magazine{background:linear-gradient(120deg,#050505 0%,#252525 58%,#626262 100%);padding:48px 0 70px;border-bottom:1px solid var(--ligne);}
    .mag-ref-grid{display:grid;grid-template-columns:minmax(360px, .72fr) minmax(560px, 1.28fr);gap:52px;align-items:start;}
    .mag-ref-cover{width:100%;max-width:426px;aspect-ratio:426/615;overflow:hidden;margin:0 auto;}
    .mag-ref-cover img{width:100%;height:100%;display:block;object-fit:cover;}
    .mag-ref-right{padding-top:8px;}
    .mag-ref-top{display:grid;align-items:center;justify-content:space-between;margin-left:90px;gap:28px;padding-bottom:38px;}
    .mag-ref-edition{margin:0;font-family:'Anton',sans-serif;font-size:44px;line-height:1;font-weight:900;letter-spacing:-.5px;text-transform:none;color:white;}
    .mag-ref-actions{display:grid;grid-template-columns:1fr 1fr;gap:52px;width:100%;max-width:735px;}
    .mag-ref-btn{min-height:60px;border-radius:48px;display:flex;align-items:center;justify-content:center;padding:0 30px;color:#fff;text-decoration:none;font-size:15px;font-weight:800;white-space:nowrap;transition:transform .18s ease,filter .18s ease;}
    .mag-ref-btn:hover{transform:translateY(-2px);filter:brightness(1.05);}
    .mag-ref-btn.dark{background:#111014;}
    .mag-ref-btn.gray{background:#111014;}
    .mag-ref-divider{height:1px;background:white;margin-bottom:50px;width:80%;margin-left:90px}
    .mag-ref-fan{display:flex;align-items:flex-start;margin-left:95px;min-height:100px;padding:0 5px;overflow:visible;}
    .mag-ref-card{width:100px;aspect-ratio:247/359;flex:0 0 200px;overflow:hidden;background:#eee;box-shadow:0 7px 16px rgba(0,0,0,.08);position:relative;}
    .mag-ref-card img{width:100%;height:100%;object-fit:cover;display:block;}
    .mag-ref-card.left{transform:rotate(-6deg);margin-top:22px;margin-right:-4px;z-index:1;}
    .mag-ref-card.center{transform:rotate(0deg);z-index:3;}
    .mag-ref-card.right{transform:rotate(6deg);margin-top:22px;margin-left:-4px;z-index:2;}
    
    .latest-mag-modal{position:relative;width:min(720px,94vw);background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.35);display:grid;grid-template-columns:280px 1fr;animation:magPop .28s ease-out}
    .latest-mag-cover{background:#f3f3f3;display:flex;align-items:center;justify-content:center;padding:22px}.latest-mag-cover img{width:100%;max-height:390px;object-fit:cover;border-radius:8px;box-shadow:0 14px 30px rgba(0,0,0,.22)}
    .latest-mag-info{padding:42px 38px;display:flex;flex-direction:column;justify-content:center}.latest-mag-kicker{font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#e21b23;font-weight:800;margin-bottom:10px}.latest-mag-info h2{font-size:34px;line-height:1.05;margin:0 0 14px;color:#151515}.latest-mag-info p{color:#666;line-height:1.6;margin:0 0 24px}.latest-mag-actions{display:flex;gap:10px;flex-wrap:wrap}.latest-mag-btn{display:inline-flex;align-items:center;justify-content:center;padding:12px 18px;border-radius:8px;text-decoration:none;font-weight:800;font-size:14px}.latest-mag-btn.primary{background:#e21b23;color:#fff}.latest-mag-btn.secondary{background:#eee;color:#222}.latest-mag-close{position:absolute;right:14px;top:12px;width:38px;height:38px;border:0;border-radius:50%;background:#fff;color:#222;font-size:24px;cursor:pointer;box-shadow:0 3px 12px rgba(0,0,0,.15);z-index:2}.latest-mag-close:hover{background:#f1f1f1}
    #latestMagPopup{position:fixed;inset:0;background:rgba(0,0,0,.62);display:none;align-items:center;justify-content:center;z-index:99999;padding:20px;backdrop-filter:blur(4px)}
    #latestMagPopup.is-open{display:flex}
    @keyframes magPop{from{opacity:0;transform:translateY(12px) scale(.97)}to{opacity:1;transform:none}}
    
    @media(max-width:900px){.rubric-layout,.mag-home-grid{grid-template-columns:1fr;gap:26px}.rubric-main-copy h3{font-size:26px}}
    @media(max-width:600px){.home-rubric,.home-magazine{padding:40px 0 48px}.home-rubric-head h2,.home-magazine-head h2{font-size:27px}.rubric-side-card{grid-template-columns:92px 1fr}.rubric-side-thumb{width:92px;height:72px}.rubric-side-card h4,.mag-home-item h4{font-size:13.5px}.mag-home-feature h3{font-size:25px}}
    @media(max-width:1000px){.ms-wrap{width:min(92%,760px)}.ms-magazine .mag-layout{grid-template-columns:300px 1fr}.ms-magazine .main-cover{width:300px;height:433px}.ms-magazine .mag-stack{transform:scale(.85);transform-origin:left top;margin-right:-90px}.ms-alaune .rail,.ms-comp-grid,.ms-basket .basket-grid,.ms-collective{grid-template-columns:1fr}.ms-football .feature{grid-template-columns:1fr}.ms-football .visual{min-height:260px}.ms-athletics .ath-grid,.ms-precision .target-grid,.ms-esport .es-grid{grid-template-columns:repeat(2,1fr)}.ms-competitions .comp-grid,.ms-univers .universe-grid,.ms-gym .gym-grid,.ms-equestre .horse-grid,.ms-dossier-grid{grid-template-columns:1fr 1fr}.ms-portraits .ms-portrait-grid{grid-template-columns:repeat(2,1fr)}.ms-person:nth-child(2){border-right:0}.ms-person:nth-child(1),.ms-person:nth-child(2){border-bottom:1px solid #777}}
    @media(max-width:650px){.ms-wrap{width:calc(100% - 28px)}.ms-section{margin-bottom:55px}.ms-head{align-items:flex-start;flex-direction:column;gap:10px}.ms-head h2,.ms-portraits .ms-head h2{font-size:36px}.ms-alaune .lead img{height:300px}.ms-alaune .lead-copy{width:100%;padding:20px}.ms-alaune .lead-copy h3{font-size:28px}.ms-alaune .rail{grid-template-columns:1fr}.ms-alaune .rail-card{grid-template-columns:120px 1fr}.ms-alaune .rail-card img{width:120px;height:90px}.ms-magazine{padding:30px 14px}.ms-magazine .mag-layout{grid-template-columns:1fr}.ms-magazine .main-cover{width:min(100%,426px);height:auto}.ms-magazine .edition{font-size:35px;margin:10px 0 20px}.ms-magazine .mag-actions{flex-direction:column}.ms-magazine .mag-actions a,.ms-magazine .mag-actions a:last-child{min-width:0}.ms-magazine .mag-stack{transform:none;display:flex;height:auto;align-items:end;overflow:hidden;padding:18px 0}.ms-magazine .mag-left{width:31%;height:auto}.ms-magazine .mag-center{width:38%;height:auto}.ms-magazine .mag-right{width:32%;height:auto}.ms-basket .basket-grid,.ms-athletics .ath-grid,.ms-competitions .comp-grid,.ms-univers .universe-grid,.ms-gym .gym-grid,.ms-equestre .horse-grid,.ms-dossier-grid,.ms-esport .es-grid,.ms-precision .target-grid{grid-template-columns:1fr}.ms-athletics .ath-card:nth-child(n){transform:none}.ms-cyclisme .timeline::before{left:8px}.ms-cyclisme .cycle-item{width:calc(100% - 35px);margin-left:35px!important}.ms-cyclisme .cycle-item::after{left:-35px!important}.ms-aquatique .water{grid-template-columns:1fr;clip-path:none}.ms-glisse .collage{grid-template-columns:1fr;grid-template-rows:auto}.ms-glisse .g-card:first-child{grid-row:auto;min-height:240px}.ms-portraits{padding:35px 14px}.ms-portraits .ms-portrait-grid{grid-template-columns:1fr 1fr}.ms-person{padding:18px 8px}.ms-person img{width:130px;height:130px}.ms-person h3{font-size:18px}.ms-person .name{font-size:12px}}
</style>
@endpush