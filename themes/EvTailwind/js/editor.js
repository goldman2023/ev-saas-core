import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import Checklist from '@editorjs/checklist';
import Code from '@editorjs/code';
import Embed from '@editorjs/embed';
import WeImageTool from './we-image-tool/dist/bundle';
import WeImageCompareTool from './we-image-compare/dist/bundle';
import InlineCode from '@editorjs/inline-code';
import Link from '@editorjs/link';
import Marker from '@editorjs/marker';
import NestedList from '@editorjs/nested-list';
import Paragraph from '@editorjs/paragraph';
import Quote from '@editorjs/quote';
import Raw from '@editorjs/raw';
import Table from '@editorjs/table';
import Warning from '@editorjs/warning';
import ColorPlugin from 'editorjs-text-color-plugin';
import ToggleBlock from 'editorjs-toggle-block';
import Undo from 'editorjs-undo';
import Hyperlink from 'editorjs-hyperlink';
import Underline from '@editorjs/underline';
import AttachesTool from '@editorjs/attaches';
import edjsHTML from 'editorjs-html';
import edjsCustomParsers from './edjs-parsers';
import AlignmentTuneTool from 'editorjs-text-alignment-blocktune';

window.EditorJS = EditorJS;
window.EditorJSUndoPlugin = Undo;
window.edjsHTML = edjsHTML(edjsCustomParsers());

window.getEditorJsDefaultConfig = function($id) {
    return {
        holder: $id,
        /**
         * Available Tools list.
         * Pass Tool's class or Settings object for each Tool you want to use
         */
        tools: {
            header: {
                class: Header,
                inlineToolbar : true,
                tunes: ['alignmentTune'],
            },
            list: List,
            checklist: Checklist,
            image: {
                class: WeImageTool,
                config: {

                }
            },
            imageCompare: {
                class: WeImageCompareTool,
                config: {

                }
            },
            link: Link,
            warning:Warning,
            table:Table,
            raw: Raw,
            quote:Quote,
            paragraph:{
                class: Paragraph,
                inlineToolbar : true,
                tunes: ['alignmentTune'],
            },
            nestedList:NestedList,
            marker: {
                class: ColorPlugin,
                config: {
                   defaultColor: '#FFBF00',
                   type: 'marker',
                   customPicker: true,
                }
              },
            inlineCode:InlineCode,
            embed:{
                class: Embed,
                inlineToolbar: true
            },
            code:Code,
            Color: {
                class: ColorPlugin,
                config: {
                   colorCollections: ['#EC7878','#9C27B0','#673AB7','#3F51B5','#0070FF','#03A9F4','#00BCD4','#4CAF50','#8BC34A','#CDDC39', '#FFF'],
                   defaultColor: '#FF1300',
                   type: 'text',
                   customPicker: true,
                }
            },
            toggle: {
                class: ToggleBlock,
                inlineToolbar: true,
            },
            hyperlink: {
                class: Hyperlink,
                config: {
                  shortcut: 'CMD+L',
                  target: '_blank',
                  rel: 'nofollow',
                  availableTargets: ['_blank', '_self'],
                  availableRels: ['author', 'noreferrer'],
                  validate: false,
                }
            },
            underline: Underline,
            //TODO: configure API endpoint to upload files/images to WeMediaLibrary
            // attaches: {
            //     class: AttachesTool,
            //     config: {
            //       endpoint: 'http://localhost:8008/uploadFile'
            //     }
            // },
            alignmentTune: {
                class:AlignmentTuneTool,
                config:{
                  default: "left",
                  blocks: {
                    header: 'left',
                    list: 'left'
                  }
                },
            }
        },
    };
};
