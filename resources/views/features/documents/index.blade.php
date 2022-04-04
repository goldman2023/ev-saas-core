@extends('frontend.layouts.user_panel')

@section('panel_content')
<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<div>
    <div class="md:grid md:grid-cols-4 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <span
                    class="w-50 mt-7 py-0.5 px-3 rounded-full text-xs font-semibold text-blue-800 bg-blue-100 dark:text-blue-50 dark:bg-blue-500 mr-2"
                    style="">
                    {{ translate('Purchase agreement') }}
                </span>
                <br>
                <span
                    class="w-50 mt-7 py-0.5 px-3 rounded-full text-xs font-semibold text-red-800 bg-red-100 dark:text-blue-50 dark:bg-blue-500"
                    style="">
                    {{ translate('Signature Required') }}
                </span>
                <h3 class="mt-3 text-lg font-medium leading-6 text-gray-900">
                    {{ translate('Signing document') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 mb-3">
                    This information will be displayed publicly so be careful what you share.</p>
                <div clas="text-center border-b">

                    <a target="_blank" href="https://app.dokobit.com/signing/9af5f35d8a1cef1353330c75ff1bae030099a751"
                        type="submit"
                        class="mb-2 inline-flex justify-center py-4 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ translate('Sign with eSignature') }}
                    </a>
                    <div class="text-xs text-gray-400">
                        {{ translate('Document signing powered by Dokobit') }}
                    </div>


                </div>
                <div class="mt-6">
                    @include('features.documents.elements.actions-timeline')

                </div>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-3 mb-6">
            <iframe src="http://www.africau.edu/images/default/sample.pdf" style="min-height: 100vh" title="testPdf"
                height="100%" width="100%"></iframe>

            <a target="_blank" href="https://app.dokobit.com/signing/9af5f35d8a1cef1353330c75ff1bae030099a751"
                type="submit"
                class="mt-6 mb-6 text-center mb-2 block justify-center py-6 px-8 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ translate('Sign with eSignature') }}
            </a>
        </div>
    </div>
</div>



@endsection
