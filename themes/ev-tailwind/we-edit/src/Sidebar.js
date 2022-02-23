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
            <div className="we-flow-tabs">
                <div className="we-flow-tab">
                    Available pages
                </div>

                <div className="we-flow-tab">
                    Available actions
                </div>
            </div>
            <div>

                <div id="available_pages">
                    {
                        (() => {
                            let container = [];
                            availablePages.forEach((val, index) => {
                                container.push(
                                    <div className="dndnode input" onDragStart={(event) => onDragStart(event, val)} draggable>
                                        <img
                                            className="page-frame"
                                            draggable="false"
                                            src="/assets/we-edit/img/page-frame.svg" alt="page frame background" />

                                        <img
                                            draggable="false"
                                            className="mb-3"
                                            src="/assets/we-edit/img/page-placeholder.svg" alt="screen background" />

                                        <span className="font-medium text-gray-700 hover:text-gray-800">
                                            {val.data.label}
                                        </span>
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
