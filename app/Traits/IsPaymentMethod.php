<?php

namespace App\Traits;

use Closure;

trait IsPaymentMethod
{
    public static $available_gateways = ['wire_transfer', 'paypal', 'stripe', 'paysera'];
   
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootIsPaymentMethod()
    {
        // When model data is retrieved/hydrated, populate gateway data properties!
        static::retrieved(function ($model): void {
            // Initiate dynamic properties values
            $model->dynamicPaymentMethodPropertiesWalker(function($property) use (&$model) {
                $model->appendCoreProperties([$property['property_name']]);
                $model->append([$property['property_name']]);
                $model->fillable(array_unique(array_merge($model->fillable, [$property['property_name']])));

                $model->{$property['property_name']} = $property['value'] ?? null;
            });
        });

        static::saving(function ($model) {
            // Save dynamic properties to Data
            $model->dynamicPaymentMethodPropertiesWalker(function($property) use (&$model) {
                $data = $model->data;
                
                 if(is_object($data)) {
                    $data->{$property['property_name']} = $model->{$property['property_name']} ?? null;
                 } else if(is_array($data)) {
                    $data[$property['property_name']] = $model[$property['property_name']] ?? null;
                 }
                
                $model->data = $data;
            });
        });
    }

    /**
     * Walks through getDynamicModelPaymentMethodProperties and executes a provided closure for each property if conditions are met.
     *
     * Conditions:
     * 1. `gateway` is set
     * 2. `gateway` is one of the $available_gateways
     * 3. Provided callback is an instance of Closure ($callback is anonymous function)
     *
     * @param ?Closure $callback
     */
    protected function dynamicPaymentMethodPropertiesWalker(?Closure $callback = null): void {
        $dynamic_properties = $this->getDynamicModelPaymentMethodProperties();

        if(in_array($this->gateway, self::$available_gateways, true)) {
            foreach ($dynamic_properties as $property) {
                $callback($property);
            }
        }
    }

    public function getDynamicModelPaymentMethodProperties(): array
    {
       if($this->gateway === 'wire_transfer') {
            // TODO: Support multiple bank accounts!
            return [
                [
                    'property_name' => 'bank_account_name',
                    'value' => $this->data->bank_account_name ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Bank account name is required'),
                    ]
                ],
                [
                    'property_name' => 'bank_account_number',
                    'value' => $this->data->bank_account_number ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Bank account number is required')
                    ]
                ],
                [
                    'property_name' => 'bank_name',
                    'value' => $this->data->bank_name ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Bank name is required')
                    ]
                ],
                [
                    'property_name' => 'bank_sort_code',
                    'value' => $this->data->bank_sort_code ?? '',
                    'rules' => [],
                    'messages' => [
//                        'required' => translate('Bank sort code is required')
                    ]
                ],
                [
                    'property_name' => 'iban',
                    'value' => $this->data->iban ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('IBAN is required')
                    ]
                ],
                [
                    'property_name' => 'bank_swift',
                    'value' => $this->data->bank_swift ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Swift is required')
                    ]
                ]
            ];
        } else if($this->gateway === 'paypal') {
            return [
                [
                    'property_name' => 'paypal_email',
                    'value' => $this->data->paypal_email ?? '',
                    'rules' => ['required', 'email:rfc,dns'],
                    'messages' => [
                        'required' => translate('Paypal email is required'),
                        'email' => translate('Paypal email is not valid'),
                    ],
                ],
                [
                    'property_name' => 'paypal_receiver_email',
                    'value' => $this->data->paypal_receiver_email ?? '',
                    'rules' => ['sometimes', 'email:rfc,dns'],
                    'messages' => [
                        'email' => translate('Paypal receiver email is not valid'),
                    ],
                ],
                [
                    'property_name' => 'paypal_ipn_email_notifications',
                    'value' => $this->data->paypal_ipn_email_notifications ?? '',
                    'rules' => ['boolean'],
                    'messages' => [
                        'boolean' => translate('IPN email notifications should either be enabled or disabled'),
                    ],
                ],
                [
                    'property_name' => 'paypal_identity_token',
                    'value' => $this->data->paypal_identity_token ?? '',
                    'rules' => [],
                    'messages' => [

                    ],
                ],
                [
                    'property_name' => 'paypal_invoice_prefix',
                    'value' => $this->data->paypal_invoice_prefix ?? '',
                    'rules' => ['sometimes', 'min:1'],
                    'messages' => [
                        'min' => translate('Minimum characters for invoice prefix must be 1')
                    ],
                ],
                [
                    'property_name' => 'paypal_use_shipping_details',
                    'value' => $this->data->paypal_use_shipping_details ?? '',
                    'rules' => ['boolean'],
                    'messages' => [
                        'boolean' => translate('`Use shipping details` should either be enabled or disabled'),
                    ],
                ],
                [
                    'property_name' => 'paypal_payment_action',
                    'value' => $this->data->paypal_payment_action ?? '',
                    'rules' => ['in:authorize,capture'],
                    'messages' => [
                        'in' => translate('Paypal payment action can be either `capture` or `authorize`'),
                    ],
                ],
                [
                    'property_name' => 'paypal_image_url',
                    'value' => $this->data->paypal_image_url ?? '',
                    'rules' => ['sometimes', 'url'],
                    'messages' => [
                        'url' => translate('Image URL has to be a valid URL'),
                    ],
                ],

                [
                    'property_name' => 'paypal_live_api_username',
                    'value' => $this->data->paypal_live_api_username ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('API username is required'),
                    ]
                ],

                [
                    'property_name' => 'paypal_live_api_password',
                    'value' => $this->data->paypal_live_api_password ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('API pasword is required'),
                    ]
                ],

                [
                    'property_name' => 'paypal_live_api_signature',
                    'value' => $this->data->paypal_live_api_signature ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('API signature is required'),
                    ]
                ],
            ];
        } else if($this->gateway === 'stripe') {
            return [
                [
                    'property_name' => 'stripe_publishable_key',
                    'value' => $this->data->stripe_publishable_key ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Stripe publishable key is required in order to use Stripe gateway'),
                    ]
                ],
                [
                    'property_name' => 'stripe_secret_key',
                    'value' => $this->data->stripe_secret_key ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Stripe secret key is required in order to use Stripe gateway'),
                    ]
                ],
                [
                    'property_name' => 'stripe_statement_descriptor',
                    'value' => $this->data->stripe_statement_descriptor ?? '',
                    'rules' => [],
                    'messages' => [

                    ]
                ],

                [
                    'property_name' => 'stripe_inline_credit_card_form',
                    'value' => $this->data->stripe_inline_credit_card_form ?? '',
                    'rules' => ['boolean'],
                    'messages' => [
                        'boolean' => translate('`Inline credit card form` should either be enabled or disabled'),
                    ],
                ],
                [
                    'property_name' => 'stripe_capture_charge',
                    'value' => $this->data->stripe_capture_charge ?? '',
                    'rules' => ['boolean'],
                    'messages' => [
                        'boolean' => translate('`Capture charge immediately` should either be enabled or disabled'),
                    ],
                ],
                [
                    'property_name' => 'stripe_saved_cards_payment',
                    'value' => $this->data->stripe_saved_cards_payment ?? '',
                    'rules' => ['boolean'],
                    'messages' => [
                        'boolean' => translate('`Payment via saved_cards` should either be enabled or disabled'),
                    ],
                ],
                [
                    'property_name' => 'stripe_payment_request_buttons',
                    'value' => $this->data->stripe_payment_request_buttons ?? '',
                    'rules' => ['boolean'],
                    'messages' => [
                        'boolean' => translate('`Payment request buttons` should either be enabled or disabled'),
                    ],
                ],
            ];
        } else if($this->gateway === 'paysera') {
            return [
                [
                    'property_name' => 'paysera_project_id',
                    'value' => $this->data->paysera_project_id ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Paysera project ID is required')
                    ],
                ],
                [
                    'property_name' => 'paysera_project_password',
                    'value' => $this->data->paysera_project_password ?? '',
                    'rules' => ['required'],
                    'messages' => [
                        'required' => translate('Paysera project password is required')
                    ],
                ],
            ];
        }

        return [];
    }

    public function getPaymentMethodValidationRules($key_prefix = '', $as_collection = false) {
        $properties = $this->getDynamicModelPaymentMethodProperties();

        $rules = collect($properties)->keyBy(fn($item) => $key_prefix.'.'.$item['property_name'])->map(fn($item, $key) => $item['rules']);

        return $as_collection ? $rules : $rules->toArray();
    }

    public function getPaymentMethodValidationMessages($key_prefix = '', $as_collection = false) {
        $properties = $this->getDynamicModelPaymentMethodProperties();
        $messages = [];

        collect($properties)->each(function($item) use($key_prefix, &$messages) {
            $messages = array_merge($messages, collect($item['messages'])->keyBy(fn($msg, $key) => $key_prefix.'.'.$item['property_name'].'.'.$key)->toArray());
        });

        return $as_collection ? collect($messages) : $messages;
    }

    /*
     * Get Paypal Payment action choices
     */
    public static function getPaypalPaymentActions() {
        return [
            'capture' => 'Capture',
            'authorize' => 'Authorize'
        ];
    }

}
