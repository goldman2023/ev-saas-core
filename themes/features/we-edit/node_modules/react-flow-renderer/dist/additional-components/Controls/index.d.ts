import React, { HTMLAttributes, FC } from 'react';
import { FitViewParams } from '../../types';
export interface ControlProps extends HTMLAttributes<HTMLDivElement> {
    showZoom?: boolean;
    showFitView?: boolean;
    showInteractive?: boolean;
    fitViewParams?: FitViewParams;
    onZoomIn?: () => void;
    onZoomOut?: () => void;
    onFitView?: () => void;
    onInteractiveChange?: (interactiveStatus: boolean) => void;
}
export interface ControlButtonProps extends HTMLAttributes<HTMLDivElement> {
}
export declare const ControlButton: FC<ControlButtonProps>;
declare const _default: React.NamedExoticComponent<ControlProps>;
export default _default;
