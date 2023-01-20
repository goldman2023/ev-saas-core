<?php

use App\Models\Upload;
use Barryvdh\DomPDF\Facade\Pdf;

if (!function_exists('baltic_generate_order_document')) {
    function baltic_generate_order_document(&$order, $template, $upload_tag, $display_name = '', $data = []) {
        // Get order and generate the document
        $data = array_merge(['order' => $order], $data);

        if($template == 'manufacturing-sheet') {
            $pdf = Pdf::loadView($template, $data)->setPaper('a4', 'landscape');
        } else {
            $pdf = Pdf::loadView($template, $data);
        }

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
            headers: [ 'CacheControl' => 'no-cache', 'Expires' => 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time())]
        );

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
