import tableParser from './table';
import rawParser from './raw';
import imageCompareParser from './image-comparison';

export default function edjsCustomParsers(){
    return {
        table: tableParser,
        raw: rawParser,
        imageCompare: imageCompareParser,
    };
}