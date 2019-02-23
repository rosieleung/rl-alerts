jQuery(function () {
	// Allows alerts to be hidden clientside (using localstorage)
	init_rl_alerts();
});

function init_rl_alerts() {
	var $alert_container = jQuery('#rl-alerts');
	if ( !$alert_container.length ) return;
	if ( !supports_html5_storage() ) return;

		var get_hidden_ids = function () {
			var ids = localStorage.getItem('alert_hidden_ids');
			if ( ids == null ) return [];
			return ids.toString().split(',');
		};

		var add_hidden_id = function ( id ) {
			var ids = get_hidden_ids();

			if ( !is_alert_hidden(id) ) {
				ids.push(id);

				// Hide the ID locally (local storage)
				localStorage.setItem('alert_hidden_ids', ids.join(','));
			}
		};

		var is_alert_hidden = function ( id ) {
			return (id > 0 && get_hidden_ids().indexOf(id.toString()) >= 0);
		};

		var alert_hide = function ( id ) {
			var $target = $alert_container.find('.rl-alert-item[data-id=' + id + ']');

			if ( $target.length ) {
				$target.css("display", "none");

				// Remember that this alert is hidden
				add_hidden_id(id);
			} else {
				console.log('Tried to remove an alert, but the element is not an ".alert-item": ', id);
			}
		};

		// -------

		var $alerts = jQuery('.rl-alert-item');
		var visiblealertcount = 0;
		var alertIDsOnThisPage = [];
		var alertIDsToMaybeHide = [];
		$alerts.each(function () {
			var id = jQuery(this).data('id');
			alertIDsOnThisPage.push(id.toString());

			// anticipate hiding already-hidden alerts on load
			// (don't actually hide them unless all alerts are already hidden)
			if ( is_alert_hidden(id) ) {
				alertIDsToMaybeHide.push(id);
			} else {
				visiblealertcount++;
			}
		});

		// if only some of the alerts are hidden, we're going to show them all anyway instead of showing
		// the alert bar (for visible alerts) and the alert icon (for hidden alerts) simultaneously

		if ( visiblealertcount > 0 ) {
			// some alerts are visible, so show them all
			jQuery("body").addClass("rl-alerts-visible");
		} else {
			// all alerts are hidden, so hide them all
			jQuery("body").addClass("rl-alerts-hidden");
			for ( var i in alertIDsToMaybeHide ) {
				if ( alertIDsToMaybeHide.hasOwnProperty(i) ) {
					alert_hide(alertIDsToMaybeHide[i]);
				}
			}
		}

		// Add the close button
		var $close = jQuery("#rl-alerts-close");
		if ( $close.length ) {
			$close.on('click', function () {
				jQuery("body").removeClass("rl-alerts-visible").addClass("rl-alerts-hidden");
				add_hidden_id(alertIDsOnThisPage);
				return false;
			});
		}

		// clicking the tag unhides the main alerts area
		var $alertsTag = jQuery("#rl-alerts-tag");
		if ( $alertsTag.length ) {
			$alertsTag.click(function () {

				// remove the alerts on this page from the hidden alerts list
				var ids = get_hidden_ids();
				for ( var i in alertIDsOnThisPage ) {
					if ( alertIDsOnThisPage.hasOwnProperty(i) ) {
						var key = ids.indexOf(alertIDsOnThisPage[i]);
						if ( key !== -1 ) ids.splice(key, key + 1);
					}
				}

				localStorage.setItem('alert_hidden_ids', ids.join(','));

				jQuery("body").removeClass("rl-alerts-hidden").addClass("rl-alerts-visible");
				$alerts.css("display", "block");

				return false;
			})
		}


}


function supports_html5_storage() {
	try {
		return 'localStorage' in window && window['localStorage'] !== null;
	} catch ( e ) {
		return false;
	}
}