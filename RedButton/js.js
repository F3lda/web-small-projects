cleanUpCheck = false;

function postDone() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
			if (xmlhttp.status == 200) {
				alert(xmlhttp.responseText);
			} else {
				alert("Chyba: " + xmlhttp.status);
			}
		}
	};
	xmlhttp.open("POST", "./", true); // async
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
	xmlhttp.send("cmd=jop");
}

function onLoad() {
	new Image().src = "button-ready-low.png";
	new Image().src = "button-pushed-low.png"
	document.getElementById("name").style.display = 'none';
	document.getElementById("exit").style.display = 'none';
}

function requestFullScreen(element) {
    // Supports most browsers and their versions.
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}

function cancelFullScreen(el) {
	var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
	if (requestMethod) { // cancel full screen.
		requestMethod.call(el);
	} else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
		var wscript = new ActiveXObject("WScript.Shell");
		if (wscript !== null) {
			wscript.SendKeys("{F11}");
		}
	}
}

function fullscreen(show) {
    var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
        (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
        (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
        (document.msFullscreenElement && document.msFullscreenElement !== null);

    var docElm = document.documentElement;
    if (show) {
        if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
        } else if (docElm.mozRequestFullScreen) {
            docElm.mozRequestFullScreen();
        } else if (docElm.webkitRequestFullScreen) {
            docElm.webkitRequestFullScreen();
        } else if (docElm.msRequestFullscreen) {
            docElm.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

function onPushed(imgId)
{
	if(imgId.src.indexOf("button-pushed-low.png") == -1) {
		imgId.src = "button-pushed-low.png";
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
				if (xmlhttp.status == 200) {
					if(xmlhttp.responseText != ""){
						alert("Chyba: " + xmlhttp.responseText);
					} else {
						var checkExist = setInterval(function() {
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
									if (xmlhttp.status == 200) {
										if (xmlhttp.responseText == 0) {
											document.getElementById("image").src = 'button-ready-low.png';
											clearInterval(checkExist);
										} else if(xmlhttp.responseText != 1) {
											alert(xmlhttp.responseText);
										}
									} else {
										alert("Chyba: " + xmlhttp.status);
									}
								}
							};
							xmlhttp.open("POST", "./", true); // async
							xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
							xmlhttp.send("cmd=check");
						}, 1000);
					}
				} else {
					alert("Chyba: " + xmlhttp.status);
				}
			}
		};
		xmlhttp.open("POST", "./", true); // async
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
		xmlhttp.send("cmd=add&name="+document.getElementById("name").innerHTML);
	}

	//send name
	//cleanUpCheck loop
}

function ready()
{
	fullscreen(true);
	if(document.getElementById("name").innerHTML != "Jméno týmu") {
		document.getElementById("overlay").style.display = 'none';
	}
	document.getElementById("ready").style.display = 'none';
	document.getElementById("name").style.display = 'block';
	document.getElementById("exit").style.display = 'block';
}

function rename()
{
	team = prompt("Zadejte jméno týmu:", "");
	if(team != "" && team != null) {
		document.getElementById("name").innerHTML = team;
		document.getElementById("overlay").style.display = 'none';
	}
	fullscreen(true);
}

function exit()
{
	document.getElementById("ready").style.display = 'inline-block';
	document.getElementById("overlay").style.display = 'block';
	document.getElementById("name").style.display = 'none';
	document.getElementById("exit").style.display = 'none';
	document.getElementById("image").src = 'button-ready-low.png';
	cleanUpCheck = false;
	fullscreen(false);
}

function restart()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
			if (xmlhttp.status == 200) {
				document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
			} else {
				alert("Chyba: " + xmlhttp.status);
			}
		}
	};
	xmlhttp.open("POST", "./", true); // async
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
	xmlhttp.send("cmd=delete");
}

function save(nick)
{
	if(confirm("Potvrdit <"+nick+"> jako vítěze kola?")){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
				if (xmlhttp.status == 200) {
					document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
				} else {
					alert("Chyba: " + xmlhttp.status);
				}
			}
		};
		xmlhttp.open("POST", "./", true); // async
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
		xmlhttp.send("cmd=save&team="+nick);
	}
}

function resutlsCheck()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
			if (xmlhttp.status == 200) {
				if (xmlhttp.responseText != 5) {
					document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
				} else {
					alert("Chyba: 5");
				}
			} else {
				alert("Chyba: " + xmlhttp.status);
			}
		}
	};
	xmlhttp.open("POST", "./", true); // async
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
	xmlhttp.send("cmd=preResults");
		
	var checkExist = setInterval(function() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
				if (xmlhttp.status == 200) {
					if (xmlhttp.responseText != 5) {
						document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
					} else {
						alert("Chyba: 5");
					}
				} else {
					alert("Chyba: " + xmlhttp.status);
				}
			}
		};
		xmlhttp.open("POST", "./", true); // async
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
		xmlhttp.send("cmd=preResults");
	}, 1000);
}

function deleteAll()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
			if (xmlhttp.status == 200) {
				if (xmlhttp.responseText != 5) {
					document.getElementById("results").innerHTML = "<tr><th>Jméno týmu</th><th>Počet výher</th><th>Celkové pořadí</th></tr>"+xmlhttp.responseText;
				} else {
					alert("Chyba: 5");
				}
			} else {
				alert("Chyba: " + xmlhttp.status);
			}
		}
	};
	xmlhttp.open("POST", "./", true); // async
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // POST
	xmlhttp.send("cmd=deleteall");
}