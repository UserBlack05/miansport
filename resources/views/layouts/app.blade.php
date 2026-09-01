<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MianSport — Accueil')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    
    @stack('styles')
    
    <!-- Custom Styles -->
    <style>
        :root{
            --rouge:#C81D25;
            --encre:#14100E;
            --papier:#FAF8F5;
            --ardoise:#4B4844;
            --or:#B8862F;
            --ligne:#E4DFD6;
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--papier);color:var(--encre); width: 100%;
    max-width: 100%;
    overflow-x: hidden;}
        .display{font-family:'Anton',sans-serif;letter-spacing:0.5px;line-height:0.95;text-transform:uppercase;}
        .wrap{max-width:1500px;margin:0 auto;padding:0 20px;}
        
        /* Header styles */
        header{border-bottom:1px solid var(--encre);background:white;position:relative;z-index:10;}
        .navrow{display:flex;align-items:center;justify-content:space-between;padding:5px 32px 1px;}
        .logo{display:flex;align-items:center;gap:12px;}
        .logo img{width:150px;height:70px;border-radius:6px;object-fit:cover;}
        .logo .word{font-family:'Anton',sans-serif;font-size:26px;letter-spacing:0.5px;}
        .logo .word span{color:var(--rouge);}
        .hamburger{background:none;border:none;cursor:pointer;padding:8px;display:flex;flex-direction:column;gap:5px;}
        .hamburger span{display:block;width:26px;height:3px;background:var(--encre);}
        .subscribe{background:var(--encre);color:var(--papier);border:none;padding:11px 22px;font-weight:700;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;cursor:pointer;}
        
        /* Drawer menu */
        .overlay{position:fixed;inset:0;background:rgba(20,16,14,0.55);opacity:0;pointer-events:none;transition:opacity 0.25s;z-index:20;}
        .overlay.open{opacity:1;pointer-events:auto;}
        .drawer{position:fixed;top:0;left:0;bottom:0;width:400px;max-width:88vw;background:var(--papier);transform:translateX(-100%);transition:transform 0.28s;z-index:21;overflow-y:auto;}
        .drawer.open{transform:translateX(0);}
        .drawer-top{display:flex;justify-content:flex-end;padding:18px 20px 0;}
        .drawer-close{background:none;border:none;cursor:pointer;font-size:22px;color:var(--encre);line-height:1;padding:6px;}
        .drawer-body{padding:8px 24px 36px;}
        .drawer-cta{display:flex;align-items:center;justify-content:space-between;background:var(--rouge);color:var(--papier);padding:16px 18px;font-weight:800;font-size:14px;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:28px;text-decoration:none;}
        .drawer-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:var(--ardoise);margin-bottom:14px;}
        .drawer-divider{border:none;border-top:1px solid var(--ligne);margin:26px 0;}
        .rubriques{display:flex;flex-wrap:wrap;gap:10px;}
        .rchip{border:1.5px solid var(--encre);color:var(--encre);text-decoration:none;font-size:13px;font-weight:700;padding:9px 16px;border-radius:999px;}
        .rchip.on{background:var(--encre);color:var(--papier);border-color:var(--encre);}
        .socials{display:flex;flex-wrap:wrap;gap:10px;}
        .schip{border:1.5px solid var(--ligne);color:var(--encre);text-decoration:none;font-size:13px;font-weight:600;padding:9px 16px;border-radius:999px;}
        .groupe-row{display:flex;align-items:center;gap:8px;}
        .groupe-scroll{display:flex;gap:10px;overflow-x:auto;flex:1;padding-bottom:2px;}
        .gbadge{flex:0 0 64px;height:64px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-family:'Anton',sans-serif;font-size:11px;text-align:center;line-height:1.1;padding:4px;}
        .gbadge.on{outline:2px solid var(--encre);outline-offset:2px;}
        .garrow{flex:0 0 26px;height:26px;border-radius:50%;border:1px solid var(--ligne);background:none;cursor:pointer;color:var(--ardoise);font-size:12px;}
        
        /* Navigation styles */
        .navmenu{display:flex;flex-direction:column;}
        .navmenu-link{display:block;padding:14px 0;font-weight:800;font-size:14px;text-transform:uppercase;letter-spacing:0.4px;color:var(--encre);text-decoration:none;border-bottom:1px solid var(--ligne);}
        .navmenu-group{border-bottom:1px solid var(--ligne);}
        .navmenu-head{width:100%;display:flex;justify-content:space-between;align-items:center;background:none;border:none;padding:14px 0;font-weight:800;font-size:14px;text-transform:uppercase;letter-spacing:0.4px;color:var(--encre);cursor:pointer;text-align:left;font-family:'Inter',sans-serif;}
        .navmenu-head .chev{transition:transform 0.2s;font-size:14px;color:var(--ardoise);}
        .navmenu-group.open .navmenu-head .chev{transform:rotate(180deg);}
        .navmenu-sub{max-height:0;overflow:hidden;transition:max-height 0.3s ease;}
        .navmenu-group.open .navmenu-sub{max-height:700px;}
        .navmenu-sub a{display:block;padding:9px 0 9px 14px;font-size:13px;color:var(--ardoise);text-decoration:none;border-left:2px solid var(--ligne);}
        .navmenu-sub a:hover{color:var(--rouge);border-left-color:var(--rouge);}
        
        /* Main nav */
        .mainnav{background:var(--encre);}
        .mainnav-row{display:flex;gap:18px;padding:13px 32px;overflow:hidden;}
        .mn{white-space:nowrap;color:#B8B2A8;text-decoration:none;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;}
        .mn:hover, .mn.active{color:var(--papier);}
        .mn.active{position:relative;}
        .mn.active::after{content:"";position:absolute;left:0;right:0;bottom:-13px;height:3px;background:var(--rouge);}
        
        .mn-dropdown{position:relative;display:flex;align-items:center;height:100%;}
        .mn-dropdown:hover .mn-panel, .mn-dropdown:focus-within .mn-panel{opacity:1;visibility:visible;transform:translateY(0);pointer-events:auto;}
        .mn-panel{position:absolute;top:100%;left:0;width:500px;max-width:min(720px, calc(100vw - 32px));background:var(--papier);color:var(--encre);border-top:4px solid var(--rouge);box-shadow:0 18px 40px rgba(20,16,14,.22);padding:20px 22px 22px;opacity:0;visibility:hidden;transform:translateY(8px);transition:opacity .16s ease,transform .16s ease,visibility .16s ease;pointer-events:none;z-index:50;}
        .mn-panel::before{content:"";position:absolute;top:-9px;left:22px;width:0;height:0;border-left:8px solid transparent;border-right:8px solid transparent;border-bottom:9px solid var(--rouge);}
        .mn-panel-title{font-family:'Anton',sans-serif;text-transform:uppercase;font-size:20px;letter-spacing:.3px;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--ligne);}
        .mn-panel-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));column-gap:28px;row-gap:0;}
        .mn-panel-grid a{display:block;color:var(--encre);text-decoration:none;font-size:13px;font-weight:600;line-height:1.35;padding:8px 0;border-bottom:1px solid var(--ligne);}
        .mn-panel-grid a:hover{color:var(--rouge);padding-left:4px;}
        
        /* Ticker */
        .ticker{background:var(--rouge);display:flex;align-items:stretch;overflow:hidden;}
        .ticker-label{flex:0 0 auto;background:var(--encre);color:var(--papier);font-weight:800;font-size:11px;text-transform:uppercase;letter-spacing:0.8px;padding:10px 18px;display:flex;align-items:center;}
        .ticker-track-wrap{flex:1;overflow:hidden;display:flex;align-items:center;}
        .ticker-track{display:inline-flex;gap:48px;white-space:nowrap;padding-left:100%;animation:tickerscroll 28s linear infinite;}
        .ticker-track span{font-size:12.5px;font-weight:700;color:var(--papier);}
        @keyframes tickerscroll{from{transform:translateX(0);}to{transform:translateX(-100%);}}
        
        /* Section titles */
        .sect{padding:64px 0 20px;}
        .sect-head{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:32px;border-bottom:3px solid var(--encre);padding-bottom:14px;}
        .sect-head h2{font-size:30px;}
        .sect-head a{font-size:13px;font-weight:700;color:var(--rouge);text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;}
        
        /* Grid */
        .grid{display:grid;grid-template-columns:1.3fr 1fr 1fr;gap:28px;}
        .card{display:flex;flex-direction:column;}
        .card .thumb{position:relative;aspect-ratio:4/3;overflow:hidden;margin-bottom:14px;}
        .card .thumb img{width:100%;height:100%;object-fit:cover;display:block;}
        .card .thumb .ph{width:100%;height:100%;display:flex;align-items:flex-end;padding:16px;}
        .tag{position:absolute;top:12px;left:0;background:var(--rouge);color:var(--papier);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;padding:5px 14px;}
        .card h3{font-size:20px;line-height:1.2;margin-bottom:8px;}
        .card p{font-size:13.5px;color:var(--ardoise);line-height:1.55;}
        .card.lg h3{font-size:26px;}
        
        /* Placeholder backgrounds */
        .basket .ph, .ph.basket{background:repeating-linear-gradient(135deg,#8a4a12,#8a4a12 22px,#7a4110 22px,#7a4110 44px);}
        .tennis .ph, .ph.tennis{background:repeating-linear-gradient(90deg,#5b7d2e,#5b7d2e 26px,#4f6d28 26px,#4f6d28 52px);}
        .athle .ph, .ph.athle{background:repeating-linear-gradient(45deg,#2b3a67,#2b3a67 24px,#243158 24px,#243158 48px);}
        .ph-label{color:rgba(255,255,255,0.9);font-weight:800;font-size:13px;text-transform:uppercase;}
        
        /* Hero */
        .hero{position:relative;min-height:450px;overflow:hidden;background:var(--encre);}
        .hero-slide{position:absolute;inset:0;display:grid;grid-template-columns:1fr 1fr;opacity:0;transition:opacity 0.6s ease;z-index:1;}
        .hero-slide.active{opacity:1;z-index:2;}
        .hero-text{padding:20px 40px;display:flex;flex-direction:column;justify-content:center;position:relative;}
        .flash{position:absolute;left:0;top:60px;background:var(--rouge);color:var(--papier);font-weight:800;font-size:13px;letter-spacing:1.5px;padding:8px 20px 8px 32px;text-transform:uppercase;}
        .hero-text h1{color:var(--papier);font-size:35px;margin:16px 0 14px;}
        .hero-text h1 .accent{color:var(--rouge);}
        .hero-text p{color:#C9C4BC;font-size:14px;line-height:1.6;max-width:420px;margin-bottom:24px;}
        .hero-meta{color:#8A857D;font-size:12px;text-transform:uppercase;letter-spacing:1px;font-weight:600;}
        .hero-img{position:relative;overflow:hidden;}
        .hero-img img{width:100%;height:100%;object-fit:cover;display:block;}
        .hero-img::after{content:"";position:absolute;inset:0;background:linear-gradient(90deg, var(--encre) 0%, transparent 18%);}
        .hero-arrow{position:absolute;top:50%;transform:translateY(-50%);width:44px;height:44px;border-radius:50%;background:rgba(20,16,14,0.45);border:1.5px solid rgba(250,248,245,0.5);color:var(--papier);font-size:20px;cursor:pointer;z-index:5;display:flex;align-items:center;justify-content:center;}
        .hero-arrow.prev{left:20px;}
        .hero-arrow.next{right:20px;}
        .hero-dots{position:absolute;bottom:22px;left:50%;transform:translateX(-50%);display:flex;gap:8px;z-index:5;}
        .hero-dot{width:9px;height:9px;border-radius:50%;background:rgba(250,248,245,0.4);border:none;cursor:pointer;padding:0;}
        .hero-dot.active{background:var(--rouge);}
        
        /* Home Rubric */
        .home-rubric{padding:56px 0 64px;border-bottom:1px solid var(--ligne);}
        .home-rubric-head{display:flex;align-items:flex-end;justify-content:space-between;border-bottom:3px solid var(--encre);padding-bottom:14px;margin-bottom:30px;}
        .home-rubric-head h2{font-family:'Anton',sans-serif;font-size:34px;text-transform:uppercase;line-height:1;}
        .home-rubric-head a{color:var(--rouge);text-decoration:none;font-size:13px;font-weight:800;text-transform:uppercase;}
        .home-rubric-head a::after{content:' →';font-size:20px;}
        
        /* Footer */
        footer{background:var(--encre);border-top:1px solid #2A241D;padding:56px 0 24px;color:#B8B2A8;}
        .fcols{display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:36px;padding-bottom:36px;border-bottom:1px solid #2A241D;margin-bottom:28px;}
        .fcol h4{color:var(--papier);font-size:12.5px;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:16px;}
        .fcol a{display:block;color:#B8B2A8;text-decoration:none;font-size:13px;margin-bottom:10px;}
        .fcol a:hover{color:var(--papier);}
        .fcol-brand .flogo{font-family:'Anton',sans-serif;color:var(--papier);font-size:22px;margin-bottom:12px;}
        .fcol-brand .flogo span{color:var(--rouge);}
        .fcol-brand p{font-size:13px;line-height:1.6;color:#8A857D;max-width:270px;}
        .fgroup{margin-bottom:28px;}
        .fgroup h4{color:var(--papier);font-size:12.5px;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:14px;}
        .fgroup-row{display:flex;flex-wrap:wrap;gap:10px;}
        .gchip{color:#fff;text-decoration:none;font-size:12px;font-weight:700;padding:8px 16px;border-radius:6px;}
        .gchip.on{outline:2px solid #B8B2A8;outline-offset:2px;}
        .fbottom{display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#6E695F;padding-top:20px;}
        .flinks{display:flex;gap:20px;}
        .searchbtn{width:42px;height:42px;border-radius:50%;border:1.5px solid var(--encre);background:none;color:var(--encre);cursor:pointer;display:flex;align-items:center;justify-content:center;}
        .searchbtn:hover{background:var(--encre);color:var(--papier);}
        .navactions{display:flex;align-items:center;gap:12px;}
        
        /* Responsive */
        @media(max-width:900px){.mainnav-row{gap:24px;overflow-x:auto;}.mn-panel{width:620px;}}
        @media(max-width:700px){.mn-panel{position:fixed;top:106px;left:16px;width:calc(100vw - 32px);max-width:none;max-height:70vh;overflow:auto;}.mn-panel-grid{grid-template-columns:1fr 1fr;}}
        @media(max-width:600px){.home-rubric,.home-magazine{padding:40px 0 48px;}.home-rubric-head h2,.home-magazine-head h2{font-size:27px;}}
    </style>
    
    @stack('page-styles')
</head>
<body>
    @include('pages.partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('pages.partials.footer')
    
    <!-- Scripts -->
    <script>
        // Drawer toggle
        function openDrawer() {
            document.getElementById('overlay').classList.add('open');
            document.getElementById('drawer').classList.add('open');
        }
        function closeDrawer() {
            document.getElementById('overlay').classList.remove('open');
            document.getElementById('drawer').classList.remove('open');
        }
        // Navmenu toggle
        document.querySelectorAll('.navmenu-head').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                this.parentElement.classList.toggle('open');
            });
        });
        // Hero slider
        const heroSlides = document.querySelectorAll('#heroSlider .hero-slide');
        const heroDots = document.querySelectorAll('.hero-dot');
        let heroIndex = 0;
        function heroShow(i){
            heroSlides.forEach((s,idx)=>s.classList.toggle('active', idx===i));
            heroDots.forEach((d,idx)=>d.classList.toggle('active', idx===i));
            heroIndex = i;
        }
        function heroNext(){ heroShow((heroIndex+1) % heroSlides.length); }
        function heroPrev(){ heroShow((heroIndex-1+heroSlides.length) % heroSlides.length); }
        function heroGoTo(i){ heroShow(i); }
        setInterval(heroNext, 6000);
    </script>
    @stack('scripts')
</body>
</html>