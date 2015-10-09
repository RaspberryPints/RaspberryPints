var websocket;
var scheme = window.location.protocol == 'https:' ? 'wss://' : 'ws://';
var defaultAddress = scheme + window.location.host + ':8081/rpupdate';

var showTimeStamp = false;
var thelog = [];
var count;

function getTimeStamp() {
	return new Date().getTime();
}

// debugging..
function addToLog(log) {
	thelog.push(log);
	if (thelog.length > 300) {
		thelog.pop();
	}
}

function send(msg) {
	if (!websocket) {
		addToLog('Send: Not connected');
		return;
	}

	websocket.send(msg);
	addToLog('> ' + msg);
}

function wsclose() {
	if (!websocket) {
		addToLog('Close: Not connected');
		return;
	}
	send("RPK");
	websocket.close();
}

function wsconnect() {
	var url = defaultAddress;
    window.addEventListener("unload", wsclose, false);
    window.onbeforeunload = wsclose;
	
	websocket = new WebSocket(url);
		
	websocket.onopen = function() {
		var logMessage = 'Opened';
		addToLog(logMessage);
	};

	websocket.onmessage = function(event) {
		addToLog("received message: " + event.data);
		parse = event.data.split(":");
		if (parse[0] == "RPU") {
			count = count + 1;
			addToLog("update number: " + count);
			window.location.reload();
		}
	};

	websocket.onerror = function() {
		var logMessage = 'Error';
		addToLog(logMessage);
	};

	websocket.onclose = function(event) {
		var logMessage = 'Closed (';
		addToLog(logMessage + ')');
	}
}

function wsinit() {
	if (!('WebSocket' in window)) {
		addToLog('WebSocket is not available');
	}
}
