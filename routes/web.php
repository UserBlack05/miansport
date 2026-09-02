<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\magazineController;  
use App\Http\Controllers\AutresSportsCollectifsController;  
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ActuController;   
use App\Http\Controllers\BasketballController; 
use App\Http\Controllers\FootballController;  
use App\Http\Controllers\ApiController;  
use App\Http\Controllers\athlethisteController;  
use App\Http\Controllers\combatController;
use App\Http\Controllers\raquetteController;
use App\Http\Controllers\Api\WordPressImportController;
use App\Http\Controllers\ArticleController;

 
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Actualités
Route::prefix('actualites')->group(function () {
    Route::get('/', function () { return view('actu.index'); })->name('actu');
    Route::get('/analyses', function () { return view('actu.analyses'); })->name('analyses');
    Route::get('/interviews', function () { return view('actu.interviews'); })->name('interviews');
    Route::get('/portraits', function () { return view('actu.portraits'); })->name('portraits');
    Route::get('/dossiers', function () { return view('actu.dossiers'); })->name('dossiers');
});

// Football
Route::prefix('football')->group(function () {
    Route::get('/', function () { return view('football.index'); })->name('football');
    Route::get('/cote-ivoire', function () { return view('football.ivoire'); })->name('football.ivoire');
    Route::get('/afrique', function () { return view('football.afrique'); })->name('football.afrique');
    Route::get('/international', function () { return view('football.international'); })->name('football.international');
    Route::get('/feminin', function () { return view('football.feminin'); })->name('football.feminin');
    Route::get('/futsal', function () { return view('football.futsal'); })->name('football.futsal');
    Route::get('/beach-soccer', function () { return view('football.beach'); })->name('football.beach');
});

// Basketball
Route::prefix('basketball')->group(function () {
    Route::get('/', function () { return view('basketball.index'); })->name('basketball');
    Route::get('/cote-ivoire', function () { return view('basketball.ivoire'); })->name('basketball.ivoire');
    Route::get('/afrique', function () { return view('basketball.afrique'); })->name('basketball.afrique');
    Route::get('/international', function () { return view('basketball.international'); })->name('basketball.international');
    Route::get('/feminin', function () { return view('basketball.feminin'); })->name('basketball.feminin');
});

// Tous les sports
Route::prefix('sports')->group(function () {
    Route::get('/collectifs', function () { return view('sports.collectifs'); })->name('sports.collectifs');
    Route::get('/combat', function () { return view('sports.combat'); })->name('sports.combat');
    Route::get('/athletisme', function () { return view('sports.athletisme'); })->name('sports.athletisme');
    Route::get('/raquette', function () { return view('sports.raquette'); })->name('sports.raquette');
    Route::get('/cyclisme', function () { return view('sports.cyclisme'); })->name('sports.cyclisme');
    Route::get('/mecaniques', function () { return view('sports.mecaniques'); })->name('sports.mecaniques');
    Route::get('/aquatiques', function () { return view('sports.aquatiques'); })->name('sports.aquatiques');
    Route::get('/gymnastique', function () { return view('sports.gymnastique'); })->name('sports.gymnastique');
    Route::get('/precision', function () { return view('sports.precision'); })->name('sports.precision');
    Route::get('/glisse', function () { return view('sports.glisse'); })->name('sports.glisse');
    Route::get('/equestres', function () { return view('sports.equestres'); })->name('sports.equestres');
    Route::get('/esport', function () { return view('sports.esport'); })->name('sports.esport');
    Route::get('/az', function () { return view('sports.az'); })->name('sports.az');
});

// Sport & Business
Route::prefix('business')->group(function () {
    Route::get('/economie', function () { return view('business.economie'); })->name('business.economie');
    Route::get('/sponsoring', function () { return view('business.sponsoring'); })->name('business.sponsoring');
    Route::get('/gouvernance', function () { return view('business.gouvernance'); })->name('business.gouvernance');
    Route::get('/infrastructures', function () { return view('business.infrastructures'); })->name('business.infrastructures');
    Route::get('/medias', function () { return view('business.medias'); })->name('business.medias');
    Route::get('/innovation', function () { return view('business.innovation'); })->name('business.innovation');
    Route::get('/metiers', function () { return view('business.metiers'); })->name('business.metiers');
    Route::get('/entrepreneuriat', function () { return view('business.entrepreneuriat'); })->name('business.entrepreneuriat');
});

// Compétitions
Route::prefix('competitions')->group(function () {
    Route::get('/', function () { return view('competitions.index'); })->name('competitions');
    Route::get('/ivoiriennes', function () { return view('competitions.ivoiriennes'); })->name('competitions.ivoiriennes');
    Route::get('/africaines', function () { return view('competitions.africaines'); })->name('competitions.africaines');
    Route::get('/olympiques', function () { return view('competitions.olympiques'); })->name('competitions.olympiques');
    Route::get('/internationales', function () { return view('competitions.internationales'); })->name('competitions.internationales');
});

// Univers
Route::prefix('univers')->group(function () {
    Route::get('/', function () { return view('univers.index'); })->name('univers');
    Route::get('/feminin', function () { return view('univers.feminin'); })->name('univers.feminin');
    Route::get('/parasport', function () { return view('univers.parasport'); })->name('univers.parasport');
    Route::get('/jeunesse', function () { return view('univers.jeunesse'); })->name('univers.jeunesse');
    Route::get('/traditionnels', function () { return view('univers.traditionnels'); })->name('univers.traditionnels');
    Route::get('/sante', function () { return view('univers.sante'); })->name('univers.sante');
});

// Vidéos
Route::get('/videos', function () { return view('videos.index'); })->name('videos');

// Magazine
Route::prefix('magazine')->group(function () {
    Route::get('/', function () { return view('magazine.index'); })->name('magazine');
    Route::get('/{id}', function ($id) { return view('magazine.show', compact('id')); })->name('magazine.show');
});

Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::prefix('magazine')->group(function () {
    Route::get('/', [MagazineController::class, 'index'])->name('magazine');
    Route::get('/{id}', [MagazineController::class, 'show'])->name('magazine.show');
});

Route::prefix('videos')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos');
    Route::get('/{id}', [VideoController::class, 'show'])->name('videos.show');
});

Route::get('/actualites', [ActuController::class, 'index'])->name('actu');

Route::get('/buisness', [buisnessController::class, 'index'])->name('buisness');

Route::get('/sports/collectifs', [AutresSportsCollectifsController::class, 'index'])->name('sports.collectifs');

Route::get('/sports/basketball', [BasketballController::class, 'index'])->name('sports.Basketball');

Route::get('/sports/Football', [FootballController::class, 'index'])->name('sports.football');

Route::get('/import/articles', [ApiController::class, 'fetchPosts']);

Route::get('/sports/combat', [combatController::class, 'index'])->name('sports.combats');

Route::get('/sports/aquatique', [FootballController::class, 'index'])->name('sports.aquatique');

Route::get('/sports/athletisme&course', [athlethisteController::class, 'index'])->name('sports.ath&course');

Route::get('/sports/raquette', [raquetteController::class, 'index'])->name('sports.raquette');

Route::get('/sports/Football', [FootballController::class, 'index'])->name('sports.football');

Route::prefix('import')->group(function () {
    // Lancer l'importation
     Route::get('/wordpress', [WordPressImportController::class, 'import']);
    
    // Importer UNIQUEMENT les catégories
    Route::get('/categories', [WordPressImportController::class, 'importCategories']);
    
    // Voir le statut de l'importation
    Route::get('/status', [WordPressImportController::class, 'status']);

    Route::get('/clear', [WordPressImportController::class, 'clear']);
});