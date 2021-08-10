<?php

namespace App\Http\Controllers;

use App\Models\AffiliateBanner;
use App\Traits\LoggingTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Mpdf\Tag\Input;

class AffiliateBannerController extends Controller
{
    use LoggingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $affiliate_banners = AffiliateBanner::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $affiliate_banners = $affiliate_banners->where('title', 'like', '%' . $sort_search . '%');
        }
        $affiliate_banners = $affiliate_banners->paginate(15);
        return view('backend.marketing.affiliate_banner.index', compact('affiliate_banners', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.marketing.affiliate_banner.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'banner' => 'required|int',
            'date_range' => 'required',
            'refer_url' => 'required|url',
            'campaign' => 'required'
        ]);
        $affiliate_banner = new AffiliateBanner;
        $affiliate_banner->title = $request->title;
        $date_var = explode(" to ", $request->date_range);
        $affiliate_banner->start_date = strtotime($date_var[0]);
        $affiliate_banner->end_date = strtotime($date_var[1]);
        $affiliate_banner->banner = $request->banner;
        $affiliate_banner->refer_url = $request->refer_url;
        $affiliate_banner->campaign = $request->campaign;
        if ($affiliate_banner->save()) {
            flash(translate('Affiliate Banner has been inserted successfully'))->success();
            return redirect()->route('admin.affiliate_banner.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $affiliate_banner = AffiliateBanner::findOrFail($id);
        return view('backend.marketing.affiliate_banner.edit', compact('affiliate_banner', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'banner' => 'required|int',
            'date_range' => 'required',
            'refer_url' => 'required|url',
            'campaign' => 'required'
        ]);
        $affiliate_banner = AffiliateBanner::findOrFail($id);

        $affiliate_banner->title = $request->title;
        $date_var = explode(" to ", $request->date_range);
        $affiliate_banner->start_date = strtotime($date_var[0]);
        $affiliate_banner->end_date = strtotime($date_var[1]);
        $affiliate_banner->banner = $request->banner;
        $affiliate_banner->refer_url = $request->refer_url;
        $affiliate_banner->campaign = $request->campaign;
        if ($affiliate_banner->save()) {
            flash(translate('AffiliateBanner has been updated successfully'))->success();
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $affiliate_banner = AffiliateBanner::findOrFail($id);
        AffiliateBanner::destroy($id);
        flash(translate('Affiliate Banner has been deleted successfully'))->success();
        return redirect()->route('admin.affiliate_banner.index');
    }
    /**
     * Use it to track links comming from banners click
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function track($id)
    {
        $affiliate_banner = AffiliateBanner::findOrFail($id);
        $affiliate_banner->clicks++;
        if($affiliate_banner){
            $utm_query = [
                'utm_source' => 'b2bwood',
                'utm_campaign' => $affiliate_banner->campaign,
                'utm_medium' => 'cpc',
                'utm_content' => $affiliate_banner->title
                ];
            $affiliate_banner->save();
            if(auth()->user())
            {
                $this->log($affiliate_banner,"user clicked on the following banner");
            }
            return redirect()->away(qs_url($affiliate_banner->refer_url,$utm_query));
        }else{
            return back();
        }
    }
}
