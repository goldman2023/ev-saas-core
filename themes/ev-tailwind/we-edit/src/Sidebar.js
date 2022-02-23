import React from 'react';

export default () => {
    const availablePages = window.available_pages;
    console.log("available react pages", availablePages);
    const onDragStart = (event, nodeData) => {
        console.log("drag start", nodeData.data.label);
        event.dataTransfer.setData('application/reactflow', nodeData.title);
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
                    {availablePages.map((page, i) => {
                        console.log("Entered");
                        // Return the element. Also pass key
                        return (<div className="dndnode input" key={i} onDragStart={(event) => onDragStart(event, page)} draggable>
                            <img
                                className="page-frame"
                                draggable="false"
                                src="/assets/we-edit/img/page-frame.svg" alt="page frame background" />

                            <img
                                draggable="false"
                                className="mb-3"
                                src="/assets/we-edit/img/page-placeholder.svg" alt="screen background" />

                            <span className="font-medium text-gray-700 hover:text-gray-800">
                                {page.data.label}
                            </span>

                        </div>)
                    })}

                </div>
            </div>

        </aside>
    );
};
