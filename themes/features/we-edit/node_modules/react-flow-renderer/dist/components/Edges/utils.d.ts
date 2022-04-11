import { ArrowHeadType, Position } from '../../types';
export declare const getMarkerEnd: (arrowHeadType?: ArrowHeadType | undefined, markerEndId?: string | undefined) => string;
export interface GetCenterParams {
    sourceX: number;
    sourceY: number;
    targetX: number;
    targetY: number;
    sourcePosition?: Position;
    targetPosition?: Position;
}
export declare const getCenter: ({ sourceX, sourceY, targetX, targetY, sourcePosition, targetPosition, }: GetCenterParams) => [number, number, number, number];
