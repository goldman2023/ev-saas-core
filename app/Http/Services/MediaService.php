<?php

namespace App\Http\Services;

use Log;
use DB;
use EVS;
use Cache;
use Session;
use SplFileInfo;
use App\Models\Shop;
use App\Models\User;
use App\Models\Brand;
use App\Models\Upload;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Attribute;
use Illuminate\Http\File;
use App\Models\ShopDomain;
use Illuminate\Support\Str;
use App\Models\AttributeValue;
use Illuminate\Support\Collection;
use App\Models\CategoryRelationship;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\ComponentAttributeBag;

class MediaService
{
    public $extension2mime = array(
        'ai'      => 'application/postscript',
        'aif'     => 'audio/x-aiff',
        'aifc'    => 'audio/x-aiff',
        'aiff'    => 'audio/x-aiff',
        'asc'     => 'text/plain',
        'atom'    => 'application/atom+xml',
        'au'      => 'audio/basic',
        'avi'     => 'video/x-msvideo',
        'bcpio'   => 'application/x-bcpio',
        'bin'     => 'application/octet-stream',
        'bmp'     => 'image/bmp',
        'cdf'     => 'application/x-netcdf',
        'cgm'     => 'image/cgm',
        'class'   => 'application/octet-stream',
        'cpio'    => 'application/x-cpio',
        'cpt'     => 'application/mac-compactpro',
        'csh'     => 'application/x-csh',
        'css'     => 'text/css',
        'csv'     => 'text/csv',
        'dcr'     => 'application/x-director',
        'dir'     => 'application/x-director',
        'djv'     => 'image/vnd.djvu',
        'djvu'    => 'image/vnd.djvu',
        'dll'     => 'application/octet-stream',
        'dmg'     => 'application/octet-stream',
        'dms'     => 'application/octet-stream',
        'doc'     => 'application/msword',
        'dtd'     => 'application/xml-dtd',
        'dvi'     => 'application/x-dvi',
        'dxr'     => 'application/x-director',
        'eps'     => 'application/postscript',
        'etx'     => 'text/x-setext',
        'exe'     => 'application/octet-stream',
        'ez'      => 'application/andrew-inset',
        'gif'     => 'image/gif',
        'gram'    => 'application/srgs',
        'grxml'   => 'application/srgs+xml',
        'gtar'    => 'application/x-gtar',
        'hdf'     => 'application/x-hdf',
        'hqx'     => 'application/mac-binhex40',
        'htm'     => 'text/html',
        'html'    => 'text/html',
        'ice'     => 'x-conference/x-cooltalk',
        'ico'     => 'image/x-icon',
        'ics'     => 'text/calendar',
        'ief'     => 'image/ief',
        'ifb'     => 'text/calendar',
        'iges'    => 'model/iges',
        'igs'     => 'model/iges',
        'jpe'     => 'image/jpeg',
        'jpeg'    => 'image/jpeg',
        'jpg'     => 'image/jpeg',
        'js'      => 'application/x-javascript',
        'json'    => 'application/json',
        'kar'     => 'audio/midi',
        'latex'   => 'application/x-latex',
        'lha'     => 'application/octet-stream',
        'lzh'     => 'application/octet-stream',
        'm3u'     => 'audio/x-mpegurl',
        'man'     => 'application/x-troff-man',
        'mathml'  => 'application/mathml+xml',
        'me'      => 'application/x-troff-me',
        'mesh'    => 'model/mesh',
        'mid'     => 'audio/midi',
        'midi'    => 'audio/midi',
        'mif'     => 'application/vnd.mif',
        'mov'     => 'video/quicktime',
        'movie'   => 'video/x-sgi-movie',
        'mp2'     => 'audio/mpeg',
        'mp3'     => 'audio/mpeg',
        'mpe'     => 'video/mpeg',
        'mpeg'    => 'video/mpeg',
        'mpg'     => 'video/mpeg',
        'mpga'    => 'audio/mpeg',
        'ms'      => 'application/x-troff-ms',
        'msh'     => 'model/mesh',
        'mxu'     => 'video/vnd.mpegurl',
        'nc'      => 'application/x-netcdf',
        'oda'     => 'application/oda',
        'ogg'     => 'application/ogg',
        'pbm'     => 'image/x-portable-bitmap',
        'pdb'     => 'chemical/x-pdb',
        'pdf'     => 'application/pdf',
        'pgm'     => 'image/x-portable-graymap',
        'pgn'     => 'application/x-chess-pgn',
        'png'     => 'image/png',
        'pnm'     => 'image/x-portable-anymap',
        'ppm'     => 'image/x-portable-pixmap',
        'ppt'     => 'application/vnd.ms-powerpoint',
        'ps'      => 'application/postscript',
        'qt'      => 'video/quicktime',
        'ra'      => 'audio/x-pn-realaudio',
        'ram'     => 'audio/x-pn-realaudio',
        'ras'     => 'image/x-cmu-raster',
        'rdf'     => 'application/rdf+xml',
        'rgb'     => 'image/x-rgb',
        'rm'      => 'application/vnd.rn-realmedia',
        'roff'    => 'application/x-troff',
        'rss'     => 'application/rss+xml',
        'rtf'     => 'text/rtf',
        'rtx'     => 'text/richtext',
        'sgm'     => 'text/sgml',
        'sgml'    => 'text/sgml',
        'sh'      => 'application/x-sh',
        'shar'    => 'application/x-shar',
        'silo'    => 'model/mesh',
        'sit'     => 'application/x-stuffit',
        'skd'     => 'application/x-koan',
        'skm'     => 'application/x-koan',
        'skp'     => 'application/x-koan',
        'skt'     => 'application/x-koan',
        'smi'     => 'application/smil',
        'smil'    => 'application/smil',
        'snd'     => 'audio/basic',
        'so'      => 'application/octet-stream',
        'spl'     => 'application/x-futuresplash',
        'src'     => 'application/x-wais-source',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc'  => 'application/x-sv4crc',
        'svg'     => 'image/svg+xml',
        'svgz'    => 'image/svg+xml',
        'swf'     => 'application/x-shockwave-flash',
        't'       => 'application/x-troff',
        'tar'     => 'application/x-tar',
        'tcl'     => 'application/x-tcl',
        'tex'     => 'application/x-tex',
        'texi'    => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tif'     => 'image/tiff',
        'tiff'    => 'image/tiff',
        'tr'      => 'application/x-troff',
        'tsv'     => 'text/tab-separated-values',
        'txt'     => 'text/plain',
        'ustar'   => 'application/x-ustar',
        'vcd'     => 'application/x-cdlink',
        'vrml'    => 'model/vrml',
        'vxml'    => 'application/voicexml+xml',
        'wav'     => 'audio/x-wav',
        'wbmp'    => 'image/vnd.wap.wbmp',
        'wbxml'   => 'application/vnd.wap.wbxml',
        'wml'     => 'text/vnd.wap.wml',
        'wmlc'    => 'application/vnd.wap.wmlc',
        'wmls'    => 'text/vnd.wap.wmlscript',
        'wmlsc'   => 'application/vnd.wap.wmlscriptc',
        'wrl'     => 'model/vrml',
        'xbm'     => 'image/x-xbitmap',
        'xht'     => 'application/xhtml+xml',
        'xhtml'   => 'application/xhtml+xml',
        'xls'     => 'application/vnd.ms-excel',
        'xml'     => 'application/xml',
        'xpm'     => 'image/x-xpixmap',
        'xsl'     => 'application/xml',
        'xslt'    => 'application/xslt+xml',
        'xul'     => 'application/vnd.mozilla.xul+xml',
        'xwd'     => 'image/x-xwindowdump',
        'xyz'     => 'chemical/x-xyz',
        'zip'     => 'application/zip'
    );

    public function __construct($app)
    {
    }

    public function getPermittedExtensions()
    {
        return [
            'jpg'=>'image',
            'jpeg'=>'image',
            'png'=>'image',
            'svg'=>'image',
            'webp'=>'image',
            'gif'=>'image',
            'mp4'=>'video',
            'mpg'=>'video',
            'mpeg'=>'video',
            'webm'=>'video',
            'ogg'=>'video',
            'avi'=>'video',
            'mov'=>'video',
            'flv'=>'video',
            'swf'=>'video',
            'mkv'=>'video',
            'wmv'=>'video',
            'wma'=>'audio',
            'aac'=>'audio',
            'wav'=>'audio',
            'mp3'=>'audio',
            'zip'=>'archive',
            'rar'=>'archive',
            '7z'=>'archive',
            'doc'=>'document',
            'txt'=>'document',
            'docx'=>'document',
            'pdf'=>'document',
            'csv'=>'document',
            'xml'=>'document',
            'ods'=>'document',
            'xlr'=>'document',
            'xls'=>'document',
            'xlsx'=>'document',
        ];
    }

   public function ext2mime($ext) {
        return $this->extension2mime[$ext] ?? null;
   }

   public function mime2ext($mime) {
        return array_flip($this->extension2mime)[$mime] ?? null;
   }

   public function getTenantPath($folder = null) {
       if(!empty($folder)) {
            return 'uploads/'.tenant('id').'/'.trim($folder, '/');
       }

       return 'uploads/'.tenant('id');
   }
      
   /**
    * generateFilePath
    *
    * Generates full Storage $file_path based on provided parameters
    *
    * @param  mixed $path
    * @param  mixed $name
    * @param  mixed $extension
    * @param  mixed $with_hash
    * @return string
    */
   public function generateFilePath($path, $name, $extension, $with_hash = true) {
    $hash  = '';

    if($with_hash) {
        $hash = '-' . substr(bin2hex(openssl_random_pseudo_bytes(ceil(20 / 2)) ), 0, 20 );
    }

    return $this->getTenantPath($path). '/' . Str::slug($name, '-') . $hash . '.' . $extension;
}

   /**
    * storeAsUploadFromFile
    *
    * This functions creates Upload from the stored file (external or from storage) and
    * creates UploadRelationship between $model(s) and newly created Upload
    * 
    * @param  mixed $model
    * @param  mixed $file
    * @param  mixed $property_name
    * @param  mixed $file_display_name
    * @param  mixed $user_id - can be both integer (user ID) or User model
    * @param  mixed $shop_id - can be both integer (shpo ID) or Shop model
    * @return Upload
    */
   public function storeAsUploadFromFile(&$model, $file, $property_name, $file_display_name = null, $user_id = null, $shop_id = null) {

        if(is_string($file)) {
            $file_path = $file;
            $file = new SplFileInfo(Storage::url($file_path));
        }

        if($file instanceof SplFileInfo) {
            $extension = $file->getExtension();
            $new_file_original_name = !empty($file_display_name) ? $file_display_name : $file->getFilename();
            $new_filename = $file->getFilename();
            $new_file_size = Storage::size($file_path);
        } else if($file instanceof File) {
            $extension = $file->guessExtension();
            $new_file_original_name = !empty($file_display_name) ? $file_display_name : $file->getClientOriginalName();
            $new_filename = time().'_'.preg_replace("/\s+/", "", $new_file_original_name);
            $new_file_size = $file->getSize();
        }

        // Save Upload to DB
        try {
            $upload = Upload::where('file_name', $file_path)->firstOrFail();
        } catch(\Exception $e) {
            $upload = new Upload();
        }

        // Determine user_id for the Upload
        if(empty($user_id)) {
            if(is_array($model) || $model instanceof Collection) {
                // Provided $model is array or collection of multiple model instances
                $user_id = $model->first()?->user_id ?? (auth()->user()?->id ?? null);
            } else {
                // Provided $model is a single model isntance
                $user_id = $model?->user_id ?? (auth()->user()?->id ?? null);
            }
        } else {
            if($user_id instanceof User) {
                $user_id = $user_id->id;
            }
        }

        // Determine shop_id for the Upload
        if(empty($shop_id)) {
            if(is_array($model) || $model instanceof Collection) {
                // Provided $model is array or collection of multiple model instances
                $shop_id = $model->first()?->shop_id ?? null;
            } else {
                // Provided $model is a single model isntance
                $shop_id = $model?->shop_id ?? null;
            }
        } else {
            if($shop_id instanceof Shop) {
                $shop_id = $shop_id->id;
            }
        }

        $upload->extension = $extension;
        $upload->file_name = $file_path;
        $upload->user_id = $user_id;
        $upload->shop_id = $shop_id;
        $upload->type = MediaService::getPermittedExtensions()[$extension];
        $upload->file_size = $new_file_size;

        $upload->file_original_name = $new_file_original_name;

        if(empty($file_display_name)) {
            $arr = explode('.', $new_file_original_name);
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= '.'.$arr[$i];
                }
            }
        }
        
        $upload->save();
        
        // Save Relationship between $model and $upload to DB 
        if(!empty($property_name)) {

            $uploadsSyncing = function($model) use($property_name, $upload) {
                // Differentiate logic between properties with multiple files and one file
                if($model->getUploadPropertyDefinition($property_name)['multiple'] ?? false) {
                    // Multiple uploads in property - get the current uploads ids from property, push the new upload ID, filter unique values, and reset keys
                    $model->{$property_name} = collect($model->{$property_name})->pluck('id')?->push($upload->id)?->unique()?->values() ?? [$upload->id];
                } else {
                    // Single upload in property
                    $model->{$property_name} = $upload;
                }

                $model->syncUploads($property_name);
            };
            
            if(is_array($model) || $model instanceof Collection) {
                // Logic when $model is an array|Collection of models
                foreach($model as $subject) {
                    $uploadsSyncing($subject);
                }
            } else {
                // Logic when $model is single model
                $uploadsSyncing($model);
            }
        }

        return $upload;
   }

   public function uploadToStorage($contents, $path, $name, $extension, $with_hash = true, $headers = []) {
        $hash  = '';

        if($with_hash) {
            $hash = '-' . substr(bin2hex(openssl_random_pseudo_bytes(ceil(20 / 2)) ), 0, 20 );
        }

        $file_path = $this->generateFilePath($path, $name, $extension, $with_hash);

        $file = Storage::put($file_path, $contents, $headers);

        if(!$file)
            return false;
        
        return $file_path;
   }

   public function uploadAndStore(&$model, $contents, $path, $name, $extension, $property_name, $with_hash = true, $file_display_name = '', $upload_tag = null, $user_id = null, $shop_id = null, $headers = []) {
        DB::beginTransaction();
        $upload = null;

        try {
            $file_path = MediaService::uploadToStorage($contents, $path, $name, $extension, $with_hash, $headers);

            if (!$file_path) {
                // The file could not be written to disk...
                throw new Exception('File could not be written to Storage.');
            }

            // Create Upload record based on file_path in Storage and sync $model->{$property_name} property (aka create UploadRelationship)
            $upload = MediaService::storeAsUploadFromFile(
                model: $model, 
                file: $file_path, 
                property_name: $property_name, 
                file_display_name: $file_display_name, 
                user_id: $user_id,
                shop_id: $shop_id
            );

            if($upload_tag) {
                $upload->setWEF('upload_tag', $upload_tag);
            }

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();

            if(isset($file_path) && !empty($file_path)) {
                // If uploading file to storage was successful, $file_path is set and not empty, hence why we need to delete the file from the Storage
                Storage::delete($file_path);
            }

            Log::error($e);

            // dd($e); // for testing purposes
            return false;
        }

        return $upload;
   }

   public function deleteFileFromStorage($file_path) {
        // File path can be either string or Upload!
        $file_path = $this->getTenantPath($path);


   }
}
