export default function columnsParser(block) {
    let colsNumber = block.data.cols.length;
    let html = '';

    if(colsNumber > 0) {
        html = `<div class="w-full grid grid-cols-${colsNumber} gap-4">`;

        block.data.cols.forEach((editorOutput) => {
            html += '<div class="col">';
            html += window.edjsHTML.parse(editorOutput).join('');
            html += `</div>`;
        });
        html += `</div>`;
    }

    return html;
}