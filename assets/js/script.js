/**
 * ==========================================
 * SPOTIFY CLONE - Script Principal
 * ==========================================
 */

// ==========================================
// VARIÁVEIS GLOBAIS
// ==========================================
var currentPlaylist = [];      // Playlist atual sendo reproduzida
var shufflePlaylist = [];      // Playlist embaralhada
var tempPlaylist = [];         // Playlist temporária
var audioElement;              // Elemento de áudio HTML5
var mouseDown = false;         // Estado do mouse para drag
var currentIndex = 0;          // Índice da música atual
var repeat = false;            // Estado de repetição
var shuffle = false;           // Estado de embaralhamento
var userLoggedIn;             // Usuário logado
var timer;                    // Timer para search.php

// ==========================================
// EVENT LISTENERS
// ==========================================

// Esconder menu de opções ao clicar fora
$(document).click(function(click) {
	var target = $(click.target);

	if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
});

// Esconder menu de opções ao rolar a página
$(window).scroll(function() {
	hideOptionsMenu();
});

// Adicionar música à playlist selecionada
$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = $(select).val();
	var songId = $(select).prev(".songId").val();

	// Validação básica
	if (!playlistId || !songId) {
		console.error("ID da playlist ou música inválido");
		return;
	}

	// Mostrar estado de loading
	select.addClass('loading');

	$.post("includes/handlers/ajax/addToPlaylist.php", {
		playlistId: playlistId,
		songId: songId
	})
	.done(function(error) {
		if (error != "") {
			alert(error);
			return;
		}

		hideOptionsMenu();
		select.val("");
	})
	.fail(function(xhr, status, error) {
		console.error("Erro ao adicionar música:", error);
		alert("Erro ao adicionar música à playlist. Tente novamente.");
	})
	.always(function() {
		select.removeClass('loading');
	});
}); 

// ==========================================
// FUNÇÕES DE NAVEGAÇÃO
// ==========================================

/**
 * Abrir página dinamicamente via AJAX
 * @param {string} url - URL da página a ser carregada
 */
function openPage(url) {
	// Cancelar timer de busca se ativo
	if (timer != null) {
		clearTimeout(timer);
	}

	// Adicionar '?' à URL se não existir
	if (url.indexOf("?") == -1) {
		url = url + "?";
	}

	// Codificar URL e adicionar usuário logado
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);

	// Mostrar loading state
	$("#mainContent").addClass('loading');

	// Carregar conteúdo via AJAX
	$("#mainContent").load(encodedUrl, function(response, status, xhr) {
		if (status == "error") {
			console.error("Erro ao carregar página:", xhr.status, xhr.statusText);
			$("#mainContent").html("<p class='error'>Erro ao carregar conteúdo. Tente novamente.</p>");
		}
		$("#mainContent").removeClass('loading');
	});

	// Rolar para o topo
	$("body").scrollTop(0);

	// Atualizar URL do navegador (SPA behavior)
	history.pushState(null, null, url);
}

function updateEmail(emailClass) {
	var emailValue = $("." + emailClass).val();

	$.post("includes/handlers/ajax/updateEmail.php", { email:emailValue, username: userLoggedIn })
	.done(function(response) {
		$("." + emailClass).nextAll(".message").text(response);
	});
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
	var oldPassword = $("." + oldPasswordClass).val();
	var newPassword1 = $("." + newPasswordClass1).val();
	var newPassword2 = $("." + newPasswordClass2).val();2

	$.post("includes/handlers/ajax/updatePassword.php", 
	{ oldPassword: oldPassword, newPassword1: newPassword1, newPassword2: newPassword2, username: userLoggedIn})
	.done(function(response) {
		$("." + oldPasswordClass).nextAll(".message").text(response);
	});
}

function logout() {
	$.post("includes/handlers/ajax/logout.php", function() {
		location.reload();
	});
}

function removeFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
		.done(function(error) {
			
			if (error != "") {
				alert(error);
				return;
			}

			openPage("playlist.php?id=" + playlistId);
		});

}	

function createPlaylist() {
	var popup = prompt("Digite o nome da sua playlist");

	if (popup != null) {

		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		.done(function(error) {

			if (error != "") {
				alert(error);
				return;
			}

			openPage("yourMusic.php");
		});
	}
}

function deletePlaylist(playlistId) {
	var prompt = confirm("Tem certeza que deseja excluir esta playlist?");

	if (prompt == true) {

		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
		.done(function(error) {
			
			if (error != "") {
				alert(error);
				return;
			}

			openPage("yourMusic.php");
		});
	}
}

function hideOptionsMenu() {
	var menu = $(".optionsMenu");
	if (menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

function showOptionsMenu(button) {
	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionsMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop(); //distance from top of window to top of doc
	var elementOffset = $(button).offset().top; //gets pos of button from top of doc

	var top = elementOffset - scrollTop;
	var left = $(button).position().left;

	menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline "})
}

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //Rounds down
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100; //calculate percentage of time
	$(".playbackBar .progress").css("width", progress + "%"); //output as percentage of width in css for progress bar 
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100; 
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

class Audio {
	constructor() {
		this.currentlyPlaying;
        this.audio = document.createElement( 'audio' );
        //when song ends make sure to play next song
        this.audio.addEventListener("ended", function() {
            nextSong();
        });

		this.audio.addEventListener("canplay", function () {
			//'this' refers to the object that the event was called on
			var duration = formatTime(this.duration);
            $( ".progressTime.remaining" ).text( duration );
        } );

		this.audio.addEventListener("timeupdate", function () {
			if (this.duration) {
				updateTimeProgressBar(this);
			}
        } );
        
        this.audio.addEventListener("volumechange", function() {
            updateVolumeProgressBar(this);
        });
		this.setTrack = function(track) {
			this.currentlyPlaying = track;
			this.audio.src = track.path;
		};
		this.play = function () {
			this.audio.play();
		};
		this.pause = function () {
			this.audio.pause();
        };
        this.setTime = function(seconds) {
            this.audio.currentTime = seconds;
        }
	}
}
