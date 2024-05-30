/**
 * Detects content elements to enable expand/collapse
 */
define([
  'TYPO3/CMS/Core/DocumentService',
  'TYPO3/CMS/Backend/Storage/Persistent',
], function (DocumentService, PersistentStorage) {
    let selectors = {
      contentButton: '.t3-page-ce-header button[data-b13-collapse]',
      toolbarContainer: '.t3-page-ce-header',
      rightToolbarContainer: '.t3-page-ce-header-right > .btn-toolbar .btn-group',
      columnButton: '.t3-page-column-header button[data-b13-collapse]'
    };

    let initialize = (btn) => {
      // Update the correct status as we are unable to modify the templates
      document.querySelector(btn.dataset.bsTarget).classList.add('collapse');

      if (btn.ariaExpanded == 'true') {
        document.querySelector(btn.dataset.bsTarget).classList.add('show');
      }
      // Add event handles to update BE_USERs->uc when collapse/show is used
      // The CE is expanded again
      document.querySelector(btn.dataset.bsTarget).addEventListener('show.bs.collapse', () => {
        PersistentStorage.removeFromList('B13.Collapse', btn.dataset.b13Collapse);
      });
      // The CE is about to be collapsed
      document.querySelector(btn.dataset.bsTarget).addEventListener('hide.bs.collapse', () => {
        PersistentStorage.addToList('B13.Collapse', btn.dataset.b13Collapse);
      });
    };

    DocumentService.ready().then(() => {
      document.querySelectorAll(selectors.contentButton).forEach((btn) => {
        let toolbar = btn.closest(selectors.toolbarContainer);
        btn.remove();
        toolbar.querySelector(selectors.rightToolbarContainer).append(btn);

        const substituteContent = JSON.parse(btn.dataset.b13Title);
        const substituteNode = document.createElement('div');
        substituteNode.innerHTML = '<strong>' + substituteContent['title'] + '</strong>' + ' ' + substituteContent['type'];
        substituteNode.classList.add('p-2');

        initialize(btn);

        if (btn.ariaExpanded == 'true') {
          substituteNode.classList.add('d-none');
        }
        document.querySelector(btn.dataset.bsTarget).addEventListener('show.bs.collapse', () => {
          substituteNode.classList.add('d-none');
        });
        document.querySelector(btn.dataset.bsTarget).addEventListener('hide.bs.collapse', () => {
          substituteNode.classList.remove('d-none');
        });
        document.querySelector(btn.dataset.bsTarget).parentNode.prepend(substituteNode);
      });


      document.querySelectorAll(selectors.columnButton).forEach((btn) => {
        initialize(btn);
      });
    });
});
