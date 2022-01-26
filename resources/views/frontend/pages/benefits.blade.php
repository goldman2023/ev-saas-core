@extends('frontend.layouts.' . $globalLayout)

@section('content')
    <!-- Team Section -->
    <section>
        {{-- TODO: add sections for showing off benefits like:
            While-Label
            GDPR Compliant
            100% Secure Payments
            Automated Backups
            Uptime Guarantee
            24/7 Support (In the future)
            SEO + Schema.org
            Social Media Integration
            Social Commerce
            Email Marketing
            Inteligent Search
            Proven UX
            Mobile-First Ready
            Accounting Integrations
            Advanced Custom Domains Management
            Source-of-truth point
            Unlimited Users, revenue, storage and traffic
            Dedicated resources
            Multi-Tenancy Support
            Full-Service Option

            Aditional Option:
            Startup Kit - 15$k + 6 months of subscription

            --}}
        <x-default.promo.features></x-default.promo.features>
    </section>
@endsection
