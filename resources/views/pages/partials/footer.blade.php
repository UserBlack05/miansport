<footer>
    <div class="wrap">
        <div class="fcols">
            <div class="fcol fcol-brand">
                <div class="flogo">Mian<span>Sport</span></div>
                <p>L'actualité sportive africaine et internationale, décryptée par la rédaction. Un site du groupe MianMedia.</p>
            </div>
            <div class="fcol">
                <h4>Liens utiles</h4>
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('sports.football') }}">Football</a>
                <a href="{{ route('sports.Basketball') }}">Basketball</a>
                <a href="{{ route('videos') }}">Vidéos</a>
                <a href="{{ route('magazine') }}">Magazines</a>
                <a href="#">À propos</a>
            </div>
            <div class="fcol">
                <h4>Contact</h4>
                <a href="#">Abidjan, Côte d'Ivoire</a>
                <a href="mailto:redaction@miansport.ci">redaction@miansport.ci</a>
                <a href="tel:+2252700000000">+225 27 00 00 00 00</a>
            </div>
            <div class="fcol">
                <h4>Réseaux sociaux</h4>
                <a href="#">LinkedIn</a>
                <a href="#">Facebook</a>
                <a href="#">YouTube</a>
            </div>
        </div>
        
        <div class="fgroup">
            <h4>Sites du groupe MianMedia</h4>
            <div class="fgroup-row">
                <a class="gchip on" href="#" style="background:#C81D25">MianSport</a>
                <a class="gchip" href="#" style="background:#14100E">MianMedia</a>
                <a class="gchip" href="#" style="background:#1B2A4A">MianBusiness</a>
                <a class="gchip" href="#" style="background:#5C2A6B">MianCulture</a>
                <a class="gchip" href="#" style="background:#0F6E56">MianMonde</a>
                <a class="gchip" href="#" style="background:#B8862F">MianTech</a>
            </div>
        </div>
        
        <div class="fbottom">
            <div>© {{ date('Y') }} MianMedia. Tous droits réservés.</div>
            <div class="flinks">
                <a href="#">Mentions légales</a>
                <a href="#">Confidentialité</a>
                <a href="#">CGU</a>
            </div>
        </div>
    </div>
</footer>