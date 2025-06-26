import Persistent from '@typo3/backend/storage/persistent.js';
import DocumentService from '@typo3/core/document-service.js';

    DocumentService.ready().then(() => {
      let selectors = {
        button: 'button[data-b13-collapse]',
        toolbarContainer: '.t3-page-ce-header',
        rightToolbarContainer: '.t3-page-ce-header-right > .btn-toolbar'
      };
      document.querySelectorAll(selectors.button).forEach((btn) => {
        const substituteContent = JSON.parse(btn.dataset.b13Title);
        // move each element to the right spot first.
        let toolbar = btn.closest(selectors.toolbarContainer);
        btn.remove();
        if (document.querySelector(btn.dataset.bsTarget) == null) {
          // no element-preview
          return;
        }
        toolbar.querySelector(selectors.rightToolbarContainer).append(btn);
        const substituteNode = document.createElement('div');
        substituteNode.innerHTML = '<strong>' + substituteContent['title'] + '</strong>' + ' ' + substituteContent['type'];
        substituteNode.classList.add('p-2');

        // Update the correct status as we are unable to modify the templates
        document.querySelector(btn.dataset.bsTarget).classList.add('collapse');
        if (btn.getAttribute('aria-expanded') == 'true') {
          document.querySelector(btn.dataset.bsTarget).classList.add('show');
          substituteNode.classList.add('d-none');
        }
        // Add event handles to update BE_USERs->uc when collapse/show is used
        // The CE is expanded again
        document.querySelector(btn.dataset.bsTarget).addEventListener('show.bs.collapse', () => {
          Persistent.removeFromList('B13.Collapse', btn.dataset.b13Collapse);
          substituteNode.classList.add('d-none');
        });
        // The CE is about to be collapsed
        document.querySelector(btn.dataset.bsTarget).addEventListener('hide.bs.collapse', () => {
          if (Persistent.isset('B13.Collapse') === false) {
            Persistent.set('B13.Collapse','');
          }
          Persistent.addToList('B13.Collapse', btn.dataset.b13Collapse);
          substituteNode.classList.remove('d-none');
        });

        // Add the substitute content
        document.querySelector(btn.dataset.bsTarget).parentNode.prepend(substituteNode);
      });
    });
