export default function tableParser(block) {
    let html = `<table>`;

    if(block.data.content.length > 0) {
        block.data.content.forEach((item, index) => {
            html += `<tr>`;

            if(index === 0 && block.data.withHeadings) {
                item.forEach((col, index_col) => {
                    html += `<th>${col}</th>`;
                });
            } else {
                item.forEach((col, index_col) => {
                    html += `<td>${col}</td>`;
                });
            }

            html += `</tr>`;
        });
    }
    
    html += `</table>`;

    return html;
}