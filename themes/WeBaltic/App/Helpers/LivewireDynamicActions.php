<?php 
// lda is Livewire Dynamic Action

function lda_regenerate_document(&$form) {
    $upload_tag = $form->upload->getWEF('upload_tag', fresh: true);
    $order = $form->subject;

    if(empty($order)) {
        $order = $form->upload->orders->first();
    }

    // TODO: Sets the custom attributes -> FIX THIS SHIT!
    $order->get_primary_order_item()->custom_attributes()->get();


    if($upload_tag === 'proposal') {
        baltic_generate_order_document(
            order: $order, 
            template: 'documents-templates.proposal', 
            upload_tag: 'proposal', 
            display_name: translate('Proposal for Order #').$order->id, 
            data: ['upload' => $form->upload, 'user' => $order->user],
            regenerate: true,
        );
        $form->inform(translate('Proposal document successfully regenerated!'), '', 'success');
    } else if($upload_tag === 'delivery_to_warehouse') {
        baltic_generate_order_document(
            order: $order, 
            template: 'documents-templates.delivery-to-warehouse', 
            upload_tag:'delivery_to_warehouse', 
            display_name: translate('Delivery to warehouse document for Order #').$order->id,
            data: ['upload' => $form->upload, 'user' => $order->user],
            regenerate: true,
        );
        $form->inform(translate('Delivery to warehouse document successfully regenerated!'), '', 'success');
    }
}