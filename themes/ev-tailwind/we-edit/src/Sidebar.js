import React from 'react';

export default () => {
    const availablePages = window.available_pages;
    console.log("available react pages", availablePages);
    const onDragStart = (event, nodeData) => {
        console.log("drag start", nodeData.data.label);
        event.dataTransfer.setData('application/reactflow', nodeData);
        // event.dataTransfer.effectAllowed = 'move';
    };

    return (
        <aside>
            <div className="description">
                Available pages
            </div>
            <div >

                <div id="available_pages">
                    {
                        (() => {
                            let container = [];
                            console.log(availablePages);
                            console.log("inside sidebar");
                            availablePages.forEach((val, index) => {
                                container.push(
                                    <div className="dndnode input" onDragStart={(event) => onDragStart(event, val)} draggable>
                                        {val.data.label }
                                    </div>
                                )
                            });
                            return container;
                        })()
                    }
                </div>
            </div>

        </aside>
    );
};
