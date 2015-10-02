Updates in this fork

Bug fixes:

* fixed incorrect display of SRM mask in Firefox based browsers
* fixed invalid keg state when a keg is kicked
* RPints now updates keg pours (and other stuff) to remote browser displays
* the tap form no longer requires input of associated alamode pin (see below)

New features:
* tap valve control: a tap can now have a valve associated, which shuts the tap off or turns it on. This is controlled from the admin panel. The hardware is controlled via the Raspberry Pi's GPIO, and can be configured in the admin panel
* fan (line cooling) control: RPINTS can now control a fan (or line cooling) output. The pin is configured in the admin panel. Two times can be set: the trigger time is the interval when the fan is turned on, and the fan time is the time how long the fan is running after it has been turned on
* New tap configuration panel: There is a new panel in the admin section that configures the taps and its associated hardware pins. If configured to use flow counters, the pin associated with each tap can be set here. If configured for tap valve control, the GPIO pin for the tap can be set here. This no longer makes it necessary to enter the flow pin in the tap list when tapping a keg. This panel also has the controls for the fan, if thats configured.

Requirements:
* requires PyWebsockets: please read https://github.com/google/pywebsocket/wiki and follow the instructions for a standalone server

Issues:
* The RPINTS install has been modified, but has not been tested.