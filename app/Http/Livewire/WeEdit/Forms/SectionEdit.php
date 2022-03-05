<?php

namespace App\Http\Livewire\WeEdit\Forms;

use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;
use App\Enums\WeEditLayoutEnum;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Masterminds\HTML5;

class SectionEdit extends Component
{
    use DispatchSupport;

    public $section;
    public $current_preview;

    public function mount($current_preview, $section = null)
    {
        $this->current_preview = $current_preview;
        $this->section = $section;
        $this->custom_fields_html = '';
    }

    public function rules() {
        return [
            'current_preview.id' => '',
            'current_preview.content' => '',
            'current_preview.content.*' => '',
            'section' => '',
            'section.*' => '',
        ];
    }

    public function messages() {
        return [];
    }

    public function dehydrate() {
        // $this->dispatchBrowserEvent('');
    }

    public function setSection($section_uuid) {
        $this->section = collect($this->current_preview->content)->firstWhere('uuid', $section_uuid);
        $this->parseCustomFields();
    }

    protected function parseCustomFields() {
        $html = file_get_contents(resource_path('views/components/'.str_replace('.', '/', $this->section['id']).'.blade.php'));
        $crawler = new Crawler($html);
        $compiler = new ComponentTagCompiler(
            Container::getInstance()->make('blade.compiler')->getClassComponentAliases(),
            Container::getInstance()->make('blade.compiler')->getClassComponentNamespaces(),
            Container::getInstance()->make('blade.compiler')
        );

        $custom_fields_crawler = new Crawler();
        $html5 = new HTML5(); // HTML5 wrapper used over DOMDocument
        $dom = $html5->loadHTML('<html><body></body></html>'); // Main DOMDocument
        
        $this->custom_fields_html = ''; // reset custom fields html before looping through the slots
        
        // Loop through the all defined slots in the component html
        $crawler->filter('x-slot')->each(function (Crawler $node, $i) use(&$custom_fields_crawler, $compiler, &$html5, &$dom) {
            /**
             * In order to append HTML fragment to DOMDocument ($dom), we need to:
             * 1. Load HTML fragment from the blade view file using HTML5 - this will create a DOMDocumentFragment
             * 2. Import DOMDocumentFragment to $dom - this will import DOMDocumentFragment to DOM and that fragment will be accessable for usage in DOM
             * 3. Select body tag inside DOM
             * 4. Append previously imported fragment to it (to body)
             **/
            $slot_dom = $html5->loadHTML('<html><body></body></html>');
            $slot_html = $slot_dom->importNode($html5->loadHTMLFragment(app($compiler->componentClass('we-edit.field-partials.slot'))->render()->render()), true );
            $slot_dom->getElementsByTagName('body')->item(0)->appendChild($slot_html); // append slot to body inside dom
            $slot_xpath = new \DomXpath($slot_dom);
            
            // Get slot info
            $slot_name = $node->attr('name');
            $slot_we_title = $node->attr('we-title');
            $slot_we_description = $node->attr('we-description');
            
            // Change slot title
            $slot_xpath->query('//*[@we-slot-title]')->item(0)->nodeValue = $slot_we_title;

            // Remove slot-description paragraph if we-description is not set on slot, otherwise append the description
            if(empty($slot_we_description)) {
                $description_node = $slot_xpath->query('//*[@we-slot-description]')->item(0);
                $description_node->parentNode->removeChild($description_node); // remove description node
            } else {
                $slot_xpath->query('//*[@we-slot-description]')->item(0)->nodeValue = $slot_we_description;
            }

            // loop through slot to identify all comonents inside the slot
            $node->children()->each(function (Crawler $node, $i) use(&$custom_fields_crawler, $compiler, $slot_name, $slot_we_title, &$html5, &$slot_xpath) {
                $component = $node;
                $component_tag = $component->nodeName();
                $component_we_name = $component->attr('we-name');
                $component_we_title = $component->attr('we-title');
                
                $pos = strpos($component_tag, 'x-');
            
                // If component has 'x-' - it means it's a custom field component
                if ($pos !== false) {
                    $component_tag = substr_replace($component_tag, '', $pos, strlen('x-')); // remove "x-" from
                    $component_class = app($compiler->componentClass($component_tag)); // find component classes

                    // If slot_name is not set inside data, set it
                    if(!isset($this->section['data'][$slot_name])) {
                        $this->section['data'][$slot_name] = [
                            'title' => $slot_we_title,
                            'components' => []
                        ]; // set slot_name inside data
                    }

                    // If component_name is not set inside slot, set it
                    if(!isset($this->section['data'][$slot_name]['components'][$component_we_name])) {
                        $this->section['data'][$slot_name]['components'][$component_we_name] = []; // set component_name inside slot
                    }


                    // If component_data is not set inside component_name, set it
                    if(empty($this->section['data'][$slot_name]['components'][$component_we_name] ?? null)) {
                        $this->section['data'][$slot_name]['components'][$component_we_name] = [
                            'title' => $component_we_title,
                            'data' => $component_class->getEditableData()
                        ];
                    } else {
                        // If component_data IS set inside component_name, use that data to feed component_class data
                        $component_class->setEditableData($this->section['data'][$slot_name]['components'][$component_we_name]['data'] ?? '');
                    }
                    
                    // Edit SLOT DOM - append component title and HTML content to specified places inside we-slot-list

                    // Render component's blade view into string (HTML) and Import HHTML fragment to $slot_xpath->document
                    $component_node = $slot_xpath->document->importNode($html5->loadHTMLFragment($component_class->renderFieldComponent($slot_name, $component_we_name)->render()), true);

                    // Get we-slot-list and count elements and based on that append/change new/existing we-slot-list-item and it's data
                    $slot_list_elements_count = $slot_xpath->query('//*[@we-slot-list]')->count();
                    if($slot_list_elements_count > 1) {
                        // If there are multiple elements inside we-slot-list (it means that there are multiple components inside a slot)
                    } else {
                        // If there is one element inside we-slot-list (it means that there is only one component inside a slot)
                        // Change last we-slot-list-item and append component data to it
                        $slot_xpath->query('//*[@we-slot-list-item-title]')->item(0)->nodeValue = $component_we_title; // add component title to we-slot-list-item-title
                        $slot_xpath->query('//*[@we-slot-list-item-content]')->item(0)->appendChild($component_node);
                    }
                }
            });

            // Append SLOT_DOM to MAIN_DOM
            $slot_node = $dom->importNode($slot_xpath->query('//*[@we-slot]')->item(0), true);

            $dom->getElementsByTagName('body')->item(0)->appendChild($slot_node); 
            
        });

        // Store MAIN_DOM html to custom_fields_html
        $this->custom_fields_html = $html5->saveHTML($dom);
        
    }
    
    public function render()
    {
        return view('livewire.we-edit.forms.section-edit');
    }
}