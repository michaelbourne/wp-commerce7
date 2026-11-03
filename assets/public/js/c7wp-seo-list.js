/**
 * Remove the crawler wine list once Commerce7 has drawn into its mount.
 * The list stays in the HTML for agents that do not run JavaScript.
 */
(function () {
	var list = document.querySelector('.c7wp-seo-wines');
	var slot = document.getElementById('c7-content');

	if (!list || !slot) {
		return;
	}

	function ready() {
		return !slot.isConnected || slot.childElementCount > 0;
	}

	function drop() {
		if (list.parentNode) {
			list.parentNode.removeChild(list);
		}
	}

	if (ready()) {
		drop();
		return;
	}

	var observer = new MutationObserver(function () {
		if (ready()) {
			observer.disconnect();
			drop();
		}
	});

	observer.observe(slot, { childList: true, subtree: true });
	if (slot.parentNode) {
		observer.observe(slot.parentNode, { childList: true });
	}
})();
