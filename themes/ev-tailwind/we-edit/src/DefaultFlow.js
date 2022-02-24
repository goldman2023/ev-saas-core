import React, { useState } from "react";

import ReactFlow, {
    removeElements,
    addEdge,
    Background
} from "react-flow-renderer";

const onNodeDragStop = (event, node) => console.log("drag stop", node);
const onElementClick = (event, element) => console.log("click", element);
const onLoad = (reactFlowInstance) => {
    console.log(reactFlowInstance);
    reactFlowInstance.fitView();
};

const initialElements = [
    {
        id: "1",
        type: "input",
        data: { label: "Homepage " },
        position: { x: 250, y: 5 }
    },
    {
        id: "2",
        type: "input",
        data: { label: "Pricing Page" }, position: { x: 100, y: 200 }
    },
    {
        id: "6",
        type: "input",
        data: { label: "Login Page" }, position: { x: 200, y: 100 }
    },
    { id: "3", data: { label: "Node 3" }, position: { x: 400, y: 100 } },
    { id: "4", data: { label: "Node 4" }, position: { x: 400, y: 200 } },
    { id: "e1-2", source: "1", target: "2", animated: true },
    { id: "e1-3", source: "1", target: "3" }
];

const BasicFlow = () => {
    const [elements, setElements] = useState(initialElements);
    const onElementsRemove = (elementsToRemove) =>
        setElements((els) => removeElements(elementsToRemove, els));
    const onConnect = (params) => setElements((els) => addEdge(params, els));

    return (
        <ReactFlow
            elements={elements}
            onLoad={onLoad}
            onElementClick={onElementClick}
            onElementsRemove={onElementsRemove}
            onConnect={onConnect}
            onNodeDragStop={onNodeDragStop}
        >
            <Background />
        </ReactFlow>
    );
};

export default BasicFlow;
