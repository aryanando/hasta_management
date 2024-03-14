 // Default Laravel bootstrapper, installs axios
 import './bootstrap';

 // Added: Actual Bootstrap JavaScript dependency
import 'bootstrap';

 // Added: Popper.js dependency for popover support in Bootstrap
import '@popperjs/core';

import jQuery from 'jquery';
window.$ = jQuery;
