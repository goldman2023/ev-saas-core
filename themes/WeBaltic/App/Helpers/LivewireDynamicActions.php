<?php 
// lda is Livewire Dynamic Action

function lda_regenerate_document(&$form) {
    $upload_tag = $form->upload->getWEF('upload_tag');

    if($upload_tag === 'delivery_to_warehouse') {
        baltic_generate_order_document($form->subject, 'documents-templates.delivery-to-warehouse', 'delivery_to_warehouse', translate('Delivery to warehouse document for Order #').$form->subject->id);
        $form->inform(translate('Delivery to warehouse document successfully regenerated!'), '', 'success');
    }
}