<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Response;
use Auth;
use Image;
use File;

class AizUploadController extends Controller
{


    public function index(Request $request){

        $all_uploads = Upload::query();
        $search = null;
        $sort_by = null;

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(60)->appends(request()->query());

        return view('backend.uploaded_files.index', compact('all_uploads', 'search', 'sort_by') );
    }

    public function create(){
        return view('backend.uploaded_files.create');
    }


    public function show_uploader(Request $request){
        return view('uploader.aiz-uploader');
    }

    public function upload(Request $request){
        $type = array(
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
            "mp4"=>"video",
            "mpg"=>"video",
            "mpeg"=>"video",
            "webm"=>"video",
            "ogg"=>"video",
            "avi"=>"video",
            "mov"=>"video",
            "flv"=>"video",
            "swf"=>"video",
            "mkv"=>"video",
            "wmv"=>"video",
            "wma"=>"audio",
            "aac"=>"audio",
            "wav"=>"audio",
            "mp3"=>"audio",
            "zip"=>"archive",
            "rar"=>"archive",
            "7z"=>"archive",
            "doc"=>"document",
            "txt"=>"document",
            "docx"=>"document",
            "pdf"=>"document",
            "csv"=>"document",
            "xml"=>"document",
            "ods"=>"document",
            "xlr"=>"document",
            "xls"=>"document",
            "xlsx"=>"document"
        );

        if($request->hasFile('aiz_file')){
            $upload = new Upload;
            $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());

            if(isset($type[$extension])){
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }


                $tenant_path = 'uploads/all';

                if(tenant('id')) {
                    $data = tenant('id');
//                  return response()->json($data, 200);

                    $tenant_path = 'uploads/'.tenant('id');
                }

                // Check if tenant uploads folder exists an create it if not
                if(!Storage::exists($tenant_path)){
                    // Create Tenant folder on DO if it doesn't exist
                    Storage::makeDirectory($tenant_path, 0775, true, true);
                }

                $file = $request->file('aiz_file');
                $name = time() . '_' . $file->getClientOriginalName();
                $filepath = $tenant_path.'/'.$name;
                Storage::disk('s3')->put($filepath, file_get_contents($file), 'public');

                $size = $file->getSize();

                $upload->extension = $extension;
                $upload->file_name = $filepath;
                $upload->user_id = auth()->user()->id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
                $data = ['upload_id' => $upload->id];
            } else {
                $data = ['no-data'];
            }


            return response()->json($data, 200);
        }
    }

    public function get_uploaded_files(Request $request)
    {
        $uploads = Upload::where('user_id', auth()->user()->id);
        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        return $uploads->paginate(60)->appends(request()->query());
    }

    public function destroy(Request $request,$id)
    {
        try{
            if(config('filesystems.default') == 's3'){
                Storage::disk('s3')->delete(Upload::where('id', $id)->first()->file_name);
            }
            else{
                unlink(public_path().'/'.Upload::where('id', $id)->first()->file_name);
            }
            Upload::destroy($id);
            flash(translate('File deleted successfully'))->success();
        }
        catch(\Exception $e){
            Upload::destroy($id);
            flash(translate('File deleted successfully'))->success();
        }
        return back();
    }

    public function get_preview_files(Request $request){
        $ids = explode(',', $request->ids);
        $files = Upload::whereIn('id', $ids)->get();
        return $files;
    }

    //Download project attachment
    public function attachment_download($id)
    {
        $project_attachment = Upload::find($id);
        try{
           $file_path = public_path($project_attachment->file_name);
            return Response::download($file_path);
        }catch(\Exception $e){
            flash(translate('File does not exist!'))->error();
            return back();
        }

    }
    //Download project attachment
    public function file_info(Request $request)
    {
        $file = Upload::findOrFail($request['id']);
        return view('backend.uploaded_files.info',compact('file'));
    }

}
