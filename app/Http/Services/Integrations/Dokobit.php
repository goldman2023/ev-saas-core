<?php

namespace App\Http\Services\Integrations;

use Log;
use App\Models\Upload;
use App\Models\User;
use Dokobit\Gateway\Client;
use Illuminate\Support\Str;
use Dokobit\Gateway\Query\Signing\Create;
use Dokobit\Gateway\Query\File\UploadStatus;
use Dokobit\Gateway\Query\File\UploadFromUrl;

class Dokobit
{
    public $dokobit = null;
    public $is_sandbox;

    public function __construct()
    {
        $dokobit_enabled = get_tenant_setting('dokobit_enabled', false);
        $dokobit_api_key = get_tenant_setting('dokobit_api_key', null);
        $this->is_sandbox = get_tenant_setting('dokobit_sandbox', true);

        if($dokobit_enabled) {
            if(!empty($dokobit_api_key)) {
                try {
                    $this->dokobit = Client::create([
                        'apiKey' => $dokobit_api_key,
                        'sandbox' => $this->is_sandbox,
                    ]);
                } catch(\Throwable $e) {
                    Log::warning($e->getMessage());
                }
            } else {
                $this->dokobit = null;
            } 
        }
    }

    public function client() {
        return $this->dokobit;
    }

    public function uploadFile($upload) {

        if(! $this->isFileUploaded($upload)) {
            $url = $upload->url();

            try {
                $result = $this->client()->get(new UploadFromUrl(
                    $url,
                    hash('sha256', file_get_contents($url)),
                    basename($url)
                ));
    
                if(!empty($result) && $result->getStatus() === 'ok') {
                    $upload->setWEF('dokobit_file_token', $result->getToken());
                }
            } catch(\Exception $e) {
                Log::warning($e->getMessage());
                dd($e);
            } 
        }
    }

    public function isFileUploaded($upload) {
        $url = $upload->url();
        $file_token = $upload->getWEF('dokobit_file_token', true);

        if(!empty($file_token)) {
            try {
                $result = $this->client()->get(new UploadStatus(
                    $file_token
                ));
                
                return $result->getStatus() === 'uploaded' ? true : false;
            } catch(\Exception $e) {
                Log::warning($e->getMessage());
            }
        }

        return false;
    }

    public function createSigningForm($upload, $signer_1, $signer_2) {
        $file_token = $upload->getWEF('dokobit_file_token', true);
        $lang = 'lt'; // TODO: make this dynamic

        if(empty($file_token)) {
            $this->uploadFile($upload);
            $file_token = $upload->getWEF('dokobit_file_token', true);
        }
        
        if(!empty($file_token) && $signer_1 instanceof User && $signer_2 instanceof User) {
            $result = $this->client()->get(new Create(
                $upload->extension,
                translate('Sign document: ').$upload->file_original_name,
                [
                    [
                        'token' => $file_token,
                        'type' => 'main',
                    ],
                ],
                [
                    [
                        'id' => 'signer_'.$signer_1->id,
                        'name' => $signer_1->name,
                        'surname' => $signer_1->surname,
                        'signing_purpose' => 'signature',
                    ],
                    [
                        'id' => 'signer_'.$signer_2->id,
                        'name' => $signer_2->name,
                        'surname' => $signer_2->surname,
                        'signing_purpose' => 'signature',
                    ],
                ],
            ));

            if(!empty($result) && $result->getStatus() === 'ok' && !empty($result->getToken())) {
                $signers = $result->getSigners();
                $signing_token = $result->getToken();

                if(!empty($signers)) {
                    $signer_1_token = $signers['signer_'.$signer_1->id];
                    $signer_2_token = $signers['signer_'.$signer_2->id];

                    if(!empty($signer_1_token) && !empty($signer_2_token)) {
                        // Set $upload signing WEFs
                        $upload->setWEF('dokobit_signing_token', $signing_token);
                        $upload->setWEF('dokobit_signer_1_token', $signer_1_token);
                        $upload->setWEF('dokobit_signer_2_token', $signer_2_token);

                        $this->saveSigningFormUrls($upload);
                        
                        return true;
                    }
                }
            }
        }

        return false; 
    }

    public function saveSigningFormUrls($upload) {
        $signing_token = $upload->getWEF('dokobit_signing_token', true);
        $signer_1_token = $upload->getWEF('dokobit_signer_1_token', true);
        $signer_2_token = $upload->getWEF('dokobit_signer_2_token', true);

        if($this->is_sandbox) {
            $upload->setWEF('dokobit_signer_1_signing_form_url', sprintf('https://gateway-sandbox.dokobit.com/signing/%s?access_token=%s', $signing_token, $signer_1_token));
            $upload->setWEF('dokobit_signer_2_signing_form_url', sprintf('https://gateway-sandbox.dokobit.com/signing/%s?access_token=%s', $signing_token, $signer_2_token));
        }
    }
}
