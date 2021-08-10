<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\UploadsGroup;
use App\Models\UploadsContentRelationship;
use App\Models\Seller;
use App\Models\User;
use App\Http\Requests\DocumentGalleryRequest;

class DocumentGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller = auth()->user()->seller;
        return view('frontend.document_gallery.index', compact(['seller']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentGalleryRequest $request)
    {
        //Create new upload group
        $uploads_group = new UploadsGroup;
        $uploads_group->name = $request->name;
        $uploads_group->description = $request->description;
        $uploads_group->type = $request->group_type;
        $uploads_group->user_id = Seller::findOrFail($request->id)->user->id;
        $uploads_group->save();

        $subject_type = "App\Models\Seller";
        $subject_id = $request->id;

        //Create upload group contents
        if ($request->thumbnail_img != null) {
            $ids = explode(",", $request->thumbnail_img);
            foreach ($ids as $key => $id) {
                $this->createUploadContent($subject_type, $subject_id, $id, "thumbnail", $uploads_group->id);
            }
        }

        if ($request->photos != null) {
            $ids = explode(",", $request->photos);
            foreach ($ids as $key => $id) {
                $this->createUploadContent($subject_type, $subject_id, $id, "image", $uploads_group->id);
            }
        }

        if ($request->document_file != null) {
            $ids = explode(",", $request->document_file);
            foreach ($ids as $key => $id) {
                $this->createUploadContent($subject_type, $subject_id, $id, "document", $uploads_group->id);
            }
        }

        return back();
    }

    function createUploadContent($subject_type, $subject_id, $upload_id, $type, $group_id) {
        $uploads_content_relationship = new UploadsContentRelationship;
        $uploads_content_relationship->subject_type = $subject_type;
        $uploads_content_relationship->subject_id = $subject_id;
        $uploads_content_relationship->upload_id = $upload_id;
        $uploads_content_relationship->type = $type;
        $uploads_content_relationship->group_id = $group_id;
        $uploads_content_relationship->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $upload_group = UploadsGroup::findOrFail($id);
        $group_type = 'document';
        $document = $upload_group->uploads_content_relations->where('type', 'document')->first();
        if (!$document) {
            $group_type = 'gallery';
        }

        return view('frontend.document_gallery.edit', compact(['upload_group', 'group_type']));
    }

    public function seller_document_gallery_edit($id) {
        $upload_group = UploadsGroup::findOrFail($id);
        $group_type = 'document';
        $document = $upload_group->uploads_content_relations->where('type', 'document')->first();
        if (!$document) {
            $group_type = 'gallery';
        }

        return view('backend.sellers.document_gallery.edit', compact(['upload_group', 'group_type']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentGalleryRequest $request, $id)
    {
        $uploads_group = UploadsGroup::findOrFail($id);
        $uploads_group->name = $request->name;
        $uploads_group->description = $request->description;
        $uploads_group->save();

        $subject_type = "App\Models\Seller";
        $subject_id = User::findOrFail($uploads_group->user_id)->seller->id;

        // Delete old relations
        $uploads_group->uploads_content_relations()->delete();

        //Update upload group contents
        if ($request->thumbnail_img != null) {
            $this->createUploadContent($subject_type, $subject_id, $request->thumbnail_img, "thumbnail", $uploads_group->id);
        }

        if ($request->photos != null) {
            $ids = explode(",", $request->photos);
            foreach ($ids as $key => $id) {
                $this->createUploadContent($subject_type, $subject_id, $id, "image", $uploads_group->id);
            }
        }

        if ($request->document_file != null) {
            $this->createUploadContent($subject_type, $subject_id, $request->document_file, "document", $uploads_group->id);
        }

        flash(translate('Updated successfully'))->success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $upload_group = UploadsGroup::where('id', $id)->first();
        if($upload_group) $upload_group->delete();
        flash(translate('Deleted successfully'))->success();
        return back();
    }

    public function seller_document_gallery($id) {
        $seller = Seller::findOrFail($id);
        return view('backend.sellers.document_gallery.index', compact(['seller']));
    }
}
