/**
 * Detects content elements to enable expand/collapse
 */
define([
  'TYPO3/CMS/Core/DocumentService',
  'TYPO3/CMS/Backend/Storage/Persistent',
], function (DocumentService, PersistentStorage) {
    let selectors = {
      button: 'button[data-b13-collapse]',
      toolbarContainer: '.t3-page-ce-header',
      rightToolbarContainer: '.t3-page-ce-header-icons-right > .btn-toolbar'
    };

    DocumentService.ready().then(() => {
      document.querySelectorAll(selectors.button).forEach((btn) => {
        // move each element to the right spot first.
        let toolbar = btn.closest(selectors.toolbarContainer);
        btn.remove();
        toolbar.querySelector(selectors.rightToolbarContainer).append(btn);

        // Update the correct status as we are unable to modify the templates
        document.querySelector(btn.dataset.bsTarget).classList.add('collapse');
        if (btn.ariaExpanded == 'true') {
          document.querySelector(btn.dataset.bsTarget).classList.add('show');
        }
        // Update BE_USERs->uc when collapse/show is used
        document.querySelector(btn.dataset.bsTarget).addEventListener('show.bs.collapse', () => {
          PersistentStorage.addToList('B13.Collapse', btn.dataset.b13Collapse);
        });
        document.querySelector(btn.dataset.bsTarget).addEventListener('hide.bs.collapse', () => {
          PersistentStorage.removeFromList('B13.Collapse', btn.dataset.b13Collapse);
        });
      });
    });
});
