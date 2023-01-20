<?php 
// lda is Livewire Dynamic Action

function lda_regenerate_document(&$form) {
    $upload_tag = $form->upload->getWEF('upload_tag');

    if($upload_tag === 'proposal') {
        baltic_generate_order_document(
            order: $form->subject, 
            template: 'documents-templates.proposal', 
            upload_tag: 'proposal', 
            display_name: translate('Proposal for Order #').$form->subject->id, 
            data: ['upload' => $form->upload, 'user' => $form->subject->user]
        );
        $form->inform(translate('Proposal document successfully regenerated!'), '', 'success');
    } else if($upload_tag === 'delivery_to_warehouse') {
        baltic_generate_order_document(
            order: $form->subject, 
            template: 'documents-templates.delivery-to-warehouse', 
            upload_tag:'delivery_to_warehouse', 
            display_name: translate('Delivery to warehouse document for Order #').$form->subject->id,
            data: ['upload' => $form->upload, 'user' => $form->subject->user]
        );
        $form->inform(translate('Delivery to warehouse document successfully regenerated!'), '', 'success');
    }
}