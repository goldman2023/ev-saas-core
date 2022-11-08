import tableParser from './table';

export default function edjsCustomParsers(){
    return {
        table: tableParser,
    };
}