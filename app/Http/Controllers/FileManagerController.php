<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    //

    public function index() {
        return view('frontend.dashboard.file-manager.index');
    }

    public function document_templates_index() {
        /* TODO: add the filter and move this to theme logic, to get available templates */
        $availableTemplates = [
            'documents-templates.proposal',
            'documents-templates.contract',
            'documents-templates.manufacturing-sheet',
            'documents-templates.welding-sheet',
            'documents-templates.authenticity-certificate',
            'documents-templates.warrant',
            'documents-templates.certificate',
        ];
        return view('frontend.dashboard.file-manager.document_templates', compact('availableTemplates'));
    }

    public function document_template_preview($template) {
        $demoOrder = 1;
        $order = Order::first();
        return view('frontend.dashboard.file-manager.document_template_preview', compact('template', 'order'));
    }
}
