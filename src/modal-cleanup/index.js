/**
 * Removes duplicate breadcrumbs injected by the FAU Elemental theme's modal navigation.
 */
const removeThemeModalBreadcrumbs = () => {
	const nodes = document.querySelectorAll(
		'.menu-meta-nav__modal__content .menu-modal__breadcrumbs'
	);

	if (!nodes.length) {
		return;
	}

	nodes.forEach((breadcrumb) => {
		const parent = breadcrumb.parentNode;
		if (parent) {
			parent.removeChild(breadcrumb);
		}
	});
};

document.addEventListener('DOMContentLoaded', () => {
	removeThemeModalBreadcrumbs();

	if (typeof MutationObserver === 'undefined') {
		return;
	}

	const observer = new MutationObserver(() => {
		removeThemeModalBreadcrumbs();
	});

	observer.observe(document.body, {
		childList: true,
		subtree: true,
	});
});
