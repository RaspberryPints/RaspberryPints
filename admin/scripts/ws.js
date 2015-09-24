var socket = null;
var scheme = window.location.protocol == 'https:' ? 'wss://' : 'ws://';
var defaultAddress = scheme + window.location.host + '/rpupdate';

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
	if (!socket) {
		addToLog('Send: Not connected');
		return;
	}

	socket.send(msg);
	addToLog('> ' + msg);
}

function wsconnect() {
	var url = defaultAddress;
	window.onunload = wsclose;
	
	socket = new WebSocket(url);

	socket.onopen = function() {
		var logMessage = 'Opened';
		addToLog(logMessage);
	};

	socket.onmessage = function(event) {
		addToLog("received message: " + event.data);
		parse = event.data.split(":");
		if (parse[0] == "RPU") {
			count = count + 1;
			addToLog("update number: " + count);
			window.location.reload();
		}
	};

	socket.onerror = function() {
		addToLog('Error');
	};

	socket.onclose = function(event) {
		var logMessage = 'Closed (';
		addToLog(logMessage + ')');
	};
}

function wsclose() {
	if (!socket) {
		addToLog('Close: Not connected');
		return;
	}
	socket.close();
}

function wsinit() {
	if (!('WebSocket' in window)) {
		addToLog('WebSocket is not available');
	}
}
