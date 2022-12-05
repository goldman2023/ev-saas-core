import tableParser from './table';
import rawParser from './raw';
// import imageComparisonParser from './image-comparison';

export default function edjsCustomParsers(){
    return {
        table: tableParser,
        raw: rawParser,
        // imageComparison: imageComparisonParser,
    };
}