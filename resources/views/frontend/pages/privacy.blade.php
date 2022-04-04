@extends('frontend.layouts.' . $globalLayout)

@section('meta')
@endsection

@section('content')
<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/typography'),
    ],
  }
  ```
-->
<div class="relative py-16 bg-white overflow-hidden">
    <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
        <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
            <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none"
                viewBox="0 0 404 384">
                <defs>
                    <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
            </svg>
            <svg class="absolute top-1/2 right-full transform -translate-y-1/2 -translate-x-32" width="404" height="384"
                fill="none" viewBox="0 0 404 384">
                <defs>
                    <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
            </svg>
            <svg class="absolute bottom-12 left-full transform translate-x-32" width="404" height="384" fill="none"
                viewBox="0 0 404 384">
                <defs>
                    <pattern id="d3eb07ae-5182-43e6-857d-35c643af9034" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="384" fill="url(#d3eb07ae-5182-43e6-857d-35c643af9034)" />
            </svg>
        </div>
    </div>
    <div class="relative px-4 sm:px-6 lg:px-8">
        <div class="text-lg max-w-prose mx-auto">
            <h1>
                <span class="block text-base text-center text-indigo-600 font-semibold tracking-wide uppercase">
                    {{ get_site_name() }}
                </span>
                <span
                    class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ translate('Privacy Policy') }}
                </span>
            </h1>
            <p class="mt-8 text-xl text-gray-500 leading-8">

                {{ translate("Our Company is part of the Our Company Group which includes Our Company International and
                Our Company Direct. This privacy policy will explain how our organization uses the personal data we
                collect from you when you use our website.
                Topics:") }}
            </p>
        </div>
        <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

            <ul role="list">
                <li>What data do we collect?</li>
                <li>How do we collect your data?</li>
                <li>How will we use your data?</li>
                <li>How do we store your data?</li>
                <li>Marketing</li>
                <li>What are your data protection rights?</li>
                <li>What are cookies?</li>
                <li>How do we use cookies?</li>
                <li>What types of cookies do we use?</li>
                <li>How to manage your cookies</li>
                <li>Changes to our privacy policy</li>
                <li>How to contact us</li>
                <li>How to contact the appropriate authorities</li>
            </ul>
            <p>Quis semper vulputate aliquam venenatis egestas sagittis quisque orci. Donec commodo sit viverra aliquam
                porttitor ultrices gravida eu. Tincidunt leo, elementum mattis elementum ut nisl, justo, amet, mattis.
                Nunc purus, diam commodo tincidunt turpis. Amet, duis sed elit interdum dignissim.</p>
            <h2>{{ translate('What data do we collect?') }}</h2>
            <p>
                {{ translate("Our Company collects the following data:
                Personal identification information (Name, email address, phone number, etc.)
                ") }}

            </p>

            <h2>
                {{ translate('How do we collect your data?') }}
            </h2>
            <p>You directly provide Our Company with most of the data we collect. We collect data and process data when you:
                Register online or place an order for any of our products or services.
                Voluntarily complete a customer survey or provide feedback on any of our message boards or via email.
                Use or view our website via your browser’s cookies.
                Our Company may also receive your data indirectly from the following sources
            <ul>
                <li>Google Analytics</li>
                <li>Facebook</li>
            </ul>
            </p>
        </div>
    </div>
</div>


@endsection
