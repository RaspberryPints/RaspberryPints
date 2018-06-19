#!/bin/bash
export DISPLAY=":0.0"
WID=$(xdotool search --onlyvisible --class chromium|head -1)
if [ $WID ]; then
	xdotool windowactivate ${WID}
	xdotool key ctrl+F5
fi
