import buttonIcon from './svg/button-icon.svg';
import { v4 as uuidv4 } from 'uuid';

/**
 * Class for working with UI:
 *  - rendering base structure
 *  - show/hide preview
 *  - apply tune view
 */
export default class Ui {
  /**
   * @param {object} ui - image tool Ui module
   * @param {object} ui.api - Editor.js API
   * @param {ImageConfig} ui.config - user config
   * @param {Function} ui.onSelectFile - callback for clicks on Select file button
   * @param {boolean} ui.readOnly - read-only mode flag
   */
  constructor({ api, config, onSelectFile, readOnly }) {
    this.api = api;
    this.config = config;
    this.onSelectFile = onSelectFile;
    this.readOnly = readOnly;
    this.nodes = {
      wrapper: make('div', [this.CSS.baseClass, this.CSS.wrapper, 'flex', 'gap-4']),
      images: [
        {
          imageContainer: make('div', [ this.CSS.imageContainer, 'flex', 'flex-col', 'flex-1' ], {'image-id':'editorjs-image-'+uuidv4()}),
          fileButton: this.createFileButton(0),
          imageEl: undefined,
          imagePreloader: make('div', this.CSS.imagePreloader),
          caption: make('div', [this.CSS.input, this.CSS.caption, 'mt-2'], {
            contentEditable: !this.readOnly,
            'data-placeholder': this.config.captionPlaceholder
          }),
        },
        {
          imageContainer: make('div', [ this.CSS.imageContainer, 'flex', 'flex-col', 'flex-1' ], {'image-id':'editorjs-image-'+uuidv4()}),
          fileButton: this.createFileButton(1),
          imageEl: undefined,
          imagePreloader: make('div', this.CSS.imagePreloader),
          caption: make('div', [this.CSS.input, this.CSS.caption, 'mt-2'], {
            contentEditable: !this.readOnly,
            'data-placeholder': this.config.captionPlaceholder
          }),
        }
      ],
      
    };

    /**
     * Create base structure
     *  <wrapper>
     *    <image-container>
     *      <image-preloader />
     *    </image-container>
     *    <caption />
     *    <select-file-button />
     *  </wrapper>
     */
     this.nodes.images.forEach((image, index) => {
      this.nodes.images[index].imageContainer.appendChild(this.nodes.images[index].imagePreloader);
      this.nodes.images[index].imageContainer.appendChild(this.nodes.images[index].caption);
      this.nodes.images[index].imageContainer.appendChild(this.nodes.images[index].fileButton);

      this.nodes.wrapper.appendChild(this.nodes.images[index].imageContainer);
     });
  }

  /**
   * CSS classes
   *
   * @returns {object}
   */
  get CSS() {
    return {
      baseClass: this.api.styles.block,
      loading: this.api.styles.loader,
      input: this.api.styles.input,
      button: this.api.styles.button,

      /**
       * Tool's classes
       */
      wrapper: 'image-tool',
      imageContainer: 'image-tool__image',
      imagePreloader: 'image-tool__image-preloader',
      imageEl: 'image-tool__image-picture',
      caption: 'image-tool__caption',
    };
  };

  /**
   * Ui statuses:
   * - empty
   * - uploading
   * - filled
   *
   * @returns {{EMPTY: string, UPLOADING: string, FILLED: string}}
   */
  static get status() {
    return {
      EMPTY: 'empty',
      UPLOADING: 'loading',
      FILLED: 'filled',
    };
  }

  /**
   * Renders tool UI
   *
   * @param {ImageToolData} toolData - saved tool data
   * @returns {Element}
   */
  render(toolData) {
    let status = Ui.status.EMPTY;

    if(this.nodes.images.length > 0) {
      this.nodes.images.forEach((image, index) => {
        if(toolData.files[index]) {
            if (toolData.files[index].file && Object.keys(toolData.files[index].file).length > 0) {
              status = Ui.status.UPLOADING;
            }
        }
        this.toggleStatus(status, index);
      });
    }
    
    return this.nodes.wrapper;
  }

  /**
   * Creates upload-file button
   *
   * @returns {Element}
   */
  createFileButton(index = 0) {
    const button = make('div', [ this.CSS.button ]);

    button.innerHTML = this.config.buttonContent || `${buttonIcon} ${this.api.i18n.t('Select an Image')}`;

    button.addEventListener('click', () => {
      this.onSelectFile(this.nodes.images[index].imageContainer);
    });

    return button;
  }

  /**
   * Shows uploading preloader
   *
   * @param {string} src - preview source
   * @returns {void}
   */
  showPreloader(src) {
    this.nodes.images.forEach((image, index) => {
      this.nodes.images[index].imagePreloader.style.backgroundImage = `url(${src})`;
      this.toggleStatus(Ui.status.UPLOADING, index);
    });

  }

  /**
   * Hide uploading preloader
   *
   * @returns {void}
   */
  hidePreloader() {
    this.nodes.images.forEach((image, index) => {
      this.nodes.images[index].imagePreloader.style.backgroundImage = ``;
      this.toggleStatus(Ui.status.EMPTY, index);
    });
  }

  /**
   * Shows an image
   *
   * @param {string} url - image source
   * @returns {void}
   */
  fillImage(url, index = 0) {
    /**
     * Check for a source extension to compose element correctly: video tag for mp4, img — for others
     */
    const tag = /\.mp4$/.test(url) ? 'VIDEO' : 'IMG';

    const attributes = {
      src: url,
      referrerpolicy: 'no-referrer',
    };

    /**
     * We use eventName variable because IMG and VIDEO tags have different event to be called on source load
     * - IMG: load
     * - VIDEO: loadeddata
     *
     * @type {string}
     */
    let eventName = 'load';

    /**
     * Update attributes and eventName if source is a mp4 video
     */
    if (tag === 'VIDEO') {
      /**
       * Add attributes for playing muted mp4 as a gif
       *
       * @type {boolean}
       */
      attributes.autoplay = true;
      attributes.loop = true;
      attributes.muted = true;
      attributes.playsinline = true;

      /**
       * Change event to be listened
       *
       * @type {string}
       */
      eventName = 'loadeddata';
    }

    /**
     * Compose tag with defined attributes
     *
     * @type {Element}
     */
    this.nodes.images[index].imageEl = make(tag, [this.CSS.imageEl, 'cursor-pointer'], attributes);

    /**
     * Add load event listener
     */
     this.nodes.images[index].imageEl.addEventListener(eventName, () => {
      this.toggleStatus(Ui.status.FILLED, index);

      /**
       * Preloader does not exists on first rendering with presaved data
       */
      if (this.nodes.images[index].imagePreloader) {
        this.nodes.images[index].imagePreloader.style.backgroundImage = '';
      }
    });

    try {
      // Remove previously selected image
      this.nodes.images[index].imageContainer.querySelector('.'+this.CSS.imageEl).remove();
    } catch(error) {}

    // Insert image element before image preloader
    this.nodes.images[index].imageContainer.insertBefore(this.nodes.images[index].imageEl, this.nodes.images[index].imagePreloader);

    // Add on-click event to imageEl to replace image
    this.nodes.images[index].imageEl.addEventListener('click', () => {
      this.onSelectFile(this.nodes.images[index].imageContainer);
    });
  }

  /**
   * Shows caption input
   *
   * @param {string} text - caption text
   * @returns {void}
   */
  fillCaption(text, index = 0) {
    if (this.nodes.images[index].caption) {
      this.nodes.images[index].caption.innerHTML = text;
    }
  }

  /**
   * Changes UI status
   *
   * @param {string} status - see {@link Ui.status} constants
   * @returns {void}
   */
  toggleStatus(status, index = 0) {
    for (const statusType in Ui.status) {
      if (Object.prototype.hasOwnProperty.call(Ui.status, statusType)) {
        this.nodes.images[index].imageContainer.classList.toggle(`${this.CSS.wrapper}--${Ui.status[statusType]}`, status === Ui.status[statusType]);
      }
    }
  }

  /**
   * Apply visual representation of activated tune
   *
   * @param {string} tuneName - one of available tunes {@link Tunes.tunes}
   * @param {boolean} status - true for enable, false for disable
   * @returns {void}
   */
  applyTune(tuneName, status) {
    this.nodes.wrapper.classList.toggle(`${this.CSS.wrapper}--${tuneName}`, status);
  }
}

/**
 * Helper for making Elements with attributes
 *
 * @param  {string} tagName           - new Element tag name
 * @param  {Array|string} classNames  - list or name of CSS class
 * @param  {object} attributes        - any attributes
 * @returns {Element}
 */
export const make = function make(tagName, classNames = null, attributes = {}) {
  const el = document.createElement(tagName);

  if (Array.isArray(classNames)) {
    el.classList.add(...classNames);
  } else if (classNames) {
    el.classList.add(classNames);
  }

  for (const attrName in attributes) {
    // el[attrName] = attributes[attrName];
    el.setAttribute(attrName, attributes[attrName]); // more reliable way of adding attributes to html node element
  }

  return el;
};
