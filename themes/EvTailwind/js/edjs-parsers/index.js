import tableParser from './table';
import rawParser from './raw';
import imageCompareParser from './image-comparison';
import columnsParser from './columns';

export default function edjsCustomParsers(){
    return {
        table: tableParser,
        raw: rawParser,
        imageCompare: imageCompareParser,
        columns: columnsParser,
        // checklist: checkListParser // TODO: add checklist parser
    };
}