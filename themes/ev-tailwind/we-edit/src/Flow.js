import React, { useState, useRef } from 'react';
import ReactFlow, {
    ReactFlowProvider,
    addEdge,
    removeElements,
    Controls,
    Background,
    ControlButton,
    DeleteIcon,
} from 'react-flow-renderer';

import WeNode from './custom_nodes/WeNode';

import Sidebar from './Sidebar';

import './dnd.css';

const initialElements = server_data;
/* const initialElements = [
    {
        id: '1',
        type: 'input',
        data: { label: 'input node' },
        position: { x: 250, y: 5 },
      },
    ]; */
let id = server_data.length;
let selected_node = null;
const getId = () => `dndnode_${id++}`;
/* This is WE-SaaS Custom nodes */
const nodeTypes = {
    wenode: WeNode
  };

const DnDFlow = () => {
    const reactFlowWrapper = useRef(null);
    const [reactFlowInstance, setReactFlowInstance] = useState(null);
    const [elements, setElements] = useState(initialElements);
    const onConnect = (params) => setElements((els) => addEdge(params, els));
    const onElementsRemove = (elementsToRemove) =>
        setElements((els) => removeElements(elementsToRemove, els));

    const onLoad = (_reactFlowInstance) =>
        setReactFlowInstance(_reactFlowInstance);

    const onDragOver = (event) => {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
    };

    const onElementClick = (element) => {
        console.log('element clicked', element);
    }

    const onDrop = (event) => {
        event.preventDefault();

        const reactFlowBounds = reactFlowWrapper.current.getBoundingClientRect();
        const nodeData = event.dataTransfer.getData('application/reactflow');
        console.log('node data');
        console.log(nodeData);
        let type = 'wenode';
        if(nodeData.data) {
            console.log(nodeData.data);
            nodeTitle = nodeData.data.label;

        } else {
            nodeTitle = "Node title";
        }

        let nodeTitle = nodeData;

        const position = reactFlowInstance.project({
            x: event.clientX - reactFlowBounds.left,
            y: event.clientY - reactFlowBounds.top,
        });
        const newNode = {
            id: getId(),
            type,
            position,
            data: { label: nodeTitle },
        };

        setElements((es) => {
            console.log(es);
            return es.concat(newNode)
        }
        );
    };

    return (
        <div className="dndflow">
            <ReactFlowProvider>
                <div className="reactflow-wrapper" ref={reactFlowWrapper}>
                    <ReactFlow
                        onElementClick={onElementClick}
                        elements={elements}
                        nodeTypes={ nodeTypes }
                        onConnect={onConnect}
                        onElementsRemove={onElementsRemove}
                        onLoad={onLoad}
                        onDrop={onDrop}
                        onDragOver={onDragOver}
                    >

                            <Controls showInteractive={false}>
                                <ControlButton onClick={onElementClick}>
                                    labas
                                </ControlButton>
                            </Controls>
                        <Background />
                    </ReactFlow>
                </div>
                <Sidebar />
            </ReactFlowProvider>
        </div>
    );
};

export default DnDFlow;
