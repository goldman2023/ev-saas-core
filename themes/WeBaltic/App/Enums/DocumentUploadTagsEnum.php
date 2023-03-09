<?php

namespace WeThemes\WeBaltic\App\Enums;

use App\Enums\UploadTagsEnum;

/**
 * @method static self proposal()
 * @method static self contract()
 * @method static self signed_contract()
 * @method static self delivery_to_warehouse()
 * @method static self manufacturing_details()
 * @method static self authenticity_certificate()
 * @method static self warrant()
 * @method static self certificate()
 */
class DocumentUploadTagsEnum extends UploadTagsEnum
{
    public static function values(): array
    {
        return [
            'proposal' => 'proposal',
            'contract' => 'contract',
            'signed_contract' => 'signed_contract',
            'delivery_to_warehouse' => 'delivery_to_warehouse',
            'manufacturing_details' => 'manufacturing_details',
            'authenticity_certificate' => 'authenticity_certificate',
            'warrant' => 'warrant',
            'certificate' => 'certificate',
        ];
    }

    public static function labels(): array
    {
        return [
            'proposal' => translate('Proposal'),
            'contract' => translate('Contract'),
            'signed_contract' => translate('Signed contract'),
            'delivery_to_warehouse' => translate('Delivery to warehouse'),
            'manufacturing_details' => translate('Manufacturing details'),
            'authenticity_certificate' => translate('Authenticity certificate'),
            'warrant' => translate('Warrant'),
            'certificate' => translate('Certificate'),
        ];
    }

    public static function getGeneratableUploadTags() {
        return array_filter(self::values(), function($upload_tag, $key) {
            return in_array($key, ['certificate', 'warrant', 'authenticity_certificate', 'manufacturing_details']);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public static function getSignableDocumentUploadTags() {
        return ['contract'];
    }
}
