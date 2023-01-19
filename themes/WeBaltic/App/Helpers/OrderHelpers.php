<?php

use Barryvdh\DomPDF\Facade\Pdf;

if (!function_exists('baltic_generate_order_document')) {
    function baltic_generate_order_document(&$order, $template, $upload_tag, $display_name = '') {
        // Get order and generate the document
        $data = ['order' => $order];
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
