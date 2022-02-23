import React, { memo } from 'react';

import { Handle } from 'react-flow-renderer';

export default memo(({ data, isConnectable }) => {
    return (
        <>
            <Handle
                type="target"
                position="top"
                style={{ padding: 10, background: '#555' }}
                onConnect={(params) => console.log('handle onConnect', params)}
                isConnectable={isConnectable}
            />
            <div>
                <img
                    className="page-frame"
                    draggable="false"
                    src="/assets/we-edit/img/page-frame.svg" alt="page frame background" />

                <img
                    draggable="false"
                    className="mb-3"
                    src="/assets/we-edit/img/page-placeholder.svg" alt="screen background" />

            </div>
            <span className="font-medium text-gray-700 hover:text-gray-800">
                { data.label }
            </span>

            {/* <input
                className="nodrag"
                type="color"
                onChange={data.onChange}
                defaultValue={data.color}
            /> */}
            <Handle
                type="source"
                position="bottom"
                id="a"
                style={{ padding: 10, background: '#555' }}
                isConnectable={isConnectable}
            />
        </>
    );
});
