RaspberryPints (RPints) is a digital upgrade to the conventional chalkboard taplist, created just for the home brewer. Display your current beers on tap with a sleek, digital presentation. Manage your beers, recipes, kegs, and taps with our built-in tracking system.


__Licensing:__

	GNU GENERAL PUBLIC LICENSE
	Version 3, 29 June 2007
	
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

Full license text available in 'LICENSE.md'.


Questions? Comments? Want to Contribute?
http://www.homebrewtalk.com/f51/initial-release-raspberrypints-digital-taplist-solution-456809/

Inspired by Kegerface:
http://github.com/kegerface/kegerface


__Known Bugs:__

	All versions:
	- Firefox has difficulty rendering our SRM image masks correctly.
		Due to a deficiency in the way Firefox handles z-values with images and is a known
		issue within the MDN.


__Version History:__

	v1.0.3 (hotfix):
		- Fixed broken links to (external) official website.

	v1.0.2 (hotfix):
		- Addresses excess vertical spacing introduced in v1.0.1 CSS cleanup.
		- Fixed redirect to the install directory that prevented use on virtual hosts.
	
	v1.0.1 (hotfix):
		- Removed leading underscores ( _ ) for non-beer styles on taplist front-end.
		- Removed leading underscores ( _ ) for non-beer styles on admin page "My Beers".
		- Clarified presentation of beer styles/categories on admin page "My Beers".
		- Prevented browser from caching old brewery logos, even after a new one was uploaded.
		- Cleaned up styles.css.
	
	v1.0.0 (major release):
		- First major release.
