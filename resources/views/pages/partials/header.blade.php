<header>
    <div class="navrow">
        <button aria-label="Ouvrir le menu" class="hamburger" onclick="openDrawer()">
            <span></span><span></span><span></span>
        </button>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img alt="MianSport" src="{{asset('MIAN IMAGE/the_african_financial_news_logo.jpg')}}"/>
            </a>
        </div>
        <div class="navactions">
            <button aria-label="Rechercher" class="searchbtn">
                <svg fill="none" height="18" stroke="currentColor" stroke-width="2.2" viewbox="0 0 24 24" width="18">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" x2="16.65" y1="21" y2="16.65"></line>
                </svg>
            </button>
            <button class="subscribe">S'abonner</button>
        </div>
    </div>


<div class="overlay" id="overlay" onclick="closeDrawer()"></div>
<div class="drawer" id="drawer">
    <div class="drawer-top">
        <button aria-label="Fermer le menu" class="drawer-close" onclick="closeDrawer()">✕</button>
    </div>
    <div class="drawer-body">
        <a class="drawer-cta" href="#">S'abonner à MianSport <span>↗</span></a>
        <div class="drawer-label">Navigation</div>
        <div class="navmenu">
            <a class="navmenu-link" href="{{ route('home') }}">Accueil</a>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Actualités <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('actu') }}">Dernières actualités</a>
                    <a href="{{ route('analyses') }}">Analyses</a>
                    <a href="{{ route('interviews') }}">Interviews</a>
                    <a href="{{ route('portraits') }}">Portraits</a>
                    <a href="{{ route('dossiers') }}">Dossiers, analyses et enquêtes</a>
                </div>
            </div>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Football <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('football.ivoire') }}">Côte d'Ivoire</a>
                    <a href="{{ route('football.afrique') }}">Afrique</a>
                    <a href="{{ route('football.international') }}">International</a>
                    <a href="{{ route('football.feminin') }}">Football féminin</a>
                    <a href="{{ route('football.futsal') }}">Futsal / Maracana</a>
                    <a href="{{ route('football.beach') }}">Beach soccer</a>
                </div>
            </div>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Basketball <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('basketball.ivoire') }}">Côte d'Ivoire</a>
                    <a href="{{ route('basketball.afrique') }}">Afrique</a>
                    <a href="{{ route('basketball.international') }}">International</a>
                    <a href="{{ route('basketball.feminin') }}">Basketball féminin</a>
                </div>
            </div>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Tous les sports <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('sports.collectifs') }}">Autres sports collectifs</a>
                    <a href="{{ route('sports.combats') }}">Combat et arts martiaux</a>
                    <a href="{{ route('sports.ath&course') }}">Athlétisme, course et multisports</a>
                    <a href="{{ route('sports.raquette') }}">Sports de raquette</a>
                    <a href="{{ route('sports.cyclisme') }}">Cyclisme</a>
                    <a href="{{ route('sports.mecaniques') }}">Sports mécaniques</a>
                    <a href="{{ route('sports.aquatiques') }}">Sports aquatiques et nautiques</a>
                    <a href="{{ route('sports.gymnastique') }}">Gymnastique, force et disciplines artistiques</a>
                    <a href="{{ route('sports.precision') }}">Sports de précision et d'adresse</a>
                    <a href="{{ route('sports.glisse') }}">Glisse, outdoor et sports urbains</a>
                    <a href="{{ route('sports.equestres') }}">Sports équestres et hippisme</a>
                    <a href="{{ route('sports.esport') }}">E-sport et sports de l'esprit</a>
                    <a href="{{ route('sports.az') }}">Toutes les disciplines de A à Z</a>
                </div>
            </div>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Univers <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('univers.feminin') }}">Sport féminin</a>
                    <a href="{{ route('univers.parasport') }}">Parasport</a>
                    <a href="{{ route('univers.jeunesse') }}">Jeunesse et formation</a>
                    <a href="{{ route('univers.traditionnels') }}">Sports traditionnels africains</a>
                    <a href="{{ route('univers.sante') }}">Santé et performance</a>
                </div>
            </div>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Compétitions <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('competitions.ivoiriennes') }}">Compétitions ivoiriennes</a>
                    <a href="{{ route('competitions.africaines') }}">Compétitions africaines</a>
                    <a href="{{ route('competitions.olympiques') }}">Jeux olympiques et paralympiques</a>
                    <a href="{{ route('competitions.internationales') }}">Grandes compétitions internationales</a>
                </div>
            </div>
            
            <div class="navmenu-group">
                <button class="navmenu-head" onclick="this.parentElement.classList.toggle('open')">
                    Sport &amp; Business <span class="chev">⌄</span>
                </button>
                <div class="navmenu-sub">
                    <a href="{{ route('business.economie') }}">Économie et financement</a>
                    <a href="{{ route('business.sponsoring') }}">Sponsoring et marketing</a>
                    <a href="{{ route('business.gouvernance') }}">Gouvernance</a>
                    <a href="{{ route('business.infrastructures') }}">Infrastructures</a>
                    <a href="{{ route('business.medias') }}">Médias et droits sportifs</a>
                    <a href="{{ route('business.innovation') }}">Innovation</a>
                    <a href="{{ route('business.metiers') }}">Métiers et carrières</a>
                    <a href="{{ route('business.entrepreneuriat') }}">Entrepreneuriat sportif</a>
                </div>
            </div>
            
            <a class="navmenu-link" href="{{ route('videos') }}">Vidéos</a>
            <a class="navmenu-link" href="{{ route('magazine') }}">Magazine</a>
        </div>
        
        <hr class="drawer-divider"/>
        <div class="drawer-label">Suivez-nous</div>
        <div class="socials">
            <a class="schip" href="#">LinkedIn</a>
            <a class="schip" href="#">Facebook</a>
        </div>
        
        <hr class="drawer-divider"/>
        <div class="drawer-label">Tous les sites du groupe Mian</div>
        <div class="groupe-row">
            <div class="groupe-scroll">
                <a class="gbadge on" href="#" style="background:#C81D25">Mian<br/>Sport</a>
                <a class="gbadge" href="#" style="background:#14100E">Mian<br/>Media</a>
                <a class="gbadge" href="#" style="background:#1B2A4A">Mian<br/>Business</a>
                <a class="gbadge" href="#" style="background:#5C2A6B">Mian<br/>Culture</a>
                <a class="gbadge" href="#" style="background:#0F6E56">Mian<br/>Monde</a>
                <a class="gbadge" href="#" style="background:#B8862F">Mian<br/>Tech</a>
            </div>
            <button aria-label="Voir plus" class="garrow">→</button>
        </div>
    </div>
</div>

<div class="ticker">
    <span class="ticker-label">En continu</span>
    <div class="ticker-track-wrap">
        <div class="ticker-track">
            <span>Football — Les Éléphants qualifiés pour les demi-finales de la CAN</span>
            <span>Basketball — Wembanyama porte-drapeau de l'équipe de France</span>
            <span>Tennis — Sinner conserve sa place de N°1 mondial</span>
            <span>Athlétisme — Nouveau record national du 100m à Abidjan</span>
            <span>Football — Les Éléphants qualifiés pour les demi-finales de la CAN</span>
            <span>Basketball — Wembanyama porte-drapeau de l'équipe de France</span>
        </div>
    </div>
</div>

<nav class="mainnav">
    <div class="wrap mainnav-row">
        <a href="{{ route('home') }}" class="mn {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
        
        <div class="mn-dropdown">
            <a href="{{ route('actu') }}" class="mn {{ request()->routeIs('actu*') ? 'active' : '' }}">Actualités</a>
            <div class="mn-panel">
                <div class="mn-panel-title">Actualités</div>
                <div class="mn-panel-grid">
                    <a href="{{ route('actu', ['section' => 'Dernières actualités']) }}">Dernières actualités</a>
                    <a href="{{ route('actu', ['section' => 'Portraits']) }}">Portraits & Interviews</a>
                    <a href="{{ route('actu', ['section' => 'Dossiers']) }}">Dossiers, analyses et enquêtes</a>
                </div>
            </div>
        </div>
        
        <div class="mn-dropdown">
            <a href="{{ route('football') }}" class="mn {{ request()->routeIs('football*') ? 'active' : '' }}">Football</a>
        </div>
        
        <div class="mn-dropdown">
            <a href="{{ route('basketball') }}" class="mn {{ request()->routeIs('basketball*') ? 'active' : '' }}">Basketball</a>
        </div>
        
        <div class="mn-dropdown">
            <a class="mn">Tous les sports</a>
            <div class="mn-panel">
                <div class="mn-panel-title">Tous les sports</div>
                <div class="mn-panel-grid">
                    <a href="{{ route('sports.collectifs') }}">Autres sports collectifs</a>
                    <a href="{{ route('sports.combats') }}">Combat et arts martiaux</a>
                    <a href="{{ route('sports.ath&course') }}">Athlétisme, course et multisports</a>
                    <a href="{{ route('sports.raquette') }}">Sports de raquette</a>
                    <a href="{{ route('sports.cyclisme') }}">Cyclisme</a>
                    <a href="{{ route('sports.mecaniques') }}">Sports mécaniques</a>
                    <a href="{{ route('sports.aquatiques') }}">Sports aquatiques et nautiques</a>
                    <a href="{{ route('sports.gymnastique') }}">Gymnastique, force et disciplines artistiques</a>
                    <a href="{{ route('sports.precision') }}">Sports de précision et d'adresse</a>
                    <a href="{{ route('sports.glisse') }}">Glisse, outdoor et sports urbains</a>
                    <a href="{{ route('sports.equestres') }}">Sports équestres et hippisme</a>
                    <a href="{{ route('sports.esport') }}">E-sport et sports de l'esprit</a>
                    <a href="{{ route('sports.az') }}">Toutes les disciplines de A à Z</a>
                </div>
            </div>
        </div>
        
        <div class="mn-dropdown dropdown-align-right">
            <a href="{{ route('univers') }}" class="mn {{ request()->routeIs('univers*') ? 'active' : '' }}">Univers</a>
            <div class="mn-panel">
                <div class="mn-panel-title">Univers</div>
                <div class="mn-panel-grid">
                    <a href="{{ route('univers.feminin') }}">Sport féminin</a>
                    <a href="{{ route('univers.parasport') }}">Parasport</a>
                    <a href="{{ route('univers.jeunesse') }}">Jeunesse et formation</a>
                    <a href="{{ route('univers.traditionnels') }}">Sports traditionnels africains</a>
                </div>
            </div>
        </div>
        <div class="mn-dropdown dropdown-align-right">
            <a href="{{ route('business') }}" class="mn {{ request()->routeIs('business*') ? 'active' : '' }}">Sport & Business</a>
        </div>
        
        <div class="mn-dropdown dropdown-align-right">
            <a href="{{ route('competitions') }}" class="mn {{ request()->routeIs('competitions*') ? 'active' : '' }}">Compétitions</a>
        </div>
        
       <div class="mn-dropdown dropdown-align-right">
            <a href="{{ route('business') }}" class="mn {{ request()->routeIs('business*') ? 'active' : '' }}">Sport & Business</a>
        </div>
        
        <a href="{{ route('videos') }}" class="mn {{ request()->routeIs('videos*') ? 'active' : '' }}">Vidéo</a>
        
        <div class="mn-dropdown">
            <a href="{{ route('magazine') }}" class="mn {{ request()->routeIs('magazine*') ? 'active' : '' }}">Magazine</a>
        </div>
    </div>
</nav>
</header>