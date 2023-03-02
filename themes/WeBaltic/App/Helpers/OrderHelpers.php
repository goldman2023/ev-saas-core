<?php

use App\Models\Upload;
use App\Enums\OrderTypeEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

if (!function_exists('baltic_generate_order_document')) {
    function baltic_generate_order_document(&$order, $template, $upload_tag, $display_name = '', $data = [], $regenerate = false) {
        // Get order and generate the document
        $data = array_merge(['order' => $order], $data);
        
        $pdf_not_loaded_flag = false;

        try {
            if($template == 'manufacturing-sheet') {
                $pdf = Pdf::loadView($template, $data)->setPaper('a4', 'landscape');
            } else {
                $pdf = Pdf::loadView($template, $data);
            }
        } catch(\Exception $e) {
            // If Pdf:loadView fails due to unsufficent $data (like missing $upload, when it needs it in blade template),
            // catch this and rise a flag
            $pdf_not_loaded_flag = true;
        }
        
        if($regenerate) {
            // Upload generated pdf as file in storage and create Upload and Relationship to $order
            $upload = MediaService::uploadAndStore(
                model: $order,
                contents: !$pdf_not_loaded_flag ? $pdf->output() : '',
                path: 'orders/'.$order->id,
                name: $upload_tag.'-'.$order->id,
                extension: 'pdf',
                property_name: 'documents',
                with_hash: false,
                file_display_name: $display_name,
                upload_tag: $upload_tag,
                headers: [ 'CacheControl' => 'no-cache', 'Expires' => 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time())],
                regenerate: true,
                upload: $data['upload'] ?? null
            );
        } else {
            $upload = MediaService::uploadAndStore(
                model: $order,
                contents: !$pdf_not_loaded_flag ? $pdf->output() : '',
                path: 'orders/'.$order->id,
                name: $upload_tag.'-'.$order->id,
                extension: 'pdf',
                property_name: 'documents',
                with_hash: false,
                file_display_name: $display_name,
                upload_tag: $upload_tag,
                headers: [ 'CacheControl' => 'no-cache', 'Expires' => 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time())]
            );
        }

        // CHeck if not_loaded flag is TRUE
        if($pdf_not_loaded_flag) {
            // Since the not_loaded flag is rised, we need to perform proper document regeneration with $upload inside $data
            $data = array_merge($data, ['upload' => $upload]);

            try {
                if($template == 'manufacturing-sheet') {
                    $pdf = Pdf::loadView($template, $data)->setPaper('a4', 'landscape');
                } else {
                    $pdf = Pdf::loadView($template, $data);
                }

                if($regenerate) {
                    // Upload generated pdf as file in storage and create Upload and Relationship to $order
                    $upload = MediaService::uploadAndStore(
                        model: $order,
                        contents: $pdf->output(),
                        path: 'orders/'.$order->id,
                        name: $upload_tag.'-'.$order->id,
                        extension: 'pdf',
                        property_name: 'documents',
                        with_hash: false,
                        file_display_name: $display_name,
                        upload_tag: $upload_tag,
                        headers: [ 'CacheControl' => 'no-cache', 'Expires' => 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time())],
                        regenerate: true,
                        upload: $data['upload'] ?? null
                    );
                } else {
                    $upload = MediaService::uploadAndStore(
                        model: $order,
                        contents: $pdf->output(),
                        path: 'orders/'.$order->id,
                        name: $upload_tag.'-'.$order->id,
                        extension: 'pdf',
                        property_name: 'documents',
                        with_hash: false,
                        file_display_name: $display_name,
                        upload_tag: $upload_tag,
                        headers: [ 'CacheControl' => 'no-cache', 'Expires' => 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time())]
                    );
                }
                
            } catch(\Exception $e) {
                Log::error($e->getMessage());
                return $upload;
            }
        }

        return $upload;
    }
}

if (!function_exists('get_delivery_document_number')) {
    function get_delivery_document_number($upload) {
        $delivery_docs = Upload::whereWEF('upload_tag', 'delivery_to_warehouse')->orderBy('created_at', 'asc')->get();

        $current_delivery_doc_number = $delivery_docs->search(function ($item, $key) use($upload) {
            return $item->id === $upload->id;
        });

        if($current_delivery_doc_number >= 0) {
            $current_delivery_doc_number += 1;
        }

        return $current_delivery_doc_number;
    }
}
