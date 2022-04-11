import React, { HTMLAttributes } from 'react';
import { BackgroundVariant } from '../../types';
export interface BackgroundProps extends HTMLAttributes<SVGElement> {
    variant?: BackgroundVariant;
    gap?: number;
    color?: string;
    size?: number;
}
declare const _default: React.NamedExoticComponent<BackgroundProps>;
export default _default;
